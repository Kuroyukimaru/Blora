<nav id="public-navbar" class="ng-navbar" aria-label="Navigasi utama">

    <div class="ng-navbar-container">

        <a
            href="{{ url('/login') }}"
            class="ng-brand"
            aria-label="Login Noyo Gimbal"
        >
            <div class="ng-logo" aria-hidden="true">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Noyo Gimbal"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >

                <span class="ng-logo-fallback">NG</span>
            </div>

            <div class="ng-brand-info">
                <span class="ng-brand-name">Noyo Gimbal</span>
                <span class="ng-brand-tagline">Wisata & Kuliner Blora</span>
            </div>
        </a>

        <div class="ng-desktop-navigation">

            <a
                href="{{ route('public.home') }}"
                class="ng-nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}"
            >Home</a>

            <a
                href="{{ route('public.menu.index') }}"
                class="ng-nav-link {{ request()->routeIs('public.menu.*') ? 'active' : '' }}"
            >Menu</a>

            <a
                href="{{ route('public.tiket-wahana.index') }}"
                class="ng-nav-link {{ request()->routeIs('public.tiket-wahana.*') ? 'active' : '' }}"
            >Wahana</a>

            <a
                href="{{ route('public.oleholeh.index') }}"
                class="ng-nav-link {{ request()->routeIs('public.oleholeh.*') ? 'active' : '' }}"
            >Oleh-Oleh</a>

            <a
                href="{{ route('public.paketbundling.index') }}"
                class="ng-nav-link {{ request()->routeIs('public.paketbundling.*') ? 'active' : '' }}"
            >Paket</a>

            <a
                href="{{ route('public.event.index') }}"
                class="ng-nav-link {{ request()->routeIs('public.event.*') ? 'active' : '' }}"
            >Event</a>

            <a
                href="{{ route('public.home') }}#lokasi"
                class="ng-nav-link ng-map-link"
            >Maps</a>
        </div>

        <div class="ng-desktop-action">
            <a
                href="{{ route('pesanan.keranjang') }}"
                class="ng-cart-button"
                aria-label="Buka keranjang belanja"
            >
                <svg class="ng-cart-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M3.5 4.5h2l1.7 9.2a2 2 0 0 0 2 1.65h7.4a2 2 0 0 0 1.95-1.57L20 7H7" />
                    <circle cx="9.2" cy="19" r="1.2" />
                    <circle cx="17.4" cy="19" r="1.2" />
                </svg>
                <span>Keranjang</span>
            </a>
        </div>

        <a
            href="{{ route('pesanan.keranjang') }}"
            class="ng-mobile-cart"
            aria-label="Buka keranjang belanja"
            title="Keranjang"
        >
            <svg class="ng-cart-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M3.5 4.5h2l1.7 9.2a2 2 0 0 0 2 1.65h7.4a2 2 0 0 0 1.95-1.57L20 7H7" />
                <circle cx="9.2" cy="19" r="1.2" />
                <circle cx="17.4" cy="19" r="1.2" />
            </svg>
        </a>

        <button
            type="button"
            id="ng-mobile-button"
            class="ng-mobile-button"
            aria-label="Buka menu"
            aria-expanded="false"
            aria-controls="ng-mobile-menu"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>

    <div
        id="ng-mobile-menu"
        class="ng-mobile-menu"
        aria-hidden="true"
    >
        <div class="ng-mobile-menu-inner">

            <a
                href="{{ route('public.home') }}"
                class="ng-mobile-link {{ request()->routeIs('public.home') ? 'active' : '' }}"
            >
                <span>Home</span>
                @if(request()->routeIs('public.home'))
                    <span class="ng-active-dot" aria-hidden="true"></span>
                @endif
            </a>

            <a
                href="{{ route('public.menu.index') }}"
                class="ng-mobile-link {{ request()->routeIs('public.menu.*') ? 'active' : '' }}"
            >
                <span>Menu</span>
                @if(request()->routeIs('public.menu.*'))
                    <span class="ng-active-dot" aria-hidden="true"></span>
                @endif
            </a>

            <a
                href="{{ route('public.tiket-wahana.index') }}"
                class="ng-mobile-link {{ request()->routeIs('public.tiket-wahana.*') ? 'active' : '' }}"
            >
                <span>Wahana</span>
                @if(request()->routeIs('public.tiket-wahana.*'))
                    <span class="ng-active-dot" aria-hidden="true"></span>
                @endif
            </a>

            <a
                href="{{ route('public.oleholeh.index') }}"
                class="ng-mobile-link {{ request()->routeIs('public.oleholeh.*') ? 'active' : '' }}"
            >
                <span>Oleh-Oleh</span>
                @if(request()->routeIs('public.oleholeh.*'))
                    <span class="ng-active-dot" aria-hidden="true"></span>
                @endif
            </a>

            <a
                href="{{ route('public.paketbundling.index') }}"
                class="ng-mobile-link {{ request()->routeIs('public.paketbundling.*') ? 'active' : '' }}"
            >
                <span>Paket Bundling</span>
                @if(request()->routeIs('public.paketbundling.*'))
                    <span class="ng-active-dot" aria-hidden="true"></span>
                @endif
            </a>

            <a
                href="{{ route('public.event.index') }}"
                class="ng-mobile-link {{ request()->routeIs('public.event.*') ? 'active' : '' }}"
            >
                <span>Event</span>
                @if(request()->routeIs('public.event.*'))
                    <span class="ng-active-dot" aria-hidden="true"></span>
                @endif
            </a>

            <a
                href="{{ route('public.home') }}#lokasi"
                class="ng-mobile-link ng-map-link"
            >
                <span>Maps</span>
            </a>

            <div class="ng-mobile-divider" aria-hidden="true"></div>

            <a
                href="{{ route('pesanan.keranjang') }}"
                class="ng-mobile-action"
                aria-label="Buka keranjang belanja"
            >
                <span class="ng-mobile-action-main">
                    <svg class="ng-cart-icon ng-cart-icon-dark" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                        <path d="M3.5 4.5h2l1.7 9.2a2 2 0 0 0 2 1.65h7.4a2 2 0 0 0 1.95-1.57L20 7H7" />
                        <circle cx="9.2" cy="19" r="1.2" />
                        <circle cx="17.4" cy="19" r="1.2" />
                    </svg>
                    Keranjang
                </span>
                <span class="ng-mobile-action-arrow" aria-hidden="true">→</span>
            </a>

        </div>
    </div>

