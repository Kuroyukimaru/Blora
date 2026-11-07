<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Public\EventController as PublicEventController;
use App\Http\Controllers\Public\HomeController as PublicHomeController;
use App\Http\Controllers\Public\MenuController as PublicMenuController;
use App\Http\Controllers\Public\OlehOlehController as PublicOlehOlehController;
use App\Http\Controllers\Public\PaketBundlingController as PublicPaketBundlingController;
use App\Http\Controllers\Public\TiketWahanaController as PublicTiketWahanaController;
use App\Http\Controllers\Public\PesananController as PublicPesananController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OlehOlehController;
use App\Http\Controllers\Admin\PaketBundlingController;
use App\Http\Controllers\Admin\TiketWahanaController;

use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Kasir\MenuOrderController;
use App\Http\Controllers\Kasir\OlehOlehOrderController;
use App\Http\Controllers\Kasir\TiketWahanaController as KasirTiketWahanaController;

Route::name('public.')
    ->group(function () {

        Route::get(
            '/',
            [PublicHomeController::class, 'index']
        )->name('home');

        Route::get(
            '/menu',
            [PublicMenuController::class, 'index']
        )->name('menu.index');

        Route::get(
            '/menu/{id}',
            [PublicMenuController::class, 'show']
        )->whereNumber('id')->name('menu.show');

        Route::get(
            '/wahana',
            [PublicTiketWahanaController::class, 'index']
        )->name('tiket-wahana.index');

        Route::get(
            '/wahana/{id}',
            [PublicTiketWahanaController::class, 'show']
        )->whereNumber('id')->name('tiket-wahana.show');

        Route::get(
            '/oleh-oleh',
            [PublicOlehOlehController::class, 'index']
        )->name('oleholeh.index');

        Route::get(
            '/oleh-oleh/{id}',
            [PublicOlehOlehController::class, 'show']
        )->whereNumber('id')->name('oleholeh.show');

        Route::get(
            '/paket-bundling',
            [PublicPaketBundlingController::class, 'index']
        )->name('paketbundling.index');

        Route::get(
            '/paket-bundling/{id}',
            [PublicPaketBundlingController::class, 'show']
        )->whereNumber('id')->name('paketbundling.show');

        Route::get(
            '/event',
            [PublicEventController::class, 'index']
        )->name('event.index');

        Route::get(
            '/event/{id}',
            [PublicEventController::class, 'show']
        )->whereNumber('id')->name('event.show');

    });

Route::controller(PublicPesananController::class)->group(function () {

    Route::get('/keranjang', 'keranjang')
        ->name('pesanan.keranjang');

    Route::post('/keranjang/tambah', 'tambah')
        ->name('pesanan.keranjang.tambah');

    Route::patch('/keranjang/update', 'update')
        ->name('pesanan.keranjang.update');

    Route::delete('/keranjang/{key}', 'hapus')
        ->name('pesanan.keranjang.hapus');

    Route::delete('/keranjang', 'kosongkan')
        ->name('pesanan.keranjang.kosongkan');

    Route::get('/pembayaran', 'checkout')
        ->name('pesanan.pembayaran');

    Route::get('/checkout', 'checkout')
        ->name('pesanan.checkout');

    Route::post('/checkout', 'store')
        ->name('pesanan.store');

    Route::post('/midtrans/notification', 'midtransNotification')
        ->withoutMiddleware([
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ])
        ->name('midtrans.notification');

    Route::get('/pesanan/{kode}/berhasil', 'berhasil')
        ->where('kode', '[A-Za-z0-9_-]+')
        ->name('pesanan.berhasil');
});

Route::controller(AuthController::class)->group(function () {

    Route::get(
        '/login',
        'login'
    )->name('login');

    Route::get(
        '/admin/login',
        'login'
    )->name('admin.login');

    Route::post(
        '/login',
        'authenticate'
    )->name('login.process');

});

