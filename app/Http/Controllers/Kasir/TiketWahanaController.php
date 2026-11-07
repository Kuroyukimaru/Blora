<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class TiketWahanaController extends Controller
{

    public function dashboard(): View
    {
        $this->authorizeKasirWahana();

        $baseQuery = $this->wahanaOrderQuery()
            ->where('status', 'Menunggu Pengambilan');

        $jumlahMenunggu =
            (clone $baseQuery)->count();

        $jumlahHariIni =
            (clone $baseQuery)
                ->whereDate(
                    'created_at',
                    today()
                )
                ->count();

        $pesananSelesaiHariIni =
            $this->wahanaOrderQuery()
                ->where(
                    'status',
                    'Selesai'
                )
                ->whereDate(
                    'updated_at',
                    today()
                )
                ->count();

        $pesananTerbaru =
            (clone $baseQuery)
                ->latest('created_at')
                ->take(10)
                ->get();

        return view(
            'kasir.dashboard',
            compact(
                'jumlahMenunggu',
                'jumlahHariIni',
                'pesananSelesaiHariIni',
                'pesananTerbaru'
            )
        );
    }

    public function index(
        Request $request
    ): View {

        $this->authorizeKasirWahana();

        $query =
            $this->wahanaOrderQuery();

        $statusInput = $request->input('status', 'Menunggu');
        $status = is_string($statusInput) ? trim($statusInput) : 'Menunggu';

        $allowedStatuses = [
            'Menunggu',
            'Menunggu Pembayaran',
            'Menunggu Pengambilan',
            'Selesai',
            'Batal',
        ];

        if (!in_array($status, $allowedStatuses, true) && $status !== '') {
            $status = 'Menunggu';
        }

        if ($status === 'Menunggu') {

            $query->whereIn(
                'status',
                [
                    'Menunggu Pembayaran',
                    'Menunggu Pengambilan',
                ]
            );

        } elseif (
            $status !== ''
            &&
            in_array(
                $status,
                $allowedStatuses,
                true
            )
        ) {

            $query->where(
                'status',
                $status
            );
        }

        $searchInput = $request->input('search');
        $search = is_string($searchInput) ? $searchInput : null;
        $this->applySearch($query, $search);

        $pesanans =
            $query
                ->latest('created_at')
                ->paginate(10)
                ->withQueryString();

        return view(
            'kasir.pesanan-wahana.index',
            compact(
                'pesanans'
            )
        );
    }

    public function show(int $id): View|RedirectResponse
    {

        $this->authorizeKasirWahana();

        $pesanan =
            $this->wahanaOrderQuery()
                ->where(
                    'id_pesanan',
                    $id
                )
                ->first();

        if (!$pesanan) {

            return redirect()
                ->route(
                    'kasir.wahana.orders'
                )
                ->with(
                    'error',
                    'Pesanan tidak ditemukan.'
                );
        }

        $wahanaDetails =
            $pesanan->details
                ->filter(
                    function ($detail) {

                        return !is_null($detail->id_tiket_wahana)
                            && is_null($detail->id_paket_bundling);
                    }
                )
                ->values();

        $bundlingDetails =
            $pesanan->details
                ->filter(
                    function ($detail) {

                        return
                            !is_null(
                                $detail->id_paket_bundling
                            )

                            && $detail->paketBundling

                            && $detail
                                ->paketBundling
                                ->wahanas

                            && $detail
                                ->paketBundling
                                ->wahanas
                                ->isNotEmpty();
                    }
                )
                ->values();

        if (
            view()->exists(
                'kasir.pesanan-wahana.show'
            )
        ) {

            return view(
                'kasir.pesanan-wahana.show',
                compact(
                    'pesanan',
                    'wahanaDetails',
                    'bundlingDetails'
                )
            );
        }

        return redirect()
            ->route(
                'kasir.wahana.orders'
            )
            ->with(
                'info',
                'Detail pesanan dapat dikelola dari halaman pesanan wahana.'
            );
    }

    public function verify(Request $request, int $id): RedirectResponse
    {
        $this->authorizeKasirWahana();

        $request->validate(
            [
                'confirmation' => ['nullable', 'accepted'],
                'nama_pelanggan' => ['nullable', 'string', 'max:255'],
                'kode_pesanan' => ['nullable', 'string', 'max:255'],
            ],
            [
                'confirmation.accepted' => 'Silakan konfirmasi tindakan pesanan.',
            ]
        );

        if (
            !$request->has('confirmation')
            && (!$request->filled('nama_pelanggan') || !$request->filled('kode_pesanan'))
        ) {
            return back()
                ->withInput()
                ->with('error', 'Konfirmasi atau data pelanggan tidak lengkap.');
        }

        DB::beginTransaction();

        try {
            $pesanan = Pesanan::query()
                ->with([
                    'details' => function ($query) {
                        $query->with([
                            'tiketWahana',
                            'paketBundling.menus',
                            'paketBundling.wahanas',
                        ]);
                    },
                ])
                ->where('id_pesanan', $id)
                ->whereIn('status', ['Menunggu Pembayaran', 'Menunggu Pengambilan'])
                ->lockForUpdate()
                ->first();

            if (!$pesanan) {
                DB::rollBack();

                return back()->with(
                    'error',
                    'Pesanan tidak ditemukan atau sudah diproses.'
                );
            }

            if ($request->filled('kode_pesanan')) {
                $kodeBenar = mb_strtoupper(trim((string) $pesanan->kode_pesanan));
                $kodeInput = mb_strtoupper(trim((string) $request->input('kode_pesanan')));

                if ($kodeBenar !== $kodeInput) {
                    DB::rollBack();

                    return back()
                        ->withInput()
                        ->with('error', 'Kode pesanan tidak sesuai.');
                }
            }

            if ($request->filled('nama_pelanggan')) {
                $namaBenar = mb_strtolower(trim((string) $pesanan->nama_pelanggan));
                $namaInput = mb_strtolower(trim((string) $request->input('nama_pelanggan')));

                if ($namaBenar !== $namaInput) {
                    DB::rollBack();

                    return back()
                        ->withInput()
                        ->with('error', 'Nama pelanggan tidak sesuai dengan pesanan.');
                }
            }

            $bundlingDetails = $pesanan->details
                ->filter(function ($detail) {
                    return !is_null($detail->id_paket_bundling)
                        && $detail->paketBundling
                        && $detail->paketBundling->wahanas
                        && $detail->paketBundling->wahanas->isNotEmpty();
                })
                ->values();

            $wahanaDetails = $pesanan->details
                ->filter(function ($detail) {
                    return !is_null($detail->id_tiket_wahana)
                        && is_null($detail->id_paket_bundling);
                })
                ->values();

            if ($bundlingDetails->isEmpty() && $wahanaDetails->isEmpty()) {
                DB::rollBack();

                return back()
                    ->withInput()
                    ->with('error', 'Tidak ada tiket Wahana yang dapat diverifikasi.');
            }

            $metodePembayaran = mb_strtolower(trim((string) $pesanan->metode_pembayaran));
            $isQris = str_contains($metodePembayaran, 'qris')
                || str_contains($metodePembayaran, 'midtrans');
            $isCash = in_array($metodePembayaran, ['cash', 'tunai', 'cash_on_delivery', 'cash on delivery'], true);

            if ($pesanan->status === 'Menunggu Pembayaran') {
                if ($isQris) {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Pembayaran QRIS belum dikonfirmasi oleh Midtrans. Kasir tidak dapat memverifikasi pembayaran ini secara manual.'
                    );
                }

                if (!$isCash) {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Metode pembayaran ini harus dikonfirmasi melalui penyedia pembayaran terlebih dahulu.'
                    );
                }

                $pesanan->status = 'Menunggu Pengambilan';
                $pesanan->save();
                DB::commit();

                return redirect()
                    ->route('kasir.wahana.orders')
                    ->with(
                        'success',
                        'Pembayaran tunai pesanan ' . $pesanan->kode_pesanan . ' berhasil diverifikasi. Pesanan sekarang menunggu pengambilan.'
                    );
            }

            foreach ($bundlingDetails as $detail) {
                $detail->status_pembayaran_wahana_bundling = 'Sudah Dibayar';
                $detail->status_wahana_bundling = 'Selesai';
                $this->syncBundlingItemStatus($detail);
                $detail->save();
            }

            foreach ($wahanaDetails as $detail) {
                if ($detail->status_item !== 'Selesai') {
                    $detail->status_item = 'Selesai';
                    $detail->save();
                }
            }

            $allComponentPaymentsPaid = true;

            if ($bundlingDetails->isNotEmpty()) {
                $pesanan->load([
                    'details.paketBundling.menus',
                    'details.paketBundling.wahanas',
                ]);

                foreach ($pesanan->details as $detail) {
                    if (is_null($detail->id_paket_bundling)) {
                        continue;
                    }

                    $paket = $detail->paketBundling;

                    if (!$paket) {
                        $allComponentPaymentsPaid = false;
                        break;
                    }

                    $hasMenu = $paket->menus && $paket->menus->isNotEmpty();
                    $hasWahana = $paket->wahanas && $paket->wahanas->isNotEmpty();
                    $menuPaid = !$hasMenu
                        || ($detail->status_pembayaran_menu_bundling ?? 'Menunggu') === 'Sudah Dibayar';
                    $wahanaPaid = !$hasWahana
                        || ($detail->status_pembayaran_wahana_bundling ?? 'Menunggu') === 'Sudah Dibayar';

                    if (!$menuPaid || !$wahanaPaid) {
                        $allComponentPaymentsPaid = false;
                        break;
                    }
                }

                if ($allComponentPaymentsPaid && $pesanan->status !== 'Selesai') {
                    $pesanan->status = 'Menunggu Pengambilan';
                    $pesanan->save();
                }
            }

            $pesanan->load([
                'details.menu',
                'details.tiketWahana',
                'details.olehOleh',
                'details.paketBundling.menus',
                'details.paketBundling.wahanas',
            ]);

            $orderSelesai = $this->updateOrderStatusIfEverythingIsComplete($pesanan);

            DB::commit();

            if ($orderSelesai) {
                $message = 'Pesanan berhasil diverifikasi dan seluruh item pesanan sudah selesai.';
            } elseif ($bundlingDetails->isNotEmpty() && $wahanaDetails->isNotEmpty()) {
                $message = 'Tiket Wahana dan bagian Wahana Bundling berhasil diverifikasi. Bagian lain pada pesanan masih menunggu verifikasi.';
            } elseif ($bundlingDetails->isNotEmpty() && !$allComponentPaymentsPaid) {
                $message = 'Bagian Wahana Bundling berhasil diverifikasi. Bagian Menu pada bundling masih menunggu verifikasi.';
            } elseif ($bundlingDetails->isNotEmpty()) {
                $message = 'Bagian Wahana Bundling berhasil diverifikasi. Bagian lain pada pesanan masih menunggu verifikasi.';
            } else {
                $message = 'Tiket Wahana berhasil diverifikasi. Bagian lain pada pesanan masih menunggu verifikasi.';
            }

            $route = $bundlingDetails->isNotEmpty() && $wahanaDetails->isEmpty()
                ? 'kasir.wahana.bundling'
                : 'kasir.wahana.orders';

            return redirect()
                ->route($route)
                ->with('success', $message);
        } catch (Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Gagal memproses verifikasi pesanan.');
        }
    }

    public function selesai(
        Request $request
    ): View {

        $this->authorizeKasirWahana();

        $query =
            $this->wahanaOrderQuery()
                ->where(
                    'status',
                    'Selesai'
                );

        $searchInput = $request->input('search');
        $search = is_string($searchInput) ? $searchInput : null;
        $this->applySearch($query, $search);

        $pesanans =
            $query
                ->latest('updated_at')
                ->paginate(10)
                ->withQueryString();

        return view(
            'kasir.pesanan-wahana.index',
            compact(
                'pesanans'
            )
        );
    }

    public function bundling(
        Request $request
    ): View {

        $this->authorizeKasirWahana();

        $query =
            Pesanan::query()

                ->with([
                    'user',

                    'details' => function ($query) {

                        $query

                            ->whereNotNull(
                                'id_paket_bundling'
                            )

                            ->with([
                                'paketBundling.menus',
                                'paketBundling.wahanas',
                            ]);
                    },
                ])

                ->whereHas(
                    'details',
                    function (
                        Builder $query
                    ) {

                        $query

                            ->whereNotNull(
                                'id_paket_bundling'
                            )

                            ->whereHas(
                                'paketBundling.wahanas'
                            );
                    }
                );

        $searchInput = $request->input('search', '');
        $search = is_string($searchInput) ? trim($searchInput) : '';

        if (
            $search !== ''
        ) {

            $query->where(
                function (
                    Builder $q
                ) use (
                    $search
                ) {

                    $q

                        ->where(
                            'kode_pesanan',
                            'like',
                            '%' .
                            $search .
                            '%'
                        )

                        ->orWhere(
                            'nama_pelanggan',
                            'like',
                            '%' .
                            $search .
                            '%'
                        )

                        ->orWhere(
                            'no_wa',
                            'like',
                            '%' .
                            $search .
                            '%'
                        )

                        ->orWhereHas(
                            'details.paketBundling',
                            function (
                                Builder $paketQuery
                            ) use (
                                $search
                            ) {

                                $paketQuery->where(
                                    'nama_paket',
                                    'like',
                                    '%' .
                                    $search .
                                    '%'
                                );
                            }
                        );
                }
            );
        }

        $pesanans =
            $query

                ->latest(
                    'created_at'
                )

                ->paginate(10)

                ->withQueryString();

        return view(
            'kasir.pesanan-bundling.index',
            compact(
                'pesanans',
                'search'
            )
        );
    }

    private function wahanaOrderQuery(): Builder
    {
        return Pesanan::query()

            ->with([
                'user',

                'details' => function ($query) {

                    $query

                        ->where(
                            function (
                                $detailQuery
                            ) {

                                $detailQuery

                                    ->whereNotNull(
                                        'id_tiket_wahana'
                                    )

                                    ->orWhere(
                                        function (
                                            $bundleQuery
                                        ) {

                                            $bundleQuery

                                                ->whereNotNull(
                                                    'id_paket_bundling'
                                                )

                                                ->whereHas(
                                                    'paketBundling.wahanas'
                                                );
                                        }
                                    );
                            }
                        )

                        ->with([
                            'tiketWahana',
                            'paketBundling.menus',
                            'paketBundling.wahanas',
                        ]);
                },
            ])

            ->whereHas(
                'details',
                function (
                    Builder $query
                ) {

                    $query->where(
                        function (
                            $detailQuery
                        ) {

                            $detailQuery

                                ->whereNotNull(
                                    'id_tiket_wahana'
                                )

                                ->orWhere(
                                    function (
                                        $bundleQuery
                                    ) {

                                        $bundleQuery

                                            ->whereNotNull(
                                                'id_paket_bundling'
                                            )

                                            ->whereHas(
                                                'paketBundling.wahanas'
                                            );
                                    }
                                );
                        }
                    );
                }
            );
    }

    private function syncBundlingItemStatus($detail): void
    {
        if (is_null($detail->id_paket_bundling)) {
            return;
        }

        $paket = $detail->paketBundling;

        if (!$paket) {
            return;
        }

        $hasMenu =
            $paket->menus &&
            $paket->menus->isNotEmpty();

        $hasWahana =
            $paket->wahanas &&
            $paket->wahanas->isNotEmpty();

        $menuDone =
            !$hasMenu ||
            $detail->status_menu_bundling === 'Selesai';

        $wahanaDone =
            !$hasWahana ||
            $detail->status_wahana_bundling === 'Selesai';

        if ($menuDone && $wahanaDone) {
            $detail->status_item = 'Selesai';
        } else {
            $detail->status_item = 'Menunggu';
        }
    }

    private function updateOrderStatusIfEverythingIsComplete(
        Pesanan $pesanan
    ): bool {

        $pesanan->load([
            'details.menu',
            'details.tiketWahana',
            'details.olehOleh',
            'details.paketBundling.menus',
            'details.paketBundling.wahanas',
        ]);

        foreach ($pesanan->details as $detail) {

            if (!is_null($detail->id_paket_bundling)) {

                $paket = $detail->paketBundling;

                if (!$paket) {
                    return false;
                }

                $hasMenu =
                    $paket->menus &&
                    $paket->menus->isNotEmpty();

                $hasWahana =
                    $paket->wahanas &&
                    $paket->wahanas->isNotEmpty();

                $menuPaid =
                    !$hasMenu ||
                    ($detail->status_pembayaran_menu_bundling ?? 'Menunggu')
                        === 'Sudah Dibayar';

                $wahanaPaid =
                    !$hasWahana ||
                    ($detail->status_pembayaran_wahana_bundling ?? 'Menunggu')
                        === 'Sudah Dibayar';

                $menuDone =
                    !$hasMenu ||
                    $detail->status_menu_bundling === 'Selesai';

                $wahanaDone =
                    !$hasWahana ||
                    $detail->status_wahana_bundling === 'Selesai';

                if (
                    !$menuPaid ||
                    !$wahanaPaid ||
                    !$menuDone ||
                    !$wahanaDone
                ) {
                    return false;
                }

                continue;
            }

            if (!is_null($detail->id_menu)) {

                if ($detail->status_item !== 'Selesai') {
                    return false;
                }

                continue;
            }

            if (!is_null($detail->id_tiket_wahana)) {

                if ($detail->status_item !== 'Selesai') {
                    return false;
                }

                continue;
            }

            if (!is_null($detail->id_oleh_oleh)) {

                if ($detail->status_item !== 'Selesai') {
                    return false;
                }

                continue;
            }

            return false;
        }

        if ($pesanan->status === 'Selesai') {
            return true;
        }

        $pesanan->status = 'Selesai';
        $pesanan->save();

        return true;
    }

    private function applySearch(
        Builder $query,
        ?string $search
    ): void {

        if (
            $search === null
        ) {

            return;
        }

        $search =
            trim(
                $search
            );

        if (
            $search === ''
        ) {

            return;
        }

        $query->where(
            function (
                Builder $q
            ) use (
                $search
            ) {

                $q

                    ->where(
                        'kode_pesanan',
                        'like',
                        '%' .
                        $search .
                        '%'
                    )

                    ->orWhere(
                        'nama_pelanggan',
                        'like',
                        '%' .
                        $search .
                        '%'
                    )

                    ->orWhere(
                        'no_wa',
                        'like',
                        '%' .
                        $search .
                        '%'
                    )

                    ->orWhereHas(
                        'details.tiketWahana',
                        function (
                            Builder $wahanaQuery
                        ) use (
                            $search
                        ) {

                            $wahanaQuery->where(
                                'nama_wahana',
                                'like',
                                '%' .
                                $search .
                                '%'
                            );
                        }
                    )

                    ->orWhereHas(
                        'details.paketBundling',
                        function (
                            Builder $paketQuery
                        ) use (
                            $search
                        ) {

                            $paketQuery->where(
                                'nama_paket',
                                'like',
                                '%' .
                                $search .
                                '%'
                            );
                        }
                    );
            }
        );
    }

    private function authorizeKasirWahana(): void
    {
        $guard = Auth::guard('admin');

        if (!$guard->check()) {
            throw new HttpResponseException(
                redirect()
                    ->route('admin.login')
                    ->with('error', 'Silakan login terlebih dahulu.')
            );
        }

        $user = $guard->user();

        if (!$user) {
            $guard->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            throw new HttpResponseException(
                redirect()
                    ->route('admin.login')
                    ->with('error', 'Sesi login tidak valid. Silakan login kembali.')
            );
        }

        if (trim((string) $user->role) !== 'kasir_wahana') {
            abort(403, 'Anda tidak memiliki akses sebagai Kasir Wahana.');
        }
    }
}