</nav>

<style>

    #public-navbar {
        --ng-bg-primary: #0a0a0a;
        --ng-bg-secondary: #151515;
        --ng-bg-soft: #1a1a1a;
        --ng-bg-card: #121212;

        --ng-text-primary: #f8f4ed;
        --ng-text-secondary: #d4c9b5;
        --ng-text-muted: #a89988;
        --ng-text-dim: #7a6f62;

        --ng-accent: #e2c997;
        --ng-accent-hover: #d4b384;
        --ng-accent-dark: #b89a6e;

        --ng-border-soft: rgba(255,255,255,.07);
        --ng-border-gold: rgba(226,201,151,.18);
        --ng-border-gold-strong: rgba(226,201,151,.34);

        --ng-shadow-soft: 0 18px 55px rgba(0,0,0,.34);
        --ng-shadow-hover: 0 22px 65px rgba(0,0,0,.48);

        --ng-radius-lg: 22px;
        --ng-radius-md: 15px;
        --ng-radius-sm: 12px;
        --ng-radius-full: 999px;

        --ng-transition: .24s cubic-bezier(.4,0,.2,1);
    }

    .ng-navbar,
    .ng-navbar *,
    .ng-navbar *::before,
    .ng-navbar *::after {
        box-sizing: border-box;
    }

    .ng-navbar {
        position: fixed;
        inset: 0 0 auto;
        z-index: 9999;
        width: 100%;
        background: rgba(10,10,10,.90);
        border-bottom: 1px solid var(--ng-border-soft);
        backdrop-filter: blur(22px) saturate(120%);
        -webkit-backdrop-filter: blur(22px) saturate(120%);
        box-shadow: 0 8px 28px rgba(0,0,0,.24);
    }

    .ng-navbar-container {
        width: min(1360px, calc(100% - 48px));
        min-height: 82px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 28px;
    }

    .ng-brand {
        display: inline-flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
        flex-shrink: 0;
        color: var(--ng-text-primary);
        text-decoration: none;
    }

    .ng-logo {
        position: relative;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 48px;
        overflow: hidden;
        border: 1px solid var(--ng-border-gold-strong);
        border-radius: 15px;
        background:
            radial-gradient(circle at 30% 25%, rgba(226,201,151,.18), transparent 45%),
            linear-gradient(145deg, rgba(226,201,151,.10), rgba(255,255,255,.025));
        box-shadow: 0 9px 25px rgba(0,0,0,.26);
    }

    .ng-logo img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
    }

    .ng-logo-fallback {
        display: none;
        width: 100%;
        height: 100%;
        align-items: center;
        justify-content: center;
        color: var(--ng-accent);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: .04em;
    }

    .ng-brand-info {
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .ng-brand-name {
        color: var(--ng-text-primary);
        font-family: "Playfair Display", Georgia, serif;
        font-size: 20px;
        line-height: 1.05;
        font-weight: 700;
        letter-spacing: -.015em;
        white-space: nowrap;
    }

    .ng-brand-tagline {
        color: var(--ng-text-muted);
        font-size: 10px;
        line-height: 1.2;
        font-weight: 600;
        letter-spacing: .095em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .ng-desktop-navigation {
        flex: 1 1 auto;
        min-width: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        margin-inline: auto;
    }

    .ng-nav-link {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 0 14px;
        border: 1px solid transparent;
        border-radius: var(--ng-radius-sm);
        color: var(--ng-text-secondary);
        font-size: 14px;
        font-weight: 600;
        line-height: 1;
        white-space: nowrap;
        text-decoration: none;
        transition:
            color var(--ng-transition),
            background var(--ng-transition),
            border-color var(--ng-transition),
            transform var(--ng-transition);
    }

    .ng-nav-link:hover,
    .ng-nav-link:focus-visible {
        color: var(--ng-text-primary);
        background: rgba(226,201,151,.055);
        border-color: var(--ng-border-gold);
        outline: none;
    }

    .ng-nav-link.active {
        color: var(--ng-accent);
        background: rgba(226,201,151,.085);
        border-color: var(--ng-border-gold);
    }

    .ng-nav-link.active::after,
    .ng-map-link.active::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: 6px;
        width: 5px;
        height: 5px;
        transform: translateX(-50%);
        border-radius: 50%;
        background: var(--ng-accent);
        box-shadow: 0 0 12px rgba(226,201,151,.55);
    }

    .ng-desktop-action {
        flex: 0 0 auto;
    }

    .ng-cart-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 46px;
        padding: 0 18px;
        border: 1px solid var(--ng-accent);
        border-radius: var(--ng-radius-full);
        background: linear-gradient(135deg, var(--ng-accent), var(--ng-accent-hover));
        color: var(--ng-bg-primary);
        font-size: 14px;
        font-weight: 800;
        line-height: 1;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 8px 24px rgba(226,201,151,.08);
        transition:
            transform var(--ng-transition),
            box-shadow var(--ng-transition),
            background var(--ng-transition),
            border-color var(--ng-transition);
    }

    .ng-cart-button:hover,
    .ng-cart-button:focus-visible {
        transform: translateY(-2px);
        background: linear-gradient(135deg, var(--ng-accent-hover), var(--ng-accent-dark));
        border-color: var(--ng-accent-hover);
        box-shadow: 0 13px 32px rgba(226,201,151,.14);
        outline: none;
    }

    .ng-cart-icon {
        width: 19px;
        height: 19px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.7;
        stroke-linecap: round;
        stroke-linejoin: round;
        flex: 0 0 auto;
    }

    .ng-mobile-cart {
        display: none;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        border: 1px solid var(--ng-border-gold);
        border-radius: 15px;
        background: rgba(226,201,151,.06);
        color: var(--ng-text-primary);
        text-decoration: none;
        transition:
            background var(--ng-transition),
            border-color var(--ng-transition),
            color var(--ng-transition),
            transform var(--ng-transition);
    }

    .ng-mobile-cart .ng-cart-icon {
        width: 21px;
        height: 21px;
    }

    .ng-mobile-cart:hover,
    .ng-mobile-cart:focus-visible {
        background: rgba(226,201,151,.12);
        border-color: var(--ng-border-gold-strong);
        color: var(--ng-accent);
        transform: translateY(-1px);
        outline: none;
    }

    .ng-mobile-cart:active {
        transform: scale(.97);
    }

    .ng-mobile-button {
        display: none;
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        margin-left: 0;
        padding: 0;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        border: 1px solid var(--ng-border-gold);
        border-radius: 15px;
        background: rgba(226,201,151,.06);
        color: var(--ng-text-primary);
        transition: background var(--ng-transition), border-color var(--ng-transition), transform var(--ng-transition);
    }

    .ng-mobile-button:hover,
    .ng-mobile-button:focus-visible {
        background: rgba(226,201,151,.11);
        border-color: var(--ng-border-gold-strong);
        outline: none;
    }

    .ng-mobile-button:active {
        transform: scale(.97);
    }

    .ng-mobile-button span {
        width: 21px;
        height: 2px;
        border-radius: var(--ng-radius-full);
        background: currentColor;
        transition: transform .22s ease, opacity .22s ease, background .22s ease;
    }

    .ng-mobile-button.open span:nth-child(1) {
        transform: translateY(7px) rotate(45deg);
    }

    .ng-mobile-button.open span:nth-child(2) {
        opacity: 0;
    }

    .ng-mobile-button.open span:nth-child(3) {
        transform: translateY(-7px) rotate(-45deg);
    }

    .ng-mobile-menu {
        display: none;
        width: 100%;
        border-top: 1px solid var(--ng-border-soft);
        background: rgba(10,10,10,.98);
        backdrop-filter: blur(22px) saturate(115%);
        -webkit-backdrop-filter: blur(22px) saturate(115%);
        box-shadow: 0 18px 42px rgba(0,0,0,.32);
    }

    .ng-mobile-menu.open {
        display: block;
        animation: ngMobileMenuOpen .22s ease-out;
    }

    .ng-mobile-menu-inner {
        width: min(720px, calc(100% - 28px));
        margin: 0 auto;
        padding: 14px 0 20px;
    }

    .ng-mobile-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        min-height: 56px;
        padding: 0 16px;
        border: 1px solid transparent;
        border-radius: var(--ng-radius-md);
        color: var(--ng-text-secondary);
        font-size: 17px;
        font-weight: 600;
        line-height: 1.2;
        text-decoration: none;
        transition: color var(--ng-transition), background var(--ng-transition), border-color var(--ng-transition);
    }

    .ng-mobile-link:hover,
    .ng-mobile-link:focus-visible {
        color: var(--ng-text-primary);
        background: rgba(226,201,151,.055);
        border-color: var(--ng-border-gold);
        outline: none;
    }

    .ng-mobile-link.active {
        color: var(--ng-accent);
        background: rgba(226,201,151,.09);
        border-color: var(--ng-border-gold);
    }

    .ng-active-dot {
        width: 7px;
        height: 7px;
        flex: 0 0 7px;
        border-radius: 50%;
        background: var(--ng-accent);
        box-shadow: 0 0 12px rgba(226,201,151,.55);
    }

    .ng-mobile-divider {
        width: 100%;
        height: 1px;
        margin: 13px 0;
        background: var(--ng-border-soft);
    }

    .ng-mobile-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        min-height: 58px;
        padding: 0 17px;
        border: 1px solid var(--ng-accent);
        border-radius: var(--ng-radius-md);
        background: linear-gradient(135deg, var(--ng-accent), var(--ng-accent-hover));
        color: var(--ng-bg-primary);
        font-size: 17px;
        font-weight: 800;
        line-height: 1.2;
        text-decoration: none;
        transition: transform var(--ng-transition), box-shadow var(--ng-transition), background var(--ng-transition);
    }

    .ng-mobile-action:hover,
    .ng-mobile-action:focus-visible {
        transform: translateY(-2px);
        background: linear-gradient(135deg, var(--ng-accent-hover), var(--ng-accent-dark));
        box-shadow: var(--ng-shadow-soft);
        outline: none;
    }

    .ng-mobile-action-main {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .ng-cart-icon-dark {
        width: 20px;
        height: 20px;
    }

    .ng-mobile-action-arrow {
        font-size: 22px;
        line-height: 1;
    }

    @keyframes ngMobileMenuOpen {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 1180px) {
        .ng-navbar-container {
            width: calc(100% - 36px);
            gap: 20px;
        }

        .ng-desktop-navigation {
            gap: 1px;
        }

        .ng-nav-link {
            padding-inline: 10px;
            font-size: 13px;
        }

        .ng-cart-button {
            padding-inline: 15px;
            font-size: 13px;
        }
    }

    @media (max-width: 960px) {
        .ng-navbar-container {
            min-height: 76px;
        }

        .ng-desktop-navigation,
        .ng-desktop-action {
            display: none;
        }

        .ng-mobile-cart {
            display: inline-flex;
            margin-left: auto;
        }

        .ng-mobile-button {
            display: flex;
        }

        .ng-brand-name {
            font-size: 19px;
        }
    }

    @media (max-width: 640px) {
        .ng-navbar-container {
            width: calc(100% - 24px);
            min-height: 70px;
            gap: 12px;
        }

        .ng-logo {
            width: 44px;
            height: 44px;
            flex-basis: 44px;
            border-radius: 13px;
        }

        .ng-brand-name {
            font-size: 18px;
        }

        .ng-brand-tagline {
            display: none;
        }

        .ng-mobile-cart,
        .ng-mobile-button {
            width: 44px;
            height: 44px;
            flex-basis: 44px;
            border-radius: 13px;
        }

        .ng-mobile-menu-inner {
            width: calc(100% - 20px);
            padding-top: 10px;
        }

        .ng-mobile-link {
            min-height: 54px;
            padding-inline: 14px;
            font-size: 16px;
        }

        .ng-mobile-action {
            min-height: 56px;
            font-size: 16px;
        }
    }

    @media (max-width: 400px) {
        .ng-navbar-container {
            width: calc(100% - 18px);
        }

        .ng-logo {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
        }

        .ng-brand-name {
            font-size: 17px;
        }

        .ng-mobile-cart,
        .ng-mobile-button {
            width: 42px;
            height: 42px;
            flex-basis: 42px;
        }

        .ng-mobile-link {
            min-height: 52px;
            font-size: 15px;
        }

        .ng-mobile-action {
            min-height: 54px;
            font-size: 15px;
        }
    }

    .ng-navbar a:focus-visible,
    .ng-navbar button:focus-visible {
        outline: 3px solid rgba(226,201,151,.55);
        outline-offset: 3px;
    }

    @media (prefers-reduced-motion: reduce) {
        .ng-navbar *,
        .ng-navbar *::before,
        .ng-navbar *::after {
            scroll-behavior: auto !important;
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
        }
    }

    html {
        scroll-behavior: smooth;
    }

    #lokasi {
        scroll-margin-top: 100px;
    }

    .ng-map-link {
        position: relative;
    }

    .ng-map-link.active {
        color: var(--ng-accent);
        background: rgba(226,201,151,.09);
        border-color: var(--ng-border-gold);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('ng-mobile-button');
        const menu = document.getElementById('ng-mobile-menu');
        const navbar = document.getElementById('public-navbar');

        if (!button || !menu || !navbar) {
            return;
        }

        function openMobileMenu() {
            menu.classList.add('open');
            button.classList.add('open');
            button.setAttribute('aria-expanded', 'true');
            button.setAttribute('aria-label', 'Tutup menu');
            menu.setAttribute('aria-hidden', 'false');
        }

        function closeMobileMenu() {
            menu.classList.remove('open');
            button.classList.remove('open');
            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('aria-label', 'Buka menu');
            menu.setAttribute('aria-hidden', 'true');
        }

        function toggleMobileMenu() {
            if (menu.classList.contains('open')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        }

        button.addEventListener('click', function (event) {
            event.stopPropagation();
            toggleMobileMenu();
        });

        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                closeMobileMenu();
            });
        });

        document.addEventListener('click', function (event) {
            if (!navbar.contains(event.target)) {
                closeMobileMenu();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMobileMenu();
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 960) {
                closeMobileMenu();
            }
        });
    });
</script>
