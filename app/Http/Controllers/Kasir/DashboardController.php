<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    /**
     * ================================================================
     * DASHBOARD KASIR
     * ================================================================
     *
     * Role:
     *
     * kasir_menu
     * - Home
     * - Pesanan Menu
     * - Pesanan Bundling
     *
     * kasir_wahana
     * - Home
     * - Pesanan Wahana
     * - Pesanan Bundling
     *
     * kasir_oleholeh
     * - Home
     * - Pesanan Oleh-Oleh
     * - Stok Oleh-Oleh
     *
     * Catatan:
     * Pesanan Bundling hanya digunakan oleh kasir_menu dan kasir_wahana.
     */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */

        $guard = Auth::guard('admin');

        if (!$guard->check()) {
            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        $kasir = $guard->user();

        if (!$kasir) {
            $guard->logout();

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Sesi login tidak valid.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        $role = $kasir->role ?? '';


        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($role === 'admin') {
            return redirect()
                ->route('admin.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE YANG DIIZINKAN
        |--------------------------------------------------------------------------
        */

        $allowedRoles = [
            'kasir_menu',
            'kasir_wahana',
            'kasir_oleholeh',
        ];

        if (!in_array($role, $allowedRoles, true)) {
            $guard->logout();

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Role akun tidak dikenali.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE CONFIG
        |--------------------------------------------------------------------------
        */

        $config = $this->getRoleConfig($role);


        /*
        |--------------------------------------------------------------------------
        | DATA ROLE
        |--------------------------------------------------------------------------
        */

        $roleName = $config['name'];

        $orderType = $config['order_type'];

        $orderTitle = $config['order_title'];

        $orderIcon = $config['order_icon'];

        $orderDescription = $config['order_description'];


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD URL
        |--------------------------------------------------------------------------
        */

        $dashboardUrl = $this->resolveRoute(
            $config['dashboard_routes'],
            $config['dashboard_fallback']
        );


        /*
        |--------------------------------------------------------------------------
        | PESANAN URL
        |--------------------------------------------------------------------------
        */

        $orderUrl = $this->resolveRoute(
            $config['order_routes'],
            $config['order_fallback']
        );


        /*
        |--------------------------------------------------------------------------
        | STOK OLEH-OLEH URL
        |--------------------------------------------------------------------------
        |
        | Hanya digunakan oleh kasir_oleholeh.
        |
        */

        $stockUrl = null;

        if (!empty($config['stock_routes'])) {
            $stockUrl = $this->resolveRoute(
                $config['stock_routes'],
                $config['stock_fallback']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BUNDLING URL
        |--------------------------------------------------------------------------
        */

        $bundlingUrl = null;

        if (in_array($role, ['kasir_menu', 'kasir_wahana'], true)) {
            $bundlingUrl = $this->resolveBundlingRoute($role);
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        |
        | Untuk sementara masih menggunakan angka 0.
        | Nanti bisa dihubungkan ke database.
        |
        */

        $statistics = [
            'total_pesanan' => 0,
            'menunggu' => 0,
            'diproses' => 0,
            'selesai' => 0,
            'pendapatan' => 0,
        ];


        /*
        |--------------------------------------------------------------------------
        | SHORTCUT
        |--------------------------------------------------------------------------
        */

        $shortcut = [
            [
                'title' => $orderTitle,

                'description' => $orderDescription,

                'icon' => $orderIcon,

                'url' => $orderUrl,
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | SHORTCUT STOK KHUSUS KASIR OLEH-OLEH
        |--------------------------------------------------------------------------
        */

        if ($role === 'kasir_oleholeh' && $stockUrl) {
            $shortcut[] = [
                'title' => 'Stok Oleh-Oleh',

                'description' =>
                    'Kelola dan perbarui stok produk oleh-oleh.',

                'icon' => 'fa-boxes-stacked',

                'url' => $stockUrl,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | SHORTCUT BUNDLING
        |--------------------------------------------------------------------------
        |
        | Bundling hanya untuk kasir Menu dan kasir Wahana.
        */

        if (
            in_array($role, ['kasir_menu', 'kasir_wahana'], true)
            && $bundlingUrl
        ) {
            $shortcut[] = [
                'title' => 'Pesanan Bundling',

                'description' =>
                    'Kelola dan verifikasi pesanan paket bundling.',

                'icon' => 'fa-boxes-stacked',

                'url' => $bundlingUrl,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | PESANAN TERBARU
        |--------------------------------------------------------------------------
        */

        $recentOrders = [];


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        */

        $sidebar = [
            [
                'title' => 'Home',

                'icon' => 'fa-house',

                'url' => $dashboardUrl,

                'active' =>
                    $this->isDashboardActive($role),
            ],

            [
                'title' => $orderTitle,

                'icon' => $orderIcon,

                'url' => $orderUrl,

                'active' =>
                    $this->isCurrentUrl($orderUrl),
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR STOK KHUSUS KASIR OLEH-OLEH
        |--------------------------------------------------------------------------
        */

        if ($role === 'kasir_oleholeh' && $stockUrl) {
            $sidebar[] = [
                'title' => 'Stok Oleh-Oleh',

                'icon' => 'fa-boxes-stacked',

                'url' => $stockUrl,

                'active' =>
                    $this->isCurrentUrl($stockUrl),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR BUNDLING
        |--------------------------------------------------------------------------
        |
        | Bundling hanya untuk kasir Menu dan kasir Wahana.
        | Kasir oleh-oleh tidak menampilkan menu ini.
        */

        if (
            in_array($role, ['kasir_menu', 'kasir_wahana'], true)
            && $bundlingUrl
        ) {
            $sidebar[] = [
                'title' => 'Pesanan Bundling',

                'icon' => 'fa-boxes-stacked',

                'url' => $bundlingUrl,

                'active' =>
                    $this->isCurrentUrl($bundlingUrl),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'kasir.dashboard',
            [
                /*
                |--------------------------------------------------------------------------
                | USER
                |--------------------------------------------------------------------------
                */

                'kasir' => $kasir,

                'user' => $kasir,


                /*
                |--------------------------------------------------------------------------
                | ROLE
                |--------------------------------------------------------------------------
                */

                'role' => $role,

                'roleName' => $roleName,


                /*
                |--------------------------------------------------------------------------
                | DASHBOARD
                |--------------------------------------------------------------------------
                */

                'dashboardUrl' => $dashboardUrl,


                /*
                |--------------------------------------------------------------------------
                | PESANAN
                |--------------------------------------------------------------------------
                */

                'orderType' => $orderType,

                'orderTitle' => $orderTitle,

                'orderUrl' => $orderUrl,

                'orderIcon' => $orderIcon,

                'orderDescription' => $orderDescription,


                /*
                |--------------------------------------------------------------------------
                | STOK OLEH-OLEH
                |--------------------------------------------------------------------------
                */

                'stockUrl' => $stockUrl,


                /*
                |--------------------------------------------------------------------------
                | BUNDLING
                |--------------------------------------------------------------------------
                */

                'bundlingUrl' => $bundlingUrl,


                /*
                |--------------------------------------------------------------------------
                | STATISTIK
                |--------------------------------------------------------------------------
                */

                'statistics' => $statistics,


                /*
                |--------------------------------------------------------------------------
                | SHORTCUT
                |--------------------------------------------------------------------------
                */

                'shortcut' => $shortcut,


                /*
                |--------------------------------------------------------------------------
                | PESANAN TERBARU
                |--------------------------------------------------------------------------
                */

                'recentOrders' => $recentOrders,


                /*
                |--------------------------------------------------------------------------
                | SIDEBAR
                |--------------------------------------------------------------------------
                */

                'sidebar' => $sidebar,
            ]
        );
    }


    /**
     * ================================================================
     * DASHBOARD KASIR MENU
     * ================================================================
     */

    public function menu()
    {
        return $this->index();
    }


    /**
     * ================================================================
     * DASHBOARD KASIR WAHANA
     * ================================================================
     */

    public function wahana()
    {
        return $this->index();
    }


    /**
     * ================================================================
     * DASHBOARD KASIR OLEH-OLEH
     * ================================================================
     */

    public function oleholeh()
    {
        return $this->index();
    }


    /**
     * ================================================================
     * ROLE CONFIGURATION
     * ================================================================
     */

    private function getRoleConfig(string $role): array
    {
        return match ($role) {

            /*
            |--------------------------------------------------------------------------
            | KASIR MENU
            |--------------------------------------------------------------------------
            */

            'kasir_menu' => [
                'name' => 'Kasir Menu',

                'order_type' => 'menu',

                'order_title' => 'Pesanan Menu',

                'order_icon' => 'fa-utensils',

                'order_description' =>
                    'Kelola dan verifikasi pesanan makanan dan minuman.',

                'dashboard_routes' => [
                    'kasir.menu.dashboard',
                    'kasir.dashboard',
                ],

                'dashboard_fallback' =>
                    '/kasir-menu/home',

                'order_routes' => [
                    'kasir.menu.pesanan',
                    'kasir.menu.orders',
                ],

                'order_fallback' =>
                    '/kasir-menu/pesanan',
            ],


            /*
            |--------------------------------------------------------------------------
            | KASIR WAHANA
            |--------------------------------------------------------------------------
            */

            'kasir_wahana' => [
                'name' => 'Kasir Wahana',

                'order_type' => 'wahana',

                'order_title' => 'Pesanan Wahana',

                'order_icon' => 'fa-ticket',

                'order_description' =>
                    'Kelola dan verifikasi pesanan tiket wahana.',

                'dashboard_routes' => [
                    'kasir.wahana.dashboard',
                    'kasir.dashboard',
                ],

                'dashboard_fallback' =>
                    '/kasir-wahana/home',

                'order_routes' => [
                    'kasir.wahana.pesanan',
                    'kasir.wahana.orders',
                ],

                'order_fallback' =>
                    '/kasir-wahana/pesanan',
            ],


            /*
            |--------------------------------------------------------------------------
            | KASIR OLEH-OLEH
            |--------------------------------------------------------------------------
            */

            'kasir_oleholeh' => [
                'name' => 'Kasir Oleh-Oleh',

                'order_type' => 'oleholeh',

                'order_title' => 'Pesanan Oleh-Oleh',

                'order_icon' => 'fa-bag-shopping',

                'order_description' =>
                    'Kelola dan verifikasi pesanan oleh-oleh.',

                'dashboard_routes' => [
                    'kasir.oleholeh.dashboard',
                    'kasir.dashboard',
                ],

                'dashboard_fallback' =>
                    '/kasir-oleholeh/home',

                'order_routes' => [
                    'kasir.oleholeh.pesanan',
                    'kasir.oleholeh.orders',
                ],

                'order_fallback' =>
                    '/kasir-oleholeh/pesanan',

                /*
                |--------------------------------------------------------------------------
                | STOK OLEH-OLEH
                |--------------------------------------------------------------------------
                */

                'stock_routes' => [
                    'kasir.oleholeh.stock',
                ],

                'stock_fallback' =>
                    '/kasir-oleholeh/stok-oleholeh',
            ],


            /*
            |--------------------------------------------------------------------------
            | DEFAULT
            |--------------------------------------------------------------------------
            */

            default => [
                'name' => 'Kasir',

                'order_type' => 'unknown',

                'order_title' => 'Pesanan',

                'order_icon' => 'fa-receipt',

                'order_description' =>
                    'Kelola pesanan.',

                'dashboard_routes' => [
                    'kasir.dashboard',
                ],

                'dashboard_fallback' =>
                    '/kasir',

                'order_routes' => [],

                'order_fallback' =>
                    '/kasir/pesanan',
            ],
        };
    }


    /**
     * ================================================================
     * RESOLVE ROUTE
     * ================================================================
     */

    private function resolveRoute(
        array $routeNames,
        string $fallback
    ): string {

        foreach ($routeNames as $routeName) {

            if (
                $routeName !== '' &&
                Route::has($routeName)
            ) {
                return route($routeName);
            }
        }

        return url(
            ltrim($fallback, '/')
        );
    }


    /**
     * ================================================================
     * RESOLVE BUNDLING
     * ================================================================
     */

    private function resolveBundlingRoute(string $role): string
    {
        if (!in_array($role, ['kasir_menu', 'kasir_wahana'], true)) {
            return url('/kasir');
        }

        $routeNames = [

            /*
            |--------------------------------------------------------------------------
            | ROUTE UMUM
            |--------------------------------------------------------------------------
            */

            'kasir.bundling.pesanan',

            'kasir.pesanan.bundling',

            'kasir.bundling',


            /*
            |--------------------------------------------------------------------------
            | KASIR MENU
            |--------------------------------------------------------------------------
            */

            'kasir.menu.bundling',


            /*
            |--------------------------------------------------------------------------
            | KASIR WAHANA
            |--------------------------------------------------------------------------
            */

            'kasir.wahana.bundling',
        ];


        foreach ($routeNames as $routeName) {

            if (Route::has($routeName)) {

                return route($routeName);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FALLBACK
        |--------------------------------------------------------------------------
        */

        return url(
            '/kasir/pesanan-bundling'
        );
    }


    /**
     * ================================================================
     * CEK DASHBOARD AKTIF
     * ================================================================
     */

    private function isDashboardActive(
        string $role
    ): bool {

        $currentRoute =
            request()
                ->route()
                ?->getName() ?? '';


        $dashboardRoutes = [

            'kasir_menu' => [
                'kasir.menu.dashboard',
                'kasir.dashboard',
            ],

            'kasir_wahana' => [
                'kasir.wahana.dashboard',
                'kasir.dashboard',
            ],

            'kasir_oleholeh' => [
                'kasir.oleholeh.dashboard',
                'kasir.dashboard',
            ],
        ];


        return in_array(
            $currentRoute,
            $dashboardRoutes[$role] ?? [],
            true
        );
    }


    /**
     * ================================================================
     * CEK URL AKTIF
     * ================================================================
     */

    private function isCurrentUrl(
        ?string $url
    ): bool {

        if (!$url) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | FULL URL
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
        | NORMALISASI
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
        | REQUEST PATH
        |--------------------------------------------------------------------------
        */

        return request()->is(
            $path . '*'
        );
    }
}