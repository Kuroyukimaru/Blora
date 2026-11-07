<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\OlehOleh;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class OlehOlehOrderController extends Controller
{

    public function index(Request $request): View
    {
        $this->authorizeKasirOlehOleh();

        $query = $this->olehOlehOrderQuery();

        $status = trim(
            (string) $request->input(
                'status',
                'Menunggu'
            )
        );

        $allowedStatuses = [
            'Menunggu',
            'Menunggu Pembayaran',
            'Menunggu Pengambilan',
            'Selesai',
            'Batal',
            'Pembayaran Gagal',
        ];

        if (
            $status !== ''
            &&
            in_array(
                $status,
                $allowedStatuses,
                true
            )
        ) {
            if ($status === 'Menunggu') {
                $query->whereIn(
                    'status',
                    [
                        'Menunggu Pembayaran',
                        'Menunggu Pengambilan',
                    ]
                );
            } else {
                $query->where(
                    'status',
                    $status
                );
            }
        }

        $this->applyOrderSearch(
            $query,
            $request->input('search')
        );

        $allowedPerPage = [15, 30, 50, 75, 100];
        $perPage = (int) $request->input('per_page', 15);

        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 15;
        }

        $pesanans = $query
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();

        $orders = $pesanans;

        return view(
            'kasir.pesanan-oleholeh.pesanan.index',
            compact(
                'orders',
                'pesanans'
            )
        );
    }

    public function show(
        int $id_pesanan
    ): RedirectResponse {

        $this->authorizeKasirOlehOleh();

        $pesanan = Pesanan::query()
            ->with([
                'detailPesanans' => function ($query) {
                    $query
                        ->whereNotNull(
                            'id_oleh_oleh'
                        )
                        ->with(
                            'olehOleh'
                        );
                },
            ])
            ->whereHas(
                'detailPesanans',
                function ($query) {
                    $query->whereNotNull(
                        'id_oleh_oleh'
                    );
                }
            )
            ->findOrFail(
                $id_pesanan
            );

        return redirect()
            ->route(
                'kasir.oleholeh.orders'
            )
            ->with(
                'open_order_id',
                $pesanan->id_pesanan
            );
    }

    public function verify(
        Request $request,
        int $id_pesanan
    ): RedirectResponse {

        $this->authorizeKasirOlehOleh();

        $request->validate([
            'confirmation' => ['nullable', 'accepted'],
        ]);

        DB::beginTransaction();

        try {

            $pesanan = Pesanan::query()
                ->where('id_pesanan', $id_pesanan)
                ->lockForUpdate()
                ->first();

            if (!$pesanan) {
                DB::rollBack();

                return back()->with(
                    'error',
                    'Pesanan tidak ditemukan.'
                );
            }

            if (!in_array(
                $pesanan->status,
                [
                    'Menunggu Pembayaran',
                    'Menunggu Pengambilan',
                ],
                true
            )) {
                DB::rollBack();

                return back()->with(
                    'error',
                    'Pesanan tidak dapat diverifikasi karena statusnya bukan Menunggu Pembayaran atau Menunggu Pengambilan.'
                );
            }

            if ($pesanan->status === 'Menunggu Pembayaran') {
                if (strtoupper((string) $pesanan->metode_pembayaran) === 'QRIS') {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Pembayaran QRIS belum dikonfirmasi oleh Midtrans. Kasir tidak dapat memverifikasi pembayaran QRIS secara manual.'
                    );
                }

                if (strtoupper((string) $pesanan->metode_pembayaran) !== 'CASH') {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Metode pembayaran pesanan tidak dikenali.'
                    );
                }

                $pesanan->status = 'Menunggu Pengambilan';
                $pesanan->save();

                DB::commit();

                return redirect()
                    ->route('kasir.oleholeh.orders')
                    ->with(
                        'success',
                        'Pembayaran Cash pesanan Oleh-Oleh berhasil diverifikasi. Pesanan sekarang menunggu pengambilan.'
                    );
            }

            $detailsOlehOleh = $pesanan
                ->detailPesanans()
                ->whereNotNull('id_oleh_oleh')
                ->where('status_item', '!=', 'Selesai')
                ->with('olehOleh')
                ->lockForUpdate()
                ->get();

            if ($detailsOlehOleh->isEmpty()) {
                DB::rollBack();

                return back()->with(
                    'error',
                    'Tidak ada item Oleh-Oleh yang masih menunggu pengambilan.'
                );
            }

            $lockedProducts = collect();

            foreach ($detailsOlehOleh as $detail) {

                $idOlehOleh = (int) $detail->id_oleh_oleh;
                $qty = (int) $detail->qty;

                if ($idOlehOleh <= 0) {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Data produk Oleh-Oleh pada pesanan tidak valid.'
                    );
                }

                if ($qty < 1) {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Jumlah pesanan untuk produk Oleh-Oleh tidak valid.'
                    );
                }

                $olehOleh = OlehOleh::query()
                    ->where('id_oleh_oleh', $idOlehOleh)
                    ->lockForUpdate()
                    ->first();

                if (!$olehOleh) {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Produk Oleh-Oleh pada pesanan tidak ditemukan.'
                    );
                }

                $stok = (int) $olehOleh->stok;

                if ($stok < $qty) {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Stok "' .
                        $olehOleh->nama .
                        '" tidak mencukupi. Stok tersedia: ' .
                        $stok .
                        ', jumlah pesanan: ' .
                        $qty .
                        '.'
                    );
                }

                $lockedProducts->put(
                    (string) $idOlehOleh,
                    $olehOleh
                );
            }

            foreach ($detailsOlehOleh as $detail) {

                $idOlehOleh = (int) $detail->id_oleh_oleh;

                $olehOleh = $lockedProducts->get(
                    (string) $idOlehOleh
                );

                if (!$olehOleh) {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Produk Oleh-Oleh tidak dapat diproses.'
                    );
                }

                $qty = (int) $detail->qty;
                $stokBaru = (int) $olehOleh->stok - $qty;

                $olehOleh->stok = $stokBaru;
                $olehOleh->status = $stokBaru > 0
                    ? 'Tersedia'
                    : 'Tidak Tersedia';
                $olehOleh->save();

                $detail->status_item = 'Selesai';
                $detail->save();
            }

            $pesanan->refresh();

            $orderSelesai = $this->updateOrderStatusIfEverythingIsComplete(
                $pesanan
            );

            DB::commit();

            if ($orderSelesai) {
                return redirect()
                    ->route('kasir.oleholeh.orders')
                    ->with(
                        'success',
                        'Pengambilan Oleh-Oleh berhasil diverifikasi dan seluruh item pesanan sudah selesai.'
                    );
            }

            return redirect()
                ->route('kasir.oleholeh.orders')
                ->with(
                    'success',
                    'Pengambilan Oleh-Oleh berhasil diverifikasi. Item lain pada pesanan masih menunggu verifikasi.'
                );

        } catch (Throwable $e) {

            DB::rollBack();

            report($e);

            return back()->with(
                'error',
                'Pesanan gagal diverifikasi. Silakan coba lagi.'
            );
        }
    }

    private function updateOrderStatusIfEverythingIsComplete(
        Pesanan $pesanan
    ): bool {

        $details = $pesanan
            ->detailPesanans()
            ->get();

        if ($details->isEmpty()) {
            return false;
        }

        if ($pesanan->status === 'Batal') {
            return false;
        }

        $hasIncompleteDetail = $details->contains(
            function ($detail) {
                return $detail->status_item !== 'Selesai';
            }
        );

        if ($hasIncompleteDetail) {
            return false;
        }

        if ($pesanan->status === 'Selesai') {
            return true;
        }

        $pesanan->status = 'Selesai';
        $pesanan->save();

        return true;
    }

    public function stock(
        Request $request
    ): View {

        $this->authorizeKasirOlehOleh();

        $query =
            OlehOleh::query();

        if (
            $request->filled(
                'search'
            )
        ) {

            $search =
                trim(
                    (string)
                    $request->input(
                        'search'
                    )
                );

            if (
                $search !== ''
            ) {

                $query->where(
                    function ($q) use (
                        $search
                    ) {

                        $q

                            ->where(
                                'nama',
                                'like',
                                '%' .
                                $search .
                                '%'
                            )

                            ->orWhere(
                                'jenis',
                                'like',
                                '%' .
                                $search .
                                '%'
                            );
                    }
                );
            }
        }

        $olehOleh =
            $query
                ->orderBy(
                    'nama'
                )
                ->paginate(10)
                ->withQueryString();

        $items =
            $olehOleh;

        return view(
            'kasir.pesanan-oleholeh.stock.index',
            compact(
                'olehOleh',
                'items'
            )
        );
    }

    public function updateStock(
        Request $request,
        int $id_oleh_oleh
    ): RedirectResponse {

        $this->authorizeKasirOlehOleh();

        $validated =
            $request->validate(
                [
                    'stok' => [
                        'required',
                        'integer',
                        'min:0',
                    ],
                ],
                [
                    'stok.required' =>
                        'Stok wajib diisi.',

                    'stok.integer' =>
                        'Stok harus berupa angka.',

                    'stok.min' =>
                        'Stok tidak boleh kurang dari 0.',
                ]
            );

        DB::beginTransaction();

        try {

            $olehOleh =
                OlehOleh::query()
                    ->where(
                        'id_oleh_oleh',
                        $id_oleh_oleh
                    )
                    ->lockForUpdate()
                    ->first();

            if (!$olehOleh) {

                DB::rollBack();

                return back()
                    ->with(
                        'error',
                        'Produk Oleh-Oleh tidak ditemukan.'
                    );
            }

            $stokBaru =
                (int)
                $validated['stok'];

            $olehOleh->update([
                'stok' => $stokBaru,

                'status' => $stokBaru > 0
                    ? 'Tersedia'
                    : 'Tidak Tersedia',
            ]);

            DB::commit();

            return back()
                ->with(
                    'success',
                    'Stok ' .
                    $olehOleh->nama .
                    ' berhasil diperbarui.'
                );

        } catch (Throwable $e) {

            DB::rollBack();

            report($e);

            return back()
                ->with(
                    'error',
                    'Stok gagal diperbarui. Silakan coba lagi.'
                );
        }
    }

    private function olehOlehOrderQuery(): Builder
    {
        return Pesanan::query()
            ->with([
                'user',
                'detailPesanans' => function ($query) {
                    $query
                        ->whereNotNull('id_oleh_oleh')
                        ->with('olehOleh');
                },
            ])
            ->whereHas(
                'detailPesanans',
                function (Builder $query) {
                    $query->whereNotNull('id_oleh_oleh');
                }
            );
    }

    private function applyOrderSearch(
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
                        'detailPesanans.olehOleh',
                        function (
                            Builder $olehOlehQuery
                        ) use (
                            $search
                        ) {

                            $olehOlehQuery->where(
                                'nama',
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

    private function authorizeKasirOlehOleh(): void
    {

        $guard =
            Auth::guard(
                'admin'
            );

        if (
            !$guard->check()
        ) {

            abort(
                redirect()
                    ->route(
                        'admin.login'
                    )
                    ->with(
                        'error',
                        'Silakan login terlebih dahulu.'
                    )
            );
        }

        $user =
            $guard->user();

        if (!$user) {

            $guard->logout();

            request()
                ->session()
                ->invalidate();

            request()
                ->session()
                ->regenerateToken();

            abort(
                redirect()
                    ->route(
                        'admin.login'
                    )
                    ->with(
                        'error',
                        'Sesi login tidak valid. Silakan login kembali.'
                    )
            );
        }

        if (
            trim(
                (string)
                $user->role
            )
            !==
            'kasir_oleholeh'
        ) {

            abort(
                403,
                'Anda tidak memiliki akses sebagai Kasir Oleh-Oleh.'
            );
        }
    }
}
