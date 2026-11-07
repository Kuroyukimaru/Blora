@php

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;


    /*
    |--------------------------------------------------------------------------
    | DATA KASIR
    |--------------------------------------------------------------------------
    */

    $kasir = Auth::guard('admin')->user();

    $role = $kasir?->role ?? '';

    $namaKasir = $kasir?->nama ?? 'Kasir';


    /*
    |--------------------------------------------------------------------------
    | ROLE CONFIGURATION
    |--------------------------------------------------------------------------
    |
    | Aturan akses:
    |
    | kasir_menu
    |   -> Pesanan Menu + Bundling
    |
    | kasir_wahana
    |   -> Pesanan Tiket Wahana + Bundling
    |
    | kasir_oleholeh
    |   -> Pesanan Oleh-Oleh + Stok Oleh-Oleh + Bundling
    |
    */

    $roleConfig = match ($role) {

        /*
        |--------------------------------------------------------------------------
        | KASIR MENU
        |--------------------------------------------------------------------------
        */

        'kasir_menu' => [

            'name' =>
                'Kasir Menu',

            'order_title' =>
                'Pesanan Menu',

            'order_icon' =>
                'fa-utensils',

            'dashboard_routes' => [

                'kasir.menu.dashboard',

                'kasir.dashboard',

            ],

            'dashboard_fallback' =>
                '/kasir-menu/home',

            'order_routes' => [

                'kasir.menu.pesanan.index',

                'kasir.menu.pesanan',

                'kasir.menu.orders.index',

                'kasir.menu.orders',

            ],

            'order_fallback' =>
                '/kasir-menu/pesanan',

            'bundling_routes' => [

                'kasir.menu.bundling.index',

                'kasir.menu.bundling',

                'kasir.bundling.pesanan.index',

                'kasir.bundling.pesanan',

                'kasir.bundling.index',

                'kasir.bundling',

            ],

            'bundling_fallback' =>
                '/kasir-menu/pesanan-bundling',

        ],


        /*
        |--------------------------------------------------------------------------
        | KASIR WAHANA
        |--------------------------------------------------------------------------
        */

        'kasir_wahana' => [

            'name' =>
                'Kasir Wahana',

            'order_title' =>
                'Pesanan Wahana',

            'order_icon' =>
                'fa-ticket',

            'dashboard_routes' => [

                'kasir.wahana.dashboard',

                'kasir.dashboard',

            ],

            'dashboard_fallback' =>
                '/kasir-wahana/home',

            'order_routes' => [

                'kasir.wahana.pesanan.index',

                'kasir.wahana.pesanan',

                'kasir.wahana.orders.index',

                'kasir.wahana.orders',

            ],

            'order_fallback' =>
                '/kasir-wahana/pesanan',

            'bundling_routes' => [

                'kasir.wahana.bundling.index',

                'kasir.wahana.bundling',

                'kasir.bundling.pesanan.index',

                'kasir.bundling.pesanan',

                'kasir.bundling.index',

                'kasir.bundling',

            ],

            'bundling_fallback' =>
                '/kasir-wahana/pesanan-bundling',

        ],


        /*
        |--------------------------------------------------------------------------
        | KASIR OLEH-OLEH
        |--------------------------------------------------------------------------
        */

        'kasir_oleholeh' => [

            'name' =>
                'Kasir Oleh-Oleh',

            'order_title' =>
                'Pesanan Oleh-Oleh',

            'order_icon' =>
                'fa-bag-shopping',

            'dashboard_routes' => [

                'kasir.oleholeh.dashboard',

                'kasir.dashboard',

            ],

            'dashboard_fallback' =>
                '/kasir-oleholeh/home',

            'order_routes' => [

                'kasir.oleholeh.pesanan.index',

                'kasir.oleholeh.pesanan',

                'kasir.oleholeh.orders.index',

                'kasir.oleholeh.orders',

            ],

            'order_fallback' =>
                '/kasir-oleholeh/pesanan',

            'stock_routes' => [
                'kasir.oleholeh.stock',
            ],

            'stock_fallback' =>
                '/kasir-oleholeh/stok-oleholeh',

            'bundling_routes' => [


                
                'kasir.bundling.pesanan.index',

                'kasir.bundling.pesanan',

                'kasir.bundling.index',

                'kasir.bundling',

            ],

            'bundling_fallback' =>
                '/kasir-oleholeh/pesanan-bundling',

        ],


        /*
        |--------------------------------------------------------------------------
        | DEFAULT
        |--------------------------------------------------------------------------
        */

        default => [

            'name' =>
                'Kasir',

            'order_title' =>
                'Pesanan',

            'order_icon' =>
                'fa-receipt',

            'dashboard_routes' => [

                'kasir.dashboard',

            ],

            'dashboard_fallback' =>
                '/kasir',

            'order_routes' => [],

            'order_fallback' =>
                '/kasir',

            'bundling_routes' => [],

            'bundling_fallback' =>
                '/kasir',

        ],

    };


    /*
    |--------------------------------------------------------------------------
    | ROLE LABEL
    |--------------------------------------------------------------------------
    */

    $roleLabel =
        $roleConfig['name'];


    /*
    |--------------------------------------------------------------------------
    | AVATAR
    |--------------------------------------------------------------------------
    */

    $namaUntukAvatar =
        trim($namaKasir);

    $avatar =
        $namaUntukAvatar !== ''
            ? strtoupper(
                mb_substr(
                    $namaUntukAvatar,
                    0,
                    1
                )
            )
            : 'K';


    /*
    |--------------------------------------------------------------------------
    | CURRENT ROUTE
    |--------------------------------------------------------------------------
    */

    $currentRoute =
        Route::currentRouteName() ?? '';


    /*
    |--------------------------------------------------------------------------
    | HELPER RESOLVE ROUTE
    |--------------------------------------------------------------------------
    */

    $resolveRoute = function (
        array $routes,
        string $fallback
    ) {

        foreach ($routes as $routeName) {

            if (
                !empty($routeName) &&
                Route::has($routeName)
            ) {

                return route($routeName);

            }

        }

        return url(
            ltrim(
                $fallback,
                '/'
            )
        );

    };


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD URL
    |--------------------------------------------------------------------------
    */

    $dashboardUrl =
        $resolveRoute(
            $roleConfig['dashboard_routes'],
            $roleConfig['dashboard_fallback']
        );


    /*
    |--------------------------------------------------------------------------
    | PESANAN URL
    |--------------------------------------------------------------------------
    */

    $orderUrl =
        $resolveRoute(
            $roleConfig['order_routes'],
            $roleConfig['order_fallback']
        );


    /*
    |--------------------------------------------------------------------------
    | STOK OLEH-OLEH URL
    |--------------------------------------------------------------------------
    */

    $stockUrl = null;

    if (
        $role === 'kasir_oleholeh' &&
        !empty($roleConfig['stock_routes'])
    ) {
        $stockUrl =
            $resolveRoute(
                $roleConfig['stock_routes'],
                $roleConfig['stock_fallback']
            );
    }


    /*
    |--------------------------------------------------------------------------
    | BUNDLING URL
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | BUNDLING URL
    |--------------------------------------------------------------------------
    |
    | Bundling hanya tersedia untuk Kasir Menu dan Kasir Wahana.
    | Kasir Oleh-Oleh tidak memiliki akses/menu Bundling.
    */
    $bundlingUrl = null;

    if (in_array($role, ['kasir_menu', 'kasir_wahana'], true)) {
        $bundlingUrl =
            $resolveRoute(
                $roleConfig['bundling_routes'] ?? [],
                $roleConfig['bundling_fallback'] ?? '/kasir'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVE HOME
    |--------------------------------------------------------------------------
    */

    $isHome = false;

    foreach (
        $roleConfig['dashboard_routes']
        as $routeName
    ) {

        if (
            $currentRoute === $routeName ||
            str_starts_with(
                $currentRoute,
                $routeName . '.'
            )
        ) {

            $isHome = true;

            break;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVE PESANAN
    |--------------------------------------------------------------------------
    */

    $isPesanan = false;

    foreach (
        $roleConfig['order_routes']
        as $routeName
    ) {

        if (
            $currentRoute === $routeName ||
            str_starts_with(
                $currentRoute,
                $routeName . '.'
            )
        ) {

            $isPesanan = true;

            break;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVE STOK OLEH-OLEH
    |--------------------------------------------------------------------------
    */

    $isStock = false;

    if ($role === 'kasir_oleholeh') {
        foreach (
            ($roleConfig['stock_routes'] ?? [])
            as $routeName
        ) {

            if (
                $currentRoute === $routeName ||
                str_starts_with(
                    $currentRoute,
                    $routeName . '.'
                )
            ) {

                $isStock = true;

                break;

            }

        }

        if (!$isStock) {
            $isStock =
                request()->is(
                    'kasir-oleholeh/stok-oleholeh*'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVE BUNDLING
    |--------------------------------------------------------------------------
    */

    $isBundling = false;

    if (in_array($role, ['kasir_menu', 'kasir_wahana'], true)) {
        foreach (
            ($roleConfig['bundling_routes'] ?? [])
            as $routeName
        ) {

        if (
            $currentRoute === $routeName ||
            str_starts_with(
                $currentRoute,
                $routeName . '.'
            )
        ) {

            $isBundling = true;

            break;

        }

    }


    }


    /*
    |--------------------------------------------------------------------------
    | FALLBACK ACTIVE BUNDLING
    |--------------------------------------------------------------------------
    |
    | Jika route bundling menggunakan nama berbeda tetapi URL masih
    | berada pada halaman bundling.
    |
    */

    if (
        in_array($role, ['kasir_menu', 'kasir_wahana'], true)
        && !$isBundling
    ) {
        $isBundling =
            request()->is(
                'kasir*/pesanan-bundling*'
            ) ||
            request()->is(
                'kasir*/bundling*'
            );
    }

@endphp


{{-- =========================================================================
     SIDEBAR KASIR
========================================================================= --}}

<aside
    class="kasir-sidebar"
    id="kasirSidebar"
    aria-label="Sidebar Kasir"
>


    {{-- =====================================================================
         BRAND
    ====================================================================== --}}

    <div class="kasir-sidebar-brand">

        <a
            href="{{ $dashboardUrl }}"
            class="kasir-brand-link"
            aria-label="Dashboard Kasir Noyo Gimbal"
        >

            <div class="kasir-brand-logo">
                NG
            </div>

            <div class="kasir-brand-text">

                <strong>
                    Noyo Gimbal
                </strong>

                <span>
                    Cashier Panel
                </span>

            </div>

        </a>

    </div>


    {{-- =====================================================================
         USER
    ====================================================================== --}}

    <div class="kasir-sidebar-user">

        <div
            class="kasir-user-avatar"
            aria-hidden="true"
        >
            {{ $avatar }}
        </div>

        <div class="kasir-user-info">

            <strong
                title="{{ $namaKasir }}"
            >
                {{ $namaKasir }}
            </strong>

            <span>
                {{ $roleLabel }}
            </span>

        </div>

    </div>


    {{-- =====================================================================
         NAVIGATION
    ====================================================================== --}}

    <nav
        class="kasir-sidebar-nav"
        aria-label="Navigasi Kasir"
    >


        {{-- ================================================================
             MENU UTAMA
        ================================================================= --}}

        <div class="kasir-nav-title">
            Menu Utama
        </div>


        {{-- ================================================================
             HOME
        ================================================================= --}}

        <a
            href="{{ $dashboardUrl }}"
            class="kasir-nav-link {{ $isHome ? 'active' : '' }}"
            aria-current="{{ $isHome ? 'page' : 'false' }}"
        >

            <span class="kasir-nav-icon">
                <i class="fas fa-house"></i>
            </span>

            <span class="kasir-nav-text">
                Home
            </span>

        </a>


        {{-- ================================================================
             TRANSAKSI
        ================================================================= --}}

        <div class="kasir-nav-title">
            Transaksi
        </div>


        {{-- ================================================================
             PESANAN SESUAI ROLE
        ================================================================= --}}

        <a
            href="{{ $orderUrl }}"
            class="kasir-nav-link {{ $isPesanan ? 'active' : '' }}"
            aria-current="{{ $isPesanan ? 'page' : 'false' }}"
        >

            <span class="kasir-nav-icon">

                <i
                    class="fas {{ $roleConfig['order_icon'] }}"
                ></i>

            </span>

            <span class="kasir-nav-text">
                {{ $roleConfig['order_title'] }}
            </span>

        </a>


        {{-- ================================================================
             STOK OLEH-OLEH
             Hanya tampil untuk Kasir Oleh-Oleh
        ================================================================= --}}

        @if (
            $role === 'kasir_oleholeh' &&
            $stockUrl
        )

            <a
                href="{{ $stockUrl }}"
                class="kasir-nav-link {{ $isStock ? 'active' : '' }}"
                aria-current="{{ $isStock ? 'page' : 'false' }}"
            >

                <span class="kasir-nav-icon">

                    <i class="fas fa-boxes-stacked"></i>

                </span>

                <span class="kasir-nav-text">
                    Stok Oleh-Oleh
                </span>

            </a>

        @endif


        {{-- ================================================================
             PESANAN BUNDLING
        ================================================================= --}}

        @if (
            in_array($role, ['kasir_menu', 'kasir_wahana'], true)
            && !empty($roleConfig['bundling_routes'])
            && $bundlingUrl
        )

            <a
                href="{{ $bundlingUrl }}"
                class="kasir-nav-link {{ $isBundling ? 'active' : '' }}"
                aria-current="{{ $isBundling ? 'page' : 'false' }}"
            >

                <span class="kasir-nav-icon">

                    <i class="fas fa-boxes-stacked"></i>

                </span>

                <span class="kasir-nav-text">
                    Pesanan Bundling
                </span>

            </a>

        @endif

    </nav>


    {{-- =====================================================================
         FOOTER
    ====================================================================== --}}

    <div class="kasir-sidebar-footer">


        {{-- ================================================================
             SYSTEM STATUS
        ================================================================= --}}

        <div class="kasir-system-status">

            <span
                class="kasir-status-dot"
                aria-hidden="true"
            ></span>

            <span>
                Sistem Aktif
            </span>

        </div>


        {{-- ================================================================
             LOGOUT
        ================================================================= --}}

        @if(Route::has('logout'))

            <form
                action="{{ route('logout') }}"
                method="POST"
                class="kasir-logout-form"
            >

                @csrf

                <button
                    type="submit"
                    class="kasir-logout-button"
                >

                    <span class="kasir-logout-icon">

                        <i
                            class="fas fa-right-from-bracket"
                        ></i>

                    </span>

                    <span>
                        Keluar
                    </span>

                </button>

            </form>

        @else

            <form
                action="{{ url('/logout') }}"
                method="POST"
                class="kasir-logout-form"
            >

                @csrf

                <button
                    type="submit"
                    class="kasir-logout-button"
                >

                    <span class="kasir-logout-icon">

                        <i
                            class="fas fa-right-from-bracket"
                        ></i>

                    </span>

                    <span>
                        Keluar
                    </span>

                </button>

            </form>

        @endif


        {{-- ================================================================
             COPYRIGHT
        ================================================================= --}}

        <div class="kasir-sidebar-copyright">

            <span>
                © {{ date('Y') }} Noyo Gimbal
            </span>

            <small>
                {{ $roleLabel }}
            </small>

        </div>

    </div>

</aside>


{{-- =========================================================================
     MOBILE OVERLAY
========================================================================= --}}

<div
    class="kasir-sidebar-overlay"
    id="kasirSidebarOverlay"
    aria-hidden="true"
></div>


{{-- =========================================================================
     STYLE
========================================================================= --}}

<style>

    :root {
        --kasir-sidebar-width: 280px;
        --kasir-sidebar-bg: #121212;
        --kasir-sidebar-hover: #1a1a1a;
        --kasir-sidebar-active: rgba(226,201,151,.12);
        --kasir-sidebar-border: rgba(226,201,151,.15);
        --kasir-text: #f8f4ed;
        --kasir-muted: #a89988;
        --kasir-muted-light: #7a6f62;
        --kasir-accent: #e2c997;
        --kasir-accent-soft: rgba(226,201,151,.10);
        --kasir-green: #8fc99a;
        --kasir-sidebar-shadow: 0 20px 60px rgba(0,0,0,.4);
    }


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR
    |--------------------------------------------------------------------------
    */

    .kasir-sidebar {

        position: fixed;

        top: 0;
        left: 0;
        bottom: 0;

        z-index: 1100;

        width:
            var(--kasir-sidebar-width);

        display: flex;

        flex-direction: column;

        overflow: hidden;

        color:
            var(--kasir-text);

        background:
            var(--kasir-sidebar-bg);

        border-right:
            1px solid rgba(255,255,255,.04);

        font-family:
            'DM Sans',
            Arial,
            sans-serif;

    }


    /*
    |--------------------------------------------------------------------------
    | BRAND
    |--------------------------------------------------------------------------
    */

    .kasir-sidebar-brand {

        flex-shrink: 0;

        padding:
            24px 19px 17px;

    }


    .kasir-brand-link {

        display: flex;

        align-items: center;

        gap: 11px;

        color: #ffffff;

        text-decoration: none;

    }


    .kasir-brand-logo {

        display: flex;

        align-items: center;

        justify-content: center;

        width: 42px;
        height: 42px;

        flex-shrink: 0;

        color: #0a0a0a;

        background: linear-gradient(135deg, var(--kasir-accent), var(--kasir-accent-hover, #d4b384));

        border-radius: 14px;

        font-size: 14px;

        font-weight: 800;

        letter-spacing: .7px;

    }


    .kasir-brand-text {

        min-width: 0;

    }


    .kasir-brand-text strong {

        display: block;

        color: #ffffff;

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size: 17px;

        line-height: 1.2;

        font-weight: 700;

    }


    .kasir-brand-text span {

        display: block;

        margin-top: 3px;

        color:
            var(--kasir-accent);

        font-size: 14px;

        line-height: 1;

        font-weight: 700;

        letter-spacing: 1.4px;

        text-transform: uppercase;

    }


    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    .kasir-sidebar-user {

        display: flex;

        align-items: center;

        gap: 10px;

        flex-shrink: 0;

        margin:
            0 14px 17px;

        padding: 11px;

        background:
            rgba(255,255,255,.045);

        border:
            1px solid var(--kasir-sidebar-border);

        border-radius: 12px;

    }


    .kasir-user-avatar {

        display: flex;

        align-items: center;

        justify-content: center;

        width: 36px;
        height: 36px;

        flex-shrink: 0;

        color:
            var(--kasir-accent);

        background:
            var(--kasir-accent-soft);

        border:
            1px solid rgba(184,135,70,.2);

        border-radius: 9px;

        font-size: 14px;

        font-weight: 800;

    }


    .kasir-user-info {

        min-width: 0;

        flex: 1;

    }


    .kasir-user-info strong {

        display: block;

        overflow: hidden;

        color: #ffffff;

        font-size: 14px;

        line-height: 1.3;

        font-weight: 600;

        text-overflow: ellipsis;

        white-space: nowrap;

    }


    .kasir-user-info span {

        display: block;

        margin-top: 3px;

        overflow: hidden;

        color:
            var(--kasir-muted);

        font-size: 14px;

        line-height: 1.3;

        text-overflow: ellipsis;

        white-space: nowrap;

    }


    /*
    |--------------------------------------------------------------------------
    | NAVIGATION
    |--------------------------------------------------------------------------
    */

    .kasir-sidebar-nav {

        flex: 1;

        min-height: 0;

        padding:
            0 12px 12px;

        overflow-y: auto;

        scrollbar-width: thin;

        scrollbar-color:
            rgba(255,255,255,.15)
            transparent;

    }


    .kasir-sidebar-nav::-webkit-scrollbar {

        width: 4px;

    }


    .kasir-sidebar-nav::-webkit-scrollbar-track {

        background: transparent;

    }


    .kasir-sidebar-nav::-webkit-scrollbar-thumb {

        background:
            rgba(255,255,255,.14);

        border-radius: 10px;

    }


    /*
    |--------------------------------------------------------------------------
    | SECTION TITLE
    |--------------------------------------------------------------------------
    */

    .kasir-nav-title {

        margin:
            18px 9px 7px;

        color:
            var(--kasir-muted-light);

        font-size: 14px;

        line-height: 1.2;

        font-weight: 700;

        letter-spacing: 1.4px;

        text-transform: uppercase;

    }


    .kasir-nav-title:first-child {

        margin-top: 2px;

    }


    /*
    |--------------------------------------------------------------------------
    | NAV LINK
    |--------------------------------------------------------------------------
    */

    .kasir-nav-link {

        position: relative;

        display: flex;

        align-items: center;

        gap: 10px;

        min-height: 48px;

        margin: 3px 0;

        padding:
            0 10px;

        color:
            rgba(255,255,255,.65);

        text-decoration: none;

        border:
            1px solid transparent;

        border-radius: 13px;

        transition:
            background .18s ease,
            color .18s ease,
            border-color .18s ease;

    }


    .kasir-nav-link:hover {

        color: #ffffff;

        background:
            var(--kasir-sidebar-hover);

    }


    .kasir-nav-link.active {

        color: #ffffff;

        background:
            var(--kasir-sidebar-active);

        border-color:
            rgba(184,135,70,.16);

    }


    .kasir-nav-link.active::before {

        content: '';

        position: absolute;

        left: -1px;

        top: 9px;

        bottom: 9px;

        width: 3px;

        background:
            var(--kasir-accent);

        border-radius:
            0 3px 3px 0;

    }


    /*
    |--------------------------------------------------------------------------
    | ICON
    |--------------------------------------------------------------------------
    */

    .kasir-nav-icon {

        display: flex;

        align-items: center;

        justify-content: center;

        width: 32px;
        height: 32px;

        flex-shrink: 0;

        color:
            rgba(255,255,255,.46);

        font-size: 14px;

        border-radius: 8px;

        transition:
            color .18s ease,
            background .18s ease;

    }


    .kasir-nav-link:hover .kasir-nav-icon {

        color:
            var(--kasir-accent);

    }


    .kasir-nav-link.active .kasir-nav-icon {

        color:
            var(--kasir-accent);

        background:
            var(--kasir-accent-soft);

    }


    /*
    |--------------------------------------------------------------------------
    | TEXT
    |--------------------------------------------------------------------------
    */

    .kasir-nav-text {

        flex: 1;

        font-size: 13px;

        line-height: 1.2;

        font-weight: 500;

    }


    /*
    |--------------------------------------------------------------------------
    | FOOTER
    |--------------------------------------------------------------------------
    */

    .kasir-sidebar-footer {

        flex-shrink: 0;

        padding:
            11px 14px 14px;

        background:
            var(--kasir-sidebar-bg);

        border-top:
            1px solid var(--kasir-sidebar-border);

    }


    /*
    |--------------------------------------------------------------------------
    | SYSTEM STATUS
    |--------------------------------------------------------------------------
    */

    .kasir-system-status {

        display: flex;

        align-items: center;

        gap: 7px;

        margin-bottom: 7px;

        padding:
            8px 9px;

        color:
            rgba(255,255,255,.5);

        background:
            rgba(255,255,255,.035);

        border-radius: 8px;

        font-size: 14px;

    }


    .kasir-status-dot {

        width: 6px;
        height: 6px;

        flex-shrink: 0;

        background:
            var(--kasir-green);

        border-radius: 50%;

        box-shadow:
            0 0 0 3px
            rgba(103,183,127,.1);

    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    .kasir-logout-form {

        width: 100%;

        margin: 0;

    }


    .kasir-logout-button {

        display: flex;

        align-items: center;

        gap: 9px;

        width: 100%;

        min-height: 38px;

        padding:
            0 9px;

        color:
            rgba(255,255,255,.58);

        background: transparent;

        border:
            1px solid transparent;

        border-radius: 9px;

        font-family: inherit;

        font-size: 13px;

        font-weight: 500;

        cursor: pointer;

        transition:
            color .18s ease,
            background .18s ease;

    }


    .kasir-logout-button:hover {

        color: #ffffff;

        background:
            rgba(255,255,255,.06);

    }


    .kasir-logout-icon {

        display: flex;

        align-items: center;

        justify-content: center;

        width: 25px;
        height: 25px;

        color:
            var(--kasir-muted);

        font-size: 13px;

    }


    .kasir-logout-button:hover
    .kasir-logout-icon {

        color:
            var(--kasir-accent);

    }


    /*
    |--------------------------------------------------------------------------
    | COPYRIGHT
    |--------------------------------------------------------------------------
    */

    .kasir-sidebar-copyright {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 7px;

        margin-top: 8px;

        padding:
            8px 2px 0;

        color:
            var(--kasir-muted-light);

        border-top:
            1px solid rgba(255,255,255,.05);

        font-size: 14px;

    }


    .kasir-sidebar-copyright small {

        color:
            var(--kasir-muted-light);

        font-size: 14px;

    }


    /*
    |--------------------------------------------------------------------------
    | OVERLAY
    |--------------------------------------------------------------------------
    */

    .kasir-sidebar-overlay {

        display: none;

        position: fixed;

        inset: 0;

        z-index: 1050;

        background:
            rgba(0,0,0,.42);

        backdrop-filter:
            blur(2px);

        -webkit-backdrop-filter:
            blur(2px);

    }


    .kasir-sidebar-overlay.show {

        display: block;

    }


    body.sidebar-open {

        overflow: hidden;

    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 900px) {

        .kasir-sidebar {

            width: 270px;

            transform:
                translateX(-100%);

            transition:
                transform .25s ease;

            box-shadow:
                15px 0 45px
                rgba(0,0,0,.18);

        }


        .kasir-sidebar.open {

            transform:
                translateX(0);

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SMALL MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 480px) {

        .kasir-sidebar {

            width:
                min(285px, 86vw);

        }

    }


    .kasir-nav-link:focus-visible,
    .kasir-logout-button:focus-visible,
    .kasir-brand-link:focus-visible {
        outline: 3px solid var(--kasir-accent);
        outline-offset: 3px;
    }

    .kasir-nav-link,
    .kasir-logout-button {
        min-height: 48px;
    }

    .kasir-nav-text {
        line-height: 1.45;
    }

    .kasir-system-status {
        min-height: 40px;
    }

    @media (min-width: 901px) and (max-height: 700px) {
        .kasir-sidebar-brand { padding-top: 16px; padding-bottom: 13px; }
        .kasir-sidebar-user { margin-bottom: 10px; }
        .kasir-nav-title { margin-top: 12px; }
        .kasir-nav-link { min-height: 44px; }
        .kasir-sidebar-footer { padding-bottom: 10px; }
    }

    @media (max-width: 900px) {
        .kasir-sidebar {
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
        }
    }

    @media (max-width: 480px) {
        .kasir-sidebar-brand { padding: 22px 18px 18px; }
        .kasir-nav-link { min-height: 50px; }
        .kasir-nav-text { font-size: 14px; }
        .kasir-nav-title { font-size: 12px; }
    }

    /*
    |--------------------------------------------------------------------------
    | REDUCED MOTION
    |--------------------------------------------------------------------------
    */

    @media (prefers-reduced-motion: reduce) {

        .kasir-sidebar,
        .kasir-nav-link,
        .kasir-nav-icon,
        .kasir-logout-button {

            transition: none !important;

        }

    }

</style>


{{-- =========================================================================
     MOBILE SCRIPT
========================================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const sidebar =
            document.getElementById(
                'kasirSidebar'
            );

        const overlay =
            document.getElementById(
                'kasirSidebarOverlay'
            );

        const openButton =
            document.getElementById(
                'openKasirSidebar'
            );

        const closeButton =
            document.getElementById(
                'closeKasirSidebar'
            );


        /*
        |--------------------------------------------------------------------------
        | OPEN
        |--------------------------------------------------------------------------
        */

        function openSidebar() {

            if (!sidebar) {
                return;
            }

            sidebar.classList.add(
                'open'
            );

            if (overlay) {

                overlay.classList.add(
                    'show'
                );

                overlay.setAttribute(
                    'aria-hidden',
                    'false'
                );

            }

            document.body.classList.add(
                'sidebar-open'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE
        |--------------------------------------------------------------------------
        */

        function closeSidebar() {

            if (sidebar) {

                sidebar.classList.remove(
                    'open'
                );

            }

            if (overlay) {

                overlay.classList.remove(
                    'show'
                );

                overlay.setAttribute(
                    'aria-hidden',
                    'true'
                );

            }

            document.body.classList.remove(
                'sidebar-open'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | OPEN BUTTON
        |--------------------------------------------------------------------------
        */

        if (openButton) {

            openButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    openSidebar();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE BUTTON
        |--------------------------------------------------------------------------
        */

        if (closeButton) {

            closeButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    closeSidebar();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | OVERLAY
        |--------------------------------------------------------------------------
        */

        if (overlay) {

            overlay.addEventListener(
                'click',
                function () {

                    closeSidebar();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | NAVIGATION
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.kasir-nav-link'
            )
            .forEach(
                function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            if (
                                window.innerWidth <= 900
                            ) {

                                closeSidebar();

                            }

                        }
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | ESCAPE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape'
                ) {

                    closeSidebar();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | RESIZE
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'resize',
            function () {

                if (
                    window.innerWidth > 900
                ) {

                    closeSidebar();

                }

            }
        );

    }
);

</script>