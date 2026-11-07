<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Menu;
use App\Models\OlehOleh;
use App\Models\PaketBundling;
use App\Models\TiketWahana;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    /**
     * Dashboard Administrator.
     *
     * Admin bertugas mengelola:
     * - Menu
     * - Wahana
     * - Oleh-Oleh
     * - Paket Bundling
     * - Event
     *
     * Pesanan dan verifikasi pesanan ditangani
     * oleh masing-masing kasir.
     */
    public function index()
    {
        $guard = Auth::guard('admin');


        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!$guard->check()) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL USER
        |--------------------------------------------------------------------------
        */

        $user = $guard->user();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI USER
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            $guard->logout();

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi login tidak valid.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK ROLE
        |--------------------------------------------------------------------------
        |
        | Dashboard ini khusus Administrator.
        |
        */

        if (($user->role ?? null) !== 'admin') {

            return $this->redirectByRole(
                $user->role ?? null,
                $guard
            );
        }


        /*
        |--------------------------------------------------------------------------
        | URL MASTER DATA
        |--------------------------------------------------------------------------
        */

        $menuUrl = $this->resolveRoute(
            'admin.menu.index',
            '/admin/menu'
        );


        $wahanaUrl = $this->resolveRoute(
            'admin.tiket-wahana.index',
            '/admin/tiket-wahana'
        );


        $oleholehUrl = $this->resolveRoute(
            'admin.oleholeh.index',
            '/admin/oleh-oleh'
        );


        $bundlingUrl = $this->resolveRoute(
            'admin.paketbundling.index',
            '/admin/paket-bundling'
        );


        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        |
        | Seluruh event yang sudah dibuat dihitung.
        |
        */

        $eventUrl = $this->resolveRoute(
            'admin.event.index',
            '/admin/event'
        );


        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */

        $statistics = [
            /*
            |--------------------------------------------------------------------------
            | TOTAL MENU
            |--------------------------------------------------------------------------
            | Membaca seluruh data menu yang tersimpan.
            */
            'total_menu' => Menu::query()->count(),

            /*
            |--------------------------------------------------------------------------
            | TOTAL WAHANA
            |--------------------------------------------------------------------------
            | Membaca seluruh tiket/wahana yang tersimpan.
            */
            'total_wahana' => TiketWahana::query()->count(),

            /*
            |--------------------------------------------------------------------------
            | TOTAL OLEH-OLEH
            |--------------------------------------------------------------------------
            | Membaca seluruh produk oleh-oleh yang tersimpan.
            */
            'total_oleholeh' => OlehOleh::query()->count(),

            /*
            |--------------------------------------------------------------------------
            | TOTAL PAKET BUNDLING
            |--------------------------------------------------------------------------
            | Membaca seluruh paket bundling yang tersimpan.
            */
            'total_bundling' => PaketBundling::query()->count(),

            /*
            |--------------------------------------------------------------------------
            | TOTAL EVENT
            |--------------------------------------------------------------------------
            | Dashboard menampilkan seluruh event yang sudah dibuat,
            | bukan hanya event yang tanggalnya belum lewat.
            */
            'total_event' => Event::query()->count(),
        ];


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD DATA
        |--------------------------------------------------------------------------
        */

        $dashboardData = [

            'page_title' =>
                'Dashboard Administrator',

            'page_description' =>
                'Kelola data Menu, Wahana, Oleh-Oleh, Paket Bundling, dan Event.',

            'role' =>
                'Administrator',

            'user_name' =>
                $user->nama
                ?? $user->name
                ?? 'Administrator',

            'user_email' =>
                $user->email
                ?? '-',

            /*
            |--------------------------------------------------------------------------
            | RINGKASAN JUMLAH DATA
            |--------------------------------------------------------------------------
            | Disediakan sebagai satu paket agar Blade dashboard dapat
            | membaca seluruh jumlah master data dengan mudah.
            */
            'total_data_master' =>
                $statistics['total_menu']
                + $statistics['total_wahana']
                + $statistics['total_oleholeh']
                + $statistics['total_bundling']
                + $statistics['total_event'],
        ];


        /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        */

        $masterData = [

            [
                'title' => 'Menu',

                'description' =>
                    'Kelola makanan, minuman, sambal, dan menu lainnya.',

                'icon' => 'fa-utensils',

                'url' => $menuUrl,

                'type' => 'menu',
            ],


            [
                'title' => 'Wahana',

                'description' =>
                    'Kelola tiket dan informasi wahana.',

                'icon' => 'fa-ticket',

                'url' => $wahanaUrl,

                'type' => 'wahana',
            ],


            [
                'title' => 'Oleh-Oleh',

                'description' =>
                    'Kelola produk oleh-oleh, harga, stok, dan status.',

                'icon' => 'fa-bag-shopping',

                'url' => $oleholehUrl,

                'type' => 'oleholeh',
            ],


            [
                'title' => 'Paket Bundling',

                'description' =>
                    'Kelola paket bundling beserta menu dan wahana.',

                'icon' => 'fa-boxes-stacked',

                'url' => $bundlingUrl,

                'type' => 'bundling',
            ],


            [
                'title' => 'Event',

                'description' =>
                    'Kelola event yang akan datang.',

                'icon' => 'fa-calendar-days',

                'url' => $eventUrl,

                'type' => 'event',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        */

        $sidebar = [

            [
                'title' => 'Home',

                'icon' => 'fa-house',

                'url' => $this->resolveRoute(
                    'admin.dashboard',
                    '/admin'
                ),

                'active' =>
                    $this->isDashboardActive(),
            ],


            [
                'title' => 'Menu',

                'icon' => 'fa-utensils',

                'url' => $menuUrl,

                'active' =>
                    $this->isCurrentUrl($menuUrl),
            ],


            [
                'title' => 'Wahana',

                'icon' => 'fa-ticket',

                'url' => $wahanaUrl,

                'active' =>
                    $this->isCurrentUrl($wahanaUrl),
            ],


            [
                'title' => 'Oleh-Oleh',

                'icon' => 'fa-bag-shopping',

                'url' => $oleholehUrl,

                'active' =>
                    $this->isCurrentUrl($oleholehUrl),
            ],


            [
                'title' => 'Paket Bundling',

                'icon' => 'fa-boxes-stacked',

                'url' => $bundlingUrl,

                'active' =>
                    $this->isCurrentUrl($bundlingUrl),
            ],


            [
                'title' => 'Event',

                'icon' => 'fa-calendar-days',

                'url' => $eventUrl,

                'active' =>
                    $this->isCurrentUrl($eventUrl),
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | SHORTCUT
        |--------------------------------------------------------------------------
        */

        $shortcut = [

            [
                'title' => 'Kelola Menu',

                'description' =>
                    'Tambah, edit, hapus, dan lihat menu.',

                'icon' => 'fa-utensils',

                'url' => $menuUrl,
            ],


            [
                'title' => 'Kelola Wahana',

                'description' =>
                    'Tambah, edit, hapus, dan lihat wahana.',

                'icon' => 'fa-ticket',

                'url' => $wahanaUrl,
            ],


            [
                'title' => 'Kelola Oleh-Oleh',

                'description' =>
                    'Tambah, edit, hapus, dan lihat oleh-oleh.',

                'icon' => 'fa-bag-shopping',

                'url' => $oleholehUrl,
            ],


            [
                'title' => 'Paket Bundling',

                'description' =>
                    'Tambah, edit, hapus, dan lihat paket bundling.',

                'icon' => 'fa-boxes-stacked',

                'url' => $bundlingUrl,
            ],


            [
                'title' => 'Kelola Event',

                'description' =>
                    'Tambah, edit, hapus, dan lihat event yang akan datang.',

                'icon' => 'fa-calendar-days',

                'url' => $eventUrl,
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'Admin.dashboard',
            [
                'user' => $user,

                'statistics' => $statistics,

                'dashboardData' => $dashboardData,

                'masterData' => $masterData,

                'sidebar' => $sidebar,

                'shortcut' => $shortcut,

                'menuUrl' => $menuUrl,

                'wahanaUrl' => $wahanaUrl,

                'oleholehUrl' => $oleholehUrl,

                'bundlingUrl' => $bundlingUrl,

                'eventUrl' => $eventUrl,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REDIRECT BERDASARKAN ROLE
    |--------------------------------------------------------------------------
    */

    private function redirectByRole(
        ?string $role,
        $guard
    ) {

        /*
        |--------------------------------------------------------------------------
        | KASIR MENU
        |--------------------------------------------------------------------------
        */

        if ($role === 'kasir_menu') {

            $routes = [
                'kasir.menu.dashboard',
                'kasir.menu.orders',
            ];

            foreach ($routes as $routeName) {

                if (Route::has($routeName)) {

                    return redirect()
                        ->route($routeName);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | KASIR WAHANA
        |--------------------------------------------------------------------------
        */

        if ($role === 'kasir_wahana') {

            $routes = [
                'kasir.wahana.dashboard',
                'kasir.wahana.orders',
            ];

            foreach ($routes as $routeName) {

                if (Route::has($routeName)) {

                    return redirect()
                        ->route($routeName);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | KASIR OLEH-OLEH
        |--------------------------------------------------------------------------
        */

        if ($role === 'kasir_oleholeh') {

            $routes = [
                'kasir.oleholeh.dashboard',
                'kasir.oleholeh.orders',
            ];

            foreach ($routes as $routeName) {

                if (Route::has($routeName)) {

                    return redirect()
                        ->route($routeName);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE TIDAK DIKENALI
        |--------------------------------------------------------------------------
        */

        $guard->logout();

        return redirect()
            ->route('admin.login')
            ->with(
                'error',
                'Role akun tidak dikenali atau halaman tujuan belum tersedia.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | RESOLVE ROUTE
    |--------------------------------------------------------------------------
    */

    private function resolveRoute(
        string $routeName,
        string $fallback
    ): string {

        if (
            $routeName !== '' &&
            Route::has($routeName)
        ) {
            return route($routeName);
        }


        return url(
            ltrim($fallback, '/')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVE DASHBOARD
    |--------------------------------------------------------------------------
    */

    private function isDashboardActive(): bool
    {
        $routeName = request()
            ->route()
            ?->getName() ?? '';

        return in_array(
            $routeName,
            [
                'admin.dashboard',
                'admin.home',
            ],
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVE URL
    |--------------------------------------------------------------------------
    */

    private function isCurrentUrl(
        ?string $url
    ): bool {

        if (!$url) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | URL LENGKAP
        |--------------------------------------------------------------------------
        */

        if (
            request()->fullUrlIs($url) ||
            request()->url() === $url
        ) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL PATH
        |--------------------------------------------------------------------------
        */

        $path = parse_url(
            $url,
            PHP_URL_PATH
        );


        if (!$path) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN PATH
        |--------------------------------------------------------------------------
        */

        $path = trim(
            $path,
            '/'
        );


        if ($path === '') {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | COCOKKAN SUBPATH
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | /admin/event
        | /admin/event/create
        | /admin/event/1/edit
        |
        | semuanya membuat menu Event aktif.
        |
        */

        return request()->is(
            $path . '*'
        );
    }
}