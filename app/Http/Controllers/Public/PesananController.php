<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\OlehOleh;
use App\Models\PaketBundling;
use App\Models\Pesanan;
use App\Models\TiketWahana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class PesananController extends Controller
{
    public function keranjang()
    {
        $cart = session()->get('keranjang', []);

        if (!is_array($cart)) {
            $cart = [];
        }

        return view('public.pesanan.keranjang', [
            'cart' => $cart,
            'total' => $this->hitungTotal($cart),
        ]);
    }

    public function tambah(Request $request)
    {
        $type = $request->input('type') ?? $request->input('jenis');

        if (!$type || !in_array($type, ['menu', 'wahana', 'oleh_oleh', 'bundling'], true)) {
            return back()->withInput()->with('error', 'Jenis produk tidak valid.');
        }

        $id = $request->input('id');

        if ($id === null || !is_numeric($id) || (int) $id < 1) {
            return back()->withInput()->with('error', 'Produk tidak ditemukan.');
        }

        $id = (int) $id;
        $qty = $request->input('qty', 1);

        if (!is_numeric($qty) || (int) $qty < 1) {
            return back()->withInput()->with('error', 'Jumlah produk minimal 1.');
        }

        $qty = min((int) $qty, 99);
        $product = $this->ambilProduk($type, $id);

        if (!$product) {
            return back()->with('error', 'Produk yang dipilih tidak ditemukan.');
        }

        $harga = $this->ambilHarga($type, $product);

        if ($harga === null || $harga < 0) {
            return back()->with('error', 'Harga produk tidak ditemukan.');
        }

        $key = $type . '_' . $id;
        $cart = session()->get('keranjang', []);

        if (!is_array($cart)) {
            $cart = [];
        }

        if (isset($cart[$key])) {
            $cart[$key]['qty'] = min((int) ($cart[$key]['qty'] ?? 0) + $qty, 99);
            $cart[$key]['harga'] = (int) ($cart[$key]['harga'] ?? $harga);
            $cart[$key]['subtotal'] = $cart[$key]['harga'] * $cart[$key]['qty'];
        } else {
            $cart[$key] = [
                'key' => $key,
                'type' => $type,
                'id' => $id,
                'nama' => $this->ambilNama($type, $product),
                'harga' => (int) $harga,
                'qty' => $qty,
                'gambar' => $this->ambilGambar($product),
                'subtotal' => (int) $harga * $qty,
            ];
        }

        session()->put('keranjang', $cart);
        session()->save();

        return redirect()->route('pesanan.keranjang')
            ->with('success', $cart[$key]['nama'] . ' berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => ['required', 'string'],
            'qty' => ['required', 'integer', 'min:1', 'max:99'],
        ], [
            'key.required' => 'Item tidak ditemukan.',
            'qty.required' => 'Jumlah wajib diisi.',
            'qty.integer' => 'Jumlah harus berupa angka.',
            'qty.min' => 'Jumlah minimal 1.',
            'qty.max' => 'Jumlah maksimal 99.',
        ]);

        $key = $request->input('key');
        $qty = (int) $request->input('qty');
        $cart = session()->get('keranjang', []);

        if (!is_array($cart)) {
            $cart = [];
        }

        if (!isset($cart[$key])) {
            return back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $cart[$key]['qty'] = $qty;
        $cart[$key]['subtotal'] = (int) ($cart[$key]['harga'] ?? 0) * $qty;

        session()->put('keranjang', $cart);
        session()->save();

        return back()->with('success', 'Jumlah pesanan berhasil diperbarui.');
    }

    public function hapus($key)
    {
        $cart = session()->get('keranjang', []);

        if (!is_array($cart)) {
            $cart = [];
        }

        if (!isset($cart[$key])) {
            return back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $nama = $cart[$key]['nama'] ?? 'Produk';
        unset($cart[$key]);

        session()->put('keranjang', $cart);
        session()->save();

        return back()->with('success', $nama . ' berhasil dihapus dari keranjang.');
    }

    public function kosongkan()
    {
        session()->forget('keranjang');
        session()->save();

        return redirect()->route('pesanan.keranjang')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function checkout()
    {
        $cart = session()->get('keranjang', []);

        if (!is_array($cart)) {
            $cart = [];
        }

        if (empty($cart)) {
            return redirect()->route('pesanan.keranjang')
                ->with('error', 'Keranjang masih kosong.');
        }

        return view('public.pesanan.pembayaran', [
            'cart' => $cart,
            'total' => $this->hitungTotal($cart),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'max:20'],
            'metode_pembayaran' => ['required', 'in:Cash,QRIS'],
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'nama_pelanggan.max' => 'Nama pelanggan maksimal 255 karakter.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 20 karakter.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid.',
        ]);

        $cart = session()->get('keranjang', []);

        if (!is_array($cart) || empty($cart)) {
            return redirect()->route('pesanan.keranjang')
                ->with('error', 'Keranjang masih kosong.');
        }

        if (!$this->keranjangValid($cart)) {
            return redirect()->route('pesanan.keranjang')
                ->with('error', 'Isi keranjang tidak valid. Silakan hapus produk lalu tambahkan kembali.');
        }

        $total = $this->hitungTotal($cart);

        if ($total < 1) {
            return back()->withInput()->with('error', 'Total pembayaran tidak valid.');
        }

        $isQris = $validated['metode_pembayaran'] === 'QRIS';

        if ($isQris) {
            if (!config('services.midtrans.server_key') || !config('services.midtrans.client_key')) {
                return back()->withInput()->with('error', 'Konfigurasi Midtrans belum lengkap. Periksa file .env dan config/services.php.');
            }

            if ($this->midtransIsProduction()) {
                return back()->withInput()->with('error', 'Mode Production belum diaktifkan untuk alur pengujian ini. Gunakan Midtrans Sandbox terlebih dahulu.');
            }
        }

        $pesanan = null;

        try {
            $pesanan = DB::transaction(function () use ($validated, $cart, $total) {
                $pesanan = Pesanan::create([
                    'id_user' => null,
                    'kode_pesanan' => $this->buatKodePesanan(),
                    'nama_pelanggan' => trim($validated['nama_pelanggan']),
                    'no_wa' => $this->normalisasiNomorWa($validated['no_wa']),
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'total_harga' => $total,
                    'status' => 'Menunggu Pembayaran',
                ]);

                foreach ($cart as $item) {
                    $detail = [
                        'id_pesanan' => $pesanan->id_pesanan,
                        'id_menu' => null,
                        'id_tiket_wahana' => null,
                        'id_oleh_oleh' => null,
                        'id_paket_bundling' => null,
                        'qty' => (int) $item['qty'],
                        'harga' => (int) $item['harga'],
                        'subtotal' => (int) $item['harga'] * (int) $item['qty'],
                        'status_item' => 'Menunggu',
                    ];

                    switch ($item['type']) {
                        case 'menu':
                            $detail['id_menu'] = (int) $item['id'];
                            break;
                        case 'wahana':
                            $detail['id_tiket_wahana'] = (int) $item['id'];
                            break;
                        case 'oleh_oleh':
                            $detail['id_oleh_oleh'] = (int) $item['id'];
                            break;
                        case 'bundling':
                            $detail['id_paket_bundling'] = (int) $item['id'];
                            break;
                        default:
                            throw new \RuntimeException('Jenis produk dalam keranjang tidak valid.');
                    }

                    DetailPesanan::create($detail);
                }

                return $pesanan;
            });

            if ($isQris) {
                $this->aturMidtrans();

                $itemDetails = [];

                foreach ($cart as $item) {
                    $itemDetails[] = [
                        'id' => substr($item['type'] . '_' . $item['id'], 0, 50),
                        'price' => (int) $item['harga'],
                        'quantity' => (int) $item['qty'],
                        'name' => mb_substr((string) ($item['nama'] ?? 'Produk'), 0, 50),
                    ];
                }

                $params = [
                    'transaction_details' => [
                        'order_id' => $pesanan->kode_pesanan,
                        'gross_amount' => (int) $pesanan->total_harga,
                    ],
                    'item_details' => $itemDetails,
                    'customer_details' => [
                        'first_name' => trim($pesanan->nama_pelanggan),
                        'phone' => $pesanan->no_wa,
                    ],
                    'enabled_payments' => ['other_qris'],
                    'callbacks' => [
                        'finish' => route('pesanan.berhasil', ['kode' => $pesanan->kode_pesanan]),
                    ],
                ];

                $snap = Snap::createTransaction($params);

                if (empty($snap->redirect_url) || empty($snap->token)) {
                    throw new \RuntimeException('Midtrans tidak mengembalikan URL atau token pembayaran.');
                }

                session()->forget('keranjang');
                session()->put('pesanan_terakhir', $pesanan->id_pesanan);
                session()->save();

                return redirect()->away($snap->redirect_url);
            }

            session()->forget('keranjang');
            session()->put('pesanan_terakhir', $pesanan->id_pesanan);
            session()->save();

            return redirect()->route('pesanan.berhasil', ['kode' => $pesanan->kode_pesanan])
                ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran Cash kepada petugas.');
        } catch (\Throwable $e) {
            Log::error('Gagal membuat pesanan atau transaksi Midtrans.', [
                'message' => $e->getMessage(),
                'order_id' => $pesanan instanceof Pesanan ? $pesanan->kode_pesanan : null,
                'metode_pembayaran' => $validated['metode_pembayaran'],
            ]);

            if ($pesanan instanceof Pesanan && $pesanan->exists && $isQris) {
                try {
                    DB::transaction(function () use ($pesanan) {
                        $lockedPesanan = Pesanan::where('id_pesanan', $pesanan->id_pesanan)
                            ->lockForUpdate()
                            ->first();

                        if ($lockedPesanan && $lockedPesanan->status === 'Menunggu Pembayaran') {
                            $lockedPesanan->status = 'Pembayaran Gagal';
                            $lockedPesanan->save();
                        }
                    });
                } catch (\Throwable $statusError) {
                    Log::error('Gagal memperbarui status pesanan setelah transaksi Midtrans gagal.', [
                        'order_id' => $pesanan->kode_pesanan,
                        'message' => $statusError->getMessage(),
                    ]);
                }
            }

            return back()->withInput()
                ->with('error', 'Pesanan atau transaksi pembayaran gagal dibuat. Silakan coba lagi. Jika masalah berlanjut, periksa log Laravel di storage/logs/laravel.log.');
        }
    }

    public function midtransNotification(Request $request)
    {
        $payload = $request->all();
        $serverKey = config('services.midtrans.server_key');

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;

        if (
            !is_string($orderId) || $orderId === '' ||
            $statusCode === null ||
            !is_numeric($grossAmount) ||
            !is_string($signatureKey) || $signatureKey === '' ||
            !is_string($serverKey) || $serverKey === ''
        ) {
            return response()->json(['message' => 'Invalid notification payload.'], 400);
        }

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if (!hash_equals($expectedSignature, $signatureKey)) {
            Log::warning('Signature notifikasi Midtrans tidak valid.', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature.'], 403);
        }

        if (isset($payload['currency']) && strtoupper((string) $payload['currency']) !== 'IDR') {
            return response()->json(['message' => 'Unsupported currency.'], 422);
        }

        $transactionStatus = strtolower((string) ($payload['transaction_status'] ?? ''));
        $fraudStatus = strtolower((string) ($payload['fraud_status'] ?? ''));
        $result = DB::transaction(function () use (
            $orderId,
            $grossAmount,
            $transactionStatus,
            $fraudStatus,
            $payload
        ) {
            $pesanan = Pesanan::where('kode_pesanan', $orderId)
                ->lockForUpdate()
                ->first();

            if (!$pesanan || $pesanan->metode_pembayaran !== 'QRIS') {
                return ['status' => 404, 'message' => 'Order not found.'];
            }

            $notifiedAmount = (int) round((float) $grossAmount * 100);
            $orderAmount = (int) round((float) $pesanan->total_harga * 100);

            if ($notifiedAmount !== $orderAmount) {
                Log::warning('Nominal notifikasi Midtrans tidak sesuai dengan pesanan.', [
                    'kode_pesanan' => $orderId,
                    'gross_amount' => $grossAmount,
                    'total_pesanan' => $pesanan->total_harga,
                ]);

                return ['status' => 422, 'message' => 'Amount mismatch.'];
            }

            if (!in_array($transactionStatus, ['settlement', 'capture', 'pending', 'deny', 'cancel', 'expire'], true)) {
                Log::info('Status notifikasi Midtrans tidak memerlukan perubahan status pesanan.', [
                    'kode_pesanan' => $orderId,
                    'transaction_status' => $transactionStatus,
                ]);

                return ['status' => 200, 'message' => 'Notification acknowledged.'];
            }

            $statusSebelumnya = $pesanan->status;
            $statusPembayaranBerhasil = $transactionStatus === 'settlement'
                || ($transactionStatus === 'capture' && $fraudStatus === 'accept');

            if ($statusPembayaranBerhasil) {
                if (!in_array($statusSebelumnya, ['Selesai', 'Batal'], true)) {
                    $pesanan->status = 'Menunggu Pengambilan';
                }

                Log::info('Pembayaran QRIS Midtrans berhasil dikonfirmasi.', [
                    'kode_pesanan' => $pesanan->kode_pesanan,
                    'transaction_id' => $payload['transaction_id'] ?? null,
                    'status_sebelumnya' => $statusSebelumnya,
                    'status_sekarang' => $pesanan->status,
                ]);
            } elseif ($transactionStatus === 'pending') {
                if ($statusSebelumnya === 'Menunggu Pembayaran') {
                    $pesanan->status = 'Menunggu Pembayaran';
                }
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'], true)) {
                if ($statusSebelumnya === 'Menunggu Pembayaran') {
                    $pesanan->status = 'Pembayaran Gagal';
                }
            }

            if ($pesanan->isDirty('status')) {
                $pesanan->save();
            }

            return ['status' => 200, 'message' => 'Notification processed.'];
        });

        return response()->json(['message' => $result['message']], $result['status']);
    }

    public function berhasil($kode)
    {
        $pesanan = Pesanan::with([
            'details.menu',
            'details.tiketWahana',
            'details.olehOleh',
            'details.paketBundling',
        ])->where('kode_pesanan', $kode)->firstOrFail();

        return view('public.pesanan.berhasil', compact('pesanan'));
    }

    private function aturMidtrans(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = $this->midtransIsProduction();
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    private function midtransIsProduction(): bool
    {
        return filter_var(config('services.midtrans.is_production', false), FILTER_VALIDATE_BOOLEAN);
    }

    private function keranjangValid(array $cart): bool
    {
        foreach ($cart as $item) {
            if (
                !is_array($item) ||
                !isset($item['type'], $item['id'], $item['harga'], $item['qty']) ||
                !in_array($item['type'], ['menu', 'wahana', 'oleh_oleh', 'bundling'], true) ||
                !is_numeric($item['id']) ||
                (int) $item['id'] < 1 ||
                !is_numeric($item['harga']) ||
                (int) $item['harga'] < 0 ||
                !is_numeric($item['qty']) ||
                (int) $item['qty'] < 1 ||
                (int) $item['qty'] > 99
            ) {
                return false;
            }

            $product = $this->ambilProduk(
                $item['type'],
                (int) $item['id']
            );

            if (!$product) {
                return false;
            }
        }

        return true;
    }

    private function ambilProduk($type, $id)
    {
        switch ($type) {
            case 'menu':
                return Menu::find($id);
            case 'wahana':
                return TiketWahana::find($id);
            case 'oleh_oleh':
                return OlehOleh::find($id);
            case 'bundling':
                return PaketBundling::find($id);
            default:
                return null;
        }
    }

    private function ambilNama($type, $product): string
    {
        $kolomNama = match ($type) {
            'menu' => ['nama_menu', 'nama'],
            'wahana' => ['nama_wahana', 'nama_tiket', 'nama'],
            'oleh_oleh' => ['nama', 'nama_oleh_oleh', 'nama_produk'],
            'bundling' => ['nama_paket', 'nama_paket_bundling', 'nama'],
            default => [],
        };

        foreach ($kolomNama as $kolom) {
            $nama = $product->getAttribute($kolom);

            if (is_string($nama) && trim($nama) !== '') {
                return trim($nama);
            }
        }

        return match ($type) {
            'menu' => 'Menu',
            'wahana' => 'Tiket Wahana',
            'oleh_oleh' => 'Oleh-Oleh',
            'bundling' => 'Paket Bundling',
            default => 'Produk',
        };
    }

    private function ambilHarga($type, $product): ?int
    {
        $kolomHarga = match ($type) {
            'menu' => ['harga', 'harga_menu'],
            'wahana' => ['harga', 'harga_tiket', 'harga_wahana'],
            'oleh_oleh' => ['harga', 'harga_produk', 'harga_oleh_oleh'],
            'bundling' => ['harga', 'harga_paket', 'harga_bundling'],
            default => ['harga'],
        };

        foreach ($kolomHarga as $kolom) {
            $harga = $product->getAttribute($kolom);

            if ($harga !== null && is_numeric($harga)) {
                $harga = (int) $harga;

                if ($harga >= 0) {
                    return $harga;
                }
            }
        }

        return null;
    }

    private function ambilGambar($product)
    {
        foreach (['gambar_url', 'gambar', 'foto', 'foto_wahana', 'gambar_wahana'] as $kolom) {
            $gambar = $product->getAttribute($kolom);

            if (is_string($gambar) && trim($gambar) !== '') {
                return $gambar;
            }
        }

        return null;
    }

    private function hitungTotal(array $cart): int
    {
        $total = 0;

        foreach ($cart as $item) {
            $harga = (int) ($item['harga'] ?? 0);
            $qty = (int) ($item['qty'] ?? 0);
            $total += $harga * $qty;
        }

        return $total;
    }

    private function buatKodePesanan(): string
    {
        do {
            $kode = 'NG-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
        } while (Pesanan::where('kode_pesanan', $kode)->exists());

        return $kode;
    }

    private function normalisasiNomorWa($nomor): string
    {
        $nomor = preg_replace('/[^0-9+]/', '', (string) $nomor);

        if (str_starts_with($nomor, '08')) {
            $nomor = '62' . substr($nomor, 1);
        }

        if (str_starts_with($nomor, '+62')) {
            $nomor = '62' . substr($nomor, 3);
        }

        return $nomor;
    }
}
