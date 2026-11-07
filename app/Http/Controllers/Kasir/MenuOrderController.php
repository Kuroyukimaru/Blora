<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class MenuOrderController extends Controller
{

    public function index(Request $request)
    {
        $this->authorizeKasirMenu();
        $kasir = Auth::guard('admin')->user();

        $search = trim((string) $request->input('search', ''));
        $status = strtolower(trim((string) $request->input('status', 'menunggu')));

        $allowedStatuses = ['semua', 'pembayaran', 'menunggu', 'selesai', 'batal'];

        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'menunggu';
        }

        $query = $this->menuOrdersQuery()
            ->with([
                'details' => function ($query) {
                    $query
                        ->whereNotNull('id_menu')
                        ->whereNull('id_paket_bundling')
                        ->with('menu');
                },
            ]);

        if ($status === 'pembayaran') {
            $query->where('status', 'Menunggu Pembayaran');
        } elseif ($status === 'menunggu') {
            $query->whereIn('status', [
                'Menunggu Pembayaran',
                'Lunas',
                'Menunggu Pengambilan',
            ]);
        } elseif ($status !== 'semua') {
            $statusMap = [
                'selesai' => 'Selesai',
                'batal' => 'Batal',
            ];

            $query->where('status', $statusMap[$status]);
        }

        if ($search !== '') {
            $like = '%' . $search . '%';

            $query->where(function (Builder $query) use ($like) {
                $query
                    ->where('kode_pesanan', 'like', $like)
                    ->orWhere('nama_pelanggan', 'like', $like)
                    ->orWhere('no_wa', 'like', $like)
                    ->orWhereHas('details', function (Builder $detailQuery) use ($like) {
                        $detailQuery
                            ->whereNotNull('id_menu')
                            ->whereNull('id_paket_bundling')
                            ->whereHas('menu', function (Builder $menuQuery) use ($like) {
                                $menuQuery->where('nama_menu', 'like', $like);
                            });
                    });
            });
        }

        $orders = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id_pesanan')
            ->paginate(10)
            ->withQueryString();

        $statistics = [
            'total' => $this->menuOrdersQuery()->count(),

            'menunggu' => $this->menuOrdersQuery()
                ->whereIn('status', [
                    'Menunggu Pembayaran',
                    'Lunas',
                    'Menunggu Pengambilan',
                ])
                ->count(),

            'pembayaran' => $this->menuOrdersQuery()
                ->where('status', 'Menunggu Pembayaran')
                ->count(),

            'selesai' => $this->menuOrdersQuery()
                ->where('status', 'Selesai')
                ->count(),

            'batal' => $this->menuOrdersQuery()
                ->where('status', 'Batal')
                ->count(),
        ];

        return view(
            'kasir.pesanan-menu.index',
            compact(
                'orders',
                'statistics',
                'search',
                'status',
                'kasir'
            )
        );
    }

    public function show($id)
    {
        $this->authorizeKasirMenu();
        $kasir = Auth::guard('admin')->user();

        $order = Pesanan::query()
            ->with([
                'details' => function ($query) {
                    $query
                        ->whereNotNull('id_menu')
                        ->whereNull('id_paket_bundling')
                        ->with('menu');
                },
            ])
            ->where('id_pesanan', $id)
            ->whereDoesntHave('details', function (Builder $query) {
                $query->whereNotNull('id_paket_bundling');
            })
            ->whereHas('details', function (Builder $query) {
                $query
                    ->whereNotNull('id_menu')
                    ->whereNull('id_paket_bundling');
            })
            ->firstOrFail();

        $menuDetails = $order->details
            ->filter(function ($detail) {
                return !is_null($detail->id_menu)
                    && is_null($detail->id_paket_bundling);
            })
            ->values();

        $bundlingDetails = collect();

        return view(
            'kasir.pesanan-menu.show',
            compact(
                'order',
                'menuDetails',
                'bundlingDetails',
                'kasir'
            )
        );
    }

    public function verify(
        Request $request,
        $id
    ): RedirectResponse {

        $this->authorizeKasirMenu();

        $request->validate(
            [
                'confirmation' => [
                    'required',
                    'accepted',
                ],
            ],
            [
                'confirmation.required' =>
                    'Konfirmasi verifikasi wajib dicentang.',
                'confirmation.accepted' =>
                    'Silakan konfirmasi tindakan pesanan.',
            ]
        );

        DB::beginTransaction();

        try {

            $order = Pesanan::query()
                ->with([
                    'details' => function ($query) {
                        $query
                            ->whereNotNull('id_menu')
                            ->whereNull('id_paket_bundling')
                            ->with('menu');
                    },
                ])
                ->where('id_pesanan', $id)
                ->whereIn('status', [
                    'Menunggu Pembayaran',
                    'Lunas',
                    'Menunggu Pengambilan',
                ])
                ->whereDoesntHave('details', function (Builder $query) {
                    $query->whereNotNull('id_paket_bundling');
                })
                ->whereHas('details', function (Builder $query) {
                    $query
                        ->whereNotNull('id_menu')
                        ->whereNull('id_paket_bundling');
                })
                ->lockForUpdate()
                ->first();

            if (!$order) {
                DB::rollBack();

                return back()->with(
                    'error',
                    'Pesanan tidak ditemukan, bukan Pesanan Menu biasa, atau sudah diproses.'
                );
            }

            if (in_array($order->status, ['Menunggu Pembayaran', 'Lunas'], true)) {
                if ($order->status === 'Menunggu Pembayaran' && $order->metode_pembayaran !== 'Cash') {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Pembayaran QRIS belum dikonfirmasi oleh Midtrans. Kasir tidak dapat memverifikasi pembayaran QRIS secara manual.'
                    );
                }

                $statusSebelumnya = $order->status;

                $order->update([
                    'status' => 'Menunggu Pengambilan',
                ]);

                DB::commit();

                $pesan = $statusSebelumnya === 'Lunas'
                    ? 'Pembayaran QRIS pesanan ' . $order->kode_pesanan . ' sudah terkonfirmasi dan berhasil diverifikasi oleh kasir.'
                    : 'Pembayaran Cash pesanan ' . $order->kode_pesanan . ' berhasil diverifikasi.';

                return redirect()
                    ->route('kasir.menu.pesanan')
                    ->with(
                        'success',
                        $pesan . ' Pesanan sekarang menunggu pengambilan.'
                    );
            }

            foreach ($order->details as $detail) {
                if ($detail->status_item !== 'Selesai') {
                    $detail->update([
                        'status_item' => 'Selesai',
                    ]);
                }
            }

            $order->load([
                'details.menu',
                'details.tiketWahana',
                'details.olehOleh',
                'details.paketBundling.menus',
                'details.paketBundling.wahanas',
            ]);

            $complete = $this->updateOrderStatusIfEverythingIsComplete($order);

            DB::commit();

            return redirect()
                ->route('kasir.menu.pesanan')
                ->with(
                    'success',
                    $complete
                        ? 'Menu pesanan ' . $order->kode_pesanan . ' berhasil di-ACC dan pesanan sudah selesai.'
                        : 'Menu pesanan ' . $order->kode_pesanan . ' berhasil di-ACC.'
                );

        } catch (Throwable $e) {

            DB::rollBack();
            report($e);

            return back()->with(
                'error',
                'Gagal memproses pesanan Menu.'
            );
        }
    }

    public function verifyBundlingMenu(
        Request $request,
        $id
    ): RedirectResponse {

        $this->authorizeKasirMenu();

        $request->validate(
            [
                'confirmation' => [
                    'required',
                    'accepted',
                ],
            ],
            [
                'confirmation.required' =>
                    'Konfirmasi verifikasi wajib dicentang.',
                'confirmation.accepted' =>
                    'Silakan konfirmasi tindakan pesanan.',
            ]
        );

        DB::beginTransaction();

        try {

            $order = Pesanan::query()
                ->with([
                    'details' => function ($query) {
                        $query
                            ->whereNotNull('id_paket_bundling')
                            ->whereHas('paketBundling.menus')
                            ->with([
                                'paketBundling.menus',
                                'paketBundling.wahanas',
                            ]);
                    },
                ])
                ->where('id_pesanan', $id)
                ->whereIn('status', [
                    'Menunggu Pembayaran',
                    'Lunas',
                    'Menunggu Pengambilan',
                ])
                ->whereHas('details', function (Builder $query) {
                    $query
                        ->whereNotNull('id_paket_bundling')
                        ->whereHas('paketBundling.menus');
                })
                ->lockForUpdate()
                ->first();

            if (!$order) {
                DB::rollBack();

                return back()->with(
                    'error',
                    'Pesanan Bundling tidak ditemukan atau bukan tanggung jawab Kasir Menu.'
                );
            }

            if (in_array($order->status, ['Menunggu Pembayaran', 'Lunas'], true)) {
                if ($order->status === 'Menunggu Pembayaran' && $order->metode_pembayaran !== 'Cash') {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Pembayaran QRIS belum dikonfirmasi oleh Midtrans. Kasir tidak dapat memverifikasi pembayaran QRIS secara manual.'
                    );
                }

                $statusSebelumnya = $order->status;

                $order->update([
                    'status' => 'Menunggu Pengambilan',
                ]);

                DB::commit();

                $pesan = $statusSebelumnya === 'Lunas'
                    ? 'Pembayaran QRIS pesanan Bundling ' . $order->kode_pesanan . ' sudah terkonfirmasi dan berhasil diverifikasi oleh kasir.'
                    : 'Pembayaran Cash pesanan Bundling ' . $order->kode_pesanan . ' berhasil diverifikasi.';

                return redirect()
                    ->route('kasir.menu.bundling')
                    ->with(
                        'success',
                        $pesan . ' Pesanan sekarang menunggu pengambilan.'
                    );
            }

            $bundleDetails = $order->details
                ->filter(function ($detail) {
                    return !is_null($detail->id_paket_bundling)
                        && $detail->paketBundling
                        && $detail->paketBundling->menus
                        && $detail->paketBundling->menus->isNotEmpty();
                })
                ->values();

            if ($bundleDetails->isEmpty()) {
                DB::rollBack();

                return back()->with(
                    'error',
                    'Tidak ada bagian Menu Bundling yang dapat diproses.'
                );
            }

            foreach ($bundleDetails as $detail) {
                $detail->update([
                    'status_menu_bundling' => 'Selesai',
                ]);

                $this->syncBundlingItemStatus($detail);
            }

            $order->load([
                'details.menu',
                'details.tiketWahana',
                'details.olehOleh',
                'details.paketBundling.menus',
                'details.paketBundling.wahanas',
            ]);

            $complete = $this->updateOrderStatusIfEverythingIsComplete($order);

            DB::commit();

            return redirect()
                ->route('kasir.menu.bundling')
                ->with(
                    'success',
                    $complete
                        ? 'Bagian Menu Bundling pesanan ' . $order->kode_pesanan . ' berhasil di-ACC dan seluruh komponen sudah selesai.'
                        : 'Bagian Menu Bundling pesanan ' . $order->kode_pesanan . ' berhasil di-ACC. Bagian Wahana masih menunggu verifikasi.'
                );

        } catch (Throwable $e) {

            DB::rollBack();
            report($e);

            return back()->with(
                'error',
                'Gagal memproses bagian Menu Bundling.'
            );
        }
    }

    public function reject(
        Request $request,
        $id
    ): RedirectResponse {

        $this->authorizeKasirMenu();

        $validated = $request->validate(
            [
                'reason' => [
                    'required',
                    'string',
                    'max:500',
                ],
            ],
            [
                'reason.required' =>
                    'Alasan ketidaksesuaian wajib diisi.',
                'reason.string' =>
                    'Alasan ketidaksesuaian harus berupa teks.',
                'reason.max' =>
                    'Alasan maksimal 500 karakter.',
            ]
        );

        $reason = trim($validated['reason']);

        if ($reason === '') {
            return back()
                ->withInput()
                ->withErrors([
                    'reason' => 'Alasan ketidaksesuaian wajib diisi.',
                ]);
        }

        DB::beginTransaction();

        try {

            $order = Pesanan::query()
                ->with([
                    'details.menu',
                ])
                ->where('id_pesanan', $id)
                ->where('status', 'Menunggu Pengambilan')
                ->whereDoesntHave('details', function (Builder $query) {
                    $query->whereNotNull('id_paket_bundling');
                })
                ->whereHas('details', function (Builder $query) {
                    $query
                        ->whereNotNull('id_menu')
                        ->whereNull('id_paket_bundling');
                })
                ->lockForUpdate()
                ->first();

            if (!$order) {
                DB::rollBack();

                return back()->with(
                    'error',
                    'Pesanan tidak ditemukan, bukan Pesanan Menu biasa, atau sudah diproses.'
                );
            }

            $reason = mb_substr($reason, 0, 500);

            $order->update([
                'status' => 'Batal',
            ]);

            DB::commit();

            return redirect()
                ->route('kasir.menu.pesanan')
                ->with(
                    'success',
                    'Pesanan ' . $order->kode_pesanan . ' dibatalkan karena tidak sesuai.'
                )
                ->with(
                    'reject_reason',
                    $reason
                );

        } catch (Throwable $e) {

            DB::rollBack();
            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal memproses pesanan yang tidak sesuai.'
                );
        }
    }

    public function bundling(
        Request $request
    ) {

        $this->authorizeKasirMenu();

        $kasir = Auth::guard('admin')->user();

        $search = trim(
            (string) $request->input(
                'search',
                ''
            )
        );

        $query = Pesanan::query()
            ->with([
                'details' => function ($query) {

                    $query
                        ->whereNotNull(
                            'id_paket_bundling'
                        )
                        ->whereHas(
                            'paketBundling.menus'
                        )
                        ->with([
                            'paketBundling.menus',
                            'paketBundling.wahanas',
                        ]);
                },
            ])
            ->whereHas(
                'details',
                function (Builder $query) {

                    $query
                        ->whereNotNull(
                            'id_paket_bundling'
                        )
                        ->whereHas(
                            'paketBundling.menus'
                        );
                }
            );

        if ($search !== '') {

            $like = '%' . $search . '%';

            $query->where(
                function (Builder $query) use ($like) {

                    $query
                        ->where(
                            'kode_pesanan',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'nama_pelanggan',
                            'like',
                            $like
                        )
                        ->orWhere(
                            'no_wa',
                            'like',
                            $like
                        )
                        ->orWhereHas(
                            'details.paketBundling',
                            function (
                                Builder $paketQuery
                            ) use ($like) {

                                $paketQuery->where(
                                    'nama_paket',
                                    'like',
                                    $like
                                );
                            }
                        );
                }
            );
        }

        $orders = $query
            ->orderBy(
                'created_at',
                'desc'
            )
            ->orderBy(
                'id_pesanan',
                'desc'
            )
            ->paginate(10)
            ->withQueryString();

        return view(
            'kasir.pesanan-bundling.index',
            compact(
                'orders',
                'search',
                'kasir'
            )
        );
    }

    private function menuOrdersQuery(): Builder
    {

        return Pesanan::query()
            ->whereDoesntHave('details', function (Builder $query) {
                $query->whereNotNull('id_paket_bundling');
            })
            ->whereHas('details', function (Builder $query) {
                $query
                    ->whereNotNull('id_menu')
                    ->whereNull('id_paket_bundling');
            });
    }

    private function syncBundlingItemStatus(
        $detail
    ): void {

        if (
            is_null(
                $detail->id_paket_bundling
            )
        ) {
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
            !$hasMenu
            ||
            $detail->status_menu_bundling ===
            'Selesai';

        $wahanaDone =
            !$hasWahana
            ||
            $detail->status_wahana_bundling ===
            'Selesai';

        if (
            $menuDone &&
            $wahanaDone
        ) {

            $detail->update([
                'status_item' =>
                    'Selesai',
            ]);

            return;
        }

        if (
            $detail->status_item ===
            'Selesai'
        ) {

            $detail->update([
                'status_item' =>
                    'Menunggu',
            ]);
        }
    }

    private function updateOrderStatusIfEverythingIsComplete(
        Pesanan $order
    ): bool {

        $order->load([
            'details.menu',
            'details.tiketWahana',
            'details.olehOleh',
            'details.paketBundling.menus',
            'details.paketBundling.wahanas',
        ]);

        foreach (
            $order->details
            as $detail
        ) {

            if (
                !is_null(
                    $detail->id_paket_bundling
                )
            ) {

                $paket =
                    $detail->paketBundling;

                if (!$paket) {
                    return false;
                }

                $hasMenu =
                    $paket->menus &&
                    $paket->menus->isNotEmpty();

                $hasWahana =
                    $paket->wahanas &&
                    $paket->wahanas->isNotEmpty();

                $menuDone =
                    !$hasMenu
                    ||
                    $detail->status_menu_bundling ===
                    'Selesai';

                $wahanaDone =
                    !$hasWahana
                    ||
                    $detail->status_wahana_bundling ===
                    'Selesai';

                if (
                    !$menuDone ||
                    !$wahanaDone
                ) {
                    return false;
                }

                continue;
            }

            if (
                !is_null(
                    $detail->id_menu
                )
            ) {

                if (
                    $detail->status_item !==
                    'Selesai'
                ) {
                    return false;
                }

                continue;
            }

            if (
                !is_null(
                    $detail->id_tiket_wahana
                )
            ) {

                if (
                    $detail->status_item !==
                    'Selesai'
                ) {
                    return false;
                }

                continue;
            }

            if (
                !is_null(
                    $detail->id_oleh_oleh
                )
            ) {

                if (
                    $detail->status_item !==
                    'Selesai'
                ) {
                    return false;
                }

                continue;
            }

            return false;
        }

        if (
            $order->status ===
            'Menunggu Pembayaran'
        ) {
            return false;
        }

        if (
            $order->status ===
            'Selesai'
        ) {
            return true;
        }

        $order->status =
            'Selesai';

        $order->save();

        return true;
    }

    private function authorizeKasirMenu(): void
    {
        $guard =
            Auth::guard('admin');

        if (!$guard->check()) {

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
                (string) $user->role
            ) !==
            'kasir_menu'
        ) {

            abort(
                403,
                'Anda tidak memiliki akses sebagai Kasir Menu.'
            );
        }
    }
}