Route::middleware('auth:admin')->group(function () {

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');

    Route::middleware('role:admin')->group(function () {

        Route::get(
            '/admin/dashboard',
            [AdminDashboardController::class, 'index']
        )->name('admin.dashboard');

        Route::prefix('admin/menu')
            ->name('admin.menu.')
            ->controller(MenuController::class)
            ->group(function () {

                Route::get(
                    '/',
                    'index'
                )->name('index');

                Route::get(
                    '/create',
                    'create'
                )->name('create');

                Route::post(
                    '/',
                    'store'
                )->name('store');

                Route::get(
                    '/{menu}',
                    'show'
                )->name('show');

                Route::get(
                    '/{menu}/edit',
                    'edit'
                )->name('edit');

                Route::put(
                    '/{menu}',
                    'update'
                )->name('update');

                Route::delete(
                    '/{menu}',
                    'destroy'
                )->name('destroy');

            });

        Route::prefix('admin/tiket-wahana')
            ->name('admin.tiket-wahana.')
            ->controller(TiketWahanaController::class)
            ->group(function () {

                Route::get(
                    '/',
                    'index'
                )->name('index');

                Route::get(
                    '/create',
                    'create'
                )->name('create');

                Route::post(
                    '/',
                    'store'
                )->name('store');

                Route::get(
                    '/{id}/edit',
                    'edit'
                )->whereNumber('id')
                 ->name('edit');

                Route::put(
                    '/{id}',
                    'update'
                )->whereNumber('id')
                 ->name('update');

                Route::delete(
                    '/{id}',
                    'destroy'
                )->whereNumber('id')
                 ->name('destroy');

            });

        Route::prefix('admin/paketbundling')
            ->name('admin.paketbundling.')
            ->controller(PaketBundlingController::class)
            ->group(function () {

                Route::get(
                    '/',
                    'index'
                )->name('index');

                Route::get(
                    '/create',
                    'create'
                )->name('create');

                Route::post(
                    '/',
                    'store'
                )->name('store');

                Route::get(
                    '/{id}/edit',
                    'edit'
                )->whereNumber('id')
                 ->name('edit');

                Route::put(
                    '/{id}',
                    'update'
                )->whereNumber('id')
                 ->name('update');

                Route::delete(
                    '/{id}',
                    'destroy'
                )->whereNumber('id')
                 ->name('destroy');

            });

        Route::prefix('admin/event')
            ->name('admin.event.')
            ->controller(EventController::class)
            ->group(function () {

                Route::get(
                    '/',
                    'index'
                )->name('index');

                Route::get(
                    '/create',
                    'create'
                )->name('create');

                Route::post(
                    '/',
                    'store'
                )->name('store');

                Route::get(
                    '/{id}/edit',
                    'edit'
                )->whereNumber('id')
                 ->name('edit');

                Route::put(
                    '/{id}',
                    'update'
                )->whereNumber('id')
                 ->name('update');

                Route::delete(
                    '/{id}',
                    'destroy'
                )->whereNumber('id')
                 ->name('destroy');

            });

        Route::prefix('admin/oleholeh')
            ->name('admin.oleholeh.')
            ->controller(OlehOlehController::class)
            ->group(function () {

                Route::get(
                    '/',
                    'index'
                )->name('index');

                Route::get(
                    '/create',
                    'create'
                )->name('create');

                Route::post(
                    '/',
                    'store'
                )->name('store');

                Route::get(
                    '/{id}/edit',
                    'edit'
                )->whereNumber('id')
                 ->name('edit');

                Route::put(
                    '/{id}',
                    'update'
                )->whereNumber('id')
                 ->name('update');

                Route::delete(
                    '/{id}',
                    'destroy'
                )->whereNumber('id')
                 ->name('destroy');

            });

    });

    Route::middleware(
        'role:kasir_menu,kasir_wahana,kasir_oleholeh'
    )->group(function () {

        Route::get(
            '/kasir/dashboard',
            [KasirDashboardController::class, 'index']
        )->name('kasir.dashboard');

    });

    Route::middleware('role:kasir_menu')
        ->prefix('kasir-menu')
        ->name('kasir.menu.')
        ->group(function () {

        Route::get(
            '/home',
            [KasirDashboardController::class, 'index']
        )->name('dashboard');

        Route::get(
            '/pesanan',
            [MenuOrderController::class, 'index']
        )->name('pesanan');

        Route::get(
            '/pesanan/{id_pesanan}',
            [MenuOrderController::class, 'show']
        )->whereNumber('id_pesanan')
         ->name('pesanan.show');

        Route::post(
            '/pesanan/{id_pesanan}/verify',
            [MenuOrderController::class, 'verify']
        )->whereNumber('id_pesanan')
         ->name('pesanan.verify');

        Route::get(
            '/pesanan-bundling',
            [MenuOrderController::class, 'bundling']
        )->name('bundling');

    });

    Route::middleware('role:kasir_wahana')
        ->prefix('kasir-wahana')
        ->name('kasir.wahana.')
        ->group(function () {

        Route::get(
            '/home',
            [KasirDashboardController::class, 'index']
        )->name('dashboard');

        Route::get(
            '/pesanan',
            [KasirTiketWahanaController::class, 'index']
        )->name('orders');

        Route::get(
            '/pesanan/{id_pesanan}',
            [KasirTiketWahanaController::class, 'show']
        )->whereNumber('id_pesanan')
         ->name('orders.show');

        Route::post(
            '/pesanan/{id_pesanan}/verify',
            [KasirTiketWahanaController::class, 'verify']
        )->whereNumber('id_pesanan')
         ->name('orders.verify');

        Route::get(
            '/pesanan-bundling',
            [KasirTiketWahanaController::class, 'bundling']
        )->name('bundling');

    });

    Route::middleware('role:kasir_oleholeh')
        ->prefix('kasir-oleholeh')
        ->name('kasir.oleholeh.')
        ->group(function () {

        Route::get(
            '/home',
            [KasirDashboardController::class, 'index']
        )->name('dashboard');

        Route::get(
            '/pesanan',
            [OlehOlehOrderController::class, 'index']
        )->name('orders');

        Route::get(
            '/pesanan/{id_pesanan}',
            [OlehOlehOrderController::class, 'show']
        )->whereNumber('id_pesanan')
         ->name('orders.show');

        Route::post(
            '/pesanan/{id_pesanan}/verify',
            [OlehOlehOrderController::class, 'verify']
        )->whereNumber('id_pesanan')
         ->name('orders.verify');

        Route::get(
            '/stok',
            [OlehOlehOrderController::class, 'stock']
        )->name('stock');

        Route::put(
            '/stok/{id_oleh_oleh}',
            [OlehOlehOrderController::class, 'updateStock']
        )->name('stock.update');

    });

});
