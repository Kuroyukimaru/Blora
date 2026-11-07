@php

    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    $user = Auth::guard('admin')->user();

    $role = $user?->role ?? 'admin';

    $userName =
        $user?->nama
        ?? $user?->name
        ?? 'Administrator';

    $roleLabel = match ($role) {

        'admin' =>
            'Administrator',

        'kasir_menu' =>
            'Kasir Menu',

        'kasir_wahana' =>
            'Kasir Wahana',

        'kasir_oleholeh' =>
            'Kasir Oleh-Oleh',

        default =>
            'Administrator',
    };

    $trimmedName = trim(
        (string) $userName
    );

    $avatar = $trimmedName !== ''
        ? strtoupper(
            mb_substr(
                $trimmedName,
                0,
                1
            )
        )
        : 'A';

    $currentRoute =
        Route::currentRouteName() ?? '';

    $isDashboard =
        $currentRoute === 'admin.dashboard' ||
        $currentRoute === 'admin.home' ||
        request()->is('admin') ||
        request()->is('admin/dashboard');

    $isMenu =
        str_starts_with(
            $currentRoute,
            'admin.menu.'
        ) ||
        request()->is('admin/menu*');

    $isWahana =
        str_starts_with(
            $currentRoute,
            'admin.tiket-wahana.'
        ) ||
        str_starts_with(
            $currentRoute,
            'admin.wahana.'
        ) ||
        request()->is('admin/tiket-wahana*') ||
        request()->is('admin/wahana*');

    $isOlehOleh =
        str_starts_with(
            $currentRoute,
            'admin.oleholeh.'
        ) ||
        str_starts_with(
            $currentRoute,
            'admin.oleh-oleh.'
        ) ||
        request()->is('admin/oleholeh*') ||
        request()->is('admin/oleh-oleh*');

    $isBundling =
        str_starts_with(
            $currentRoute,
            'admin.paketbundling.'
        ) ||
        str_starts_with(
            $currentRoute,
            'admin.paket-bundling.'
        ) ||
        str_starts_with(
            $currentRoute,
            'admin.bundling.'
        ) ||
        request()->is('admin/paket-bundling*') ||
        request()->is('admin/bundling*');

    $isEvent =
        str_starts_with(
            $currentRoute,
            'admin.event.'
        ) ||
        request()->is('admin/event*');

    $dashboardUrl = Route::has(
        'admin.dashboard'
    )
        ? route('admin.dashboard')
        : url('/admin');

    $menuUrl = Route::has(
        'admin.menu.index'
    )
        ? route('admin.menu.index')
        : url('/admin/menu');

    $wahanaUrl = Route::has(
        'admin.tiket-wahana.index'
    )
        ? route('admin.tiket-wahana.index')
        : (
            Route::has(
                'admin.wahana.index'
            )
                ? route('admin.wahana.index')
                : url('/admin/tiket-wahana')
        );

    $oleholehUrl = Route::has(
        'admin.oleholeh.index'
    )
        ? route('admin.oleholeh.index')
        : (
            Route::has(
                'admin.oleh-oleh.index'
            )
                ? route('admin.oleh-oleh.index')
                : url('/admin/oleh-oleh')
        );

    $bundlingUrl = Route::has(
        'admin.paketbundling.index'
    )
        ? route('admin.paketbundling.index')
        : (
            Route::has(
                'admin.paket-bundling.index'
            )
                ? route('admin.paket-bundling.index')
                : (
                    Route::has(
                        'admin.bundling.index'
                    )
                        ? route('admin.bundling.index')
                        : url('/admin/paket-bundling')
                )
        );

    $eventUrl = Route::has(
        'admin.event.index'
    )
        ? route('admin.event.index')
        : url('/admin/event');

@endphp

<aside
    class="admin-sidebar"
    id="adminSidebar"
    aria-label="Sidebar Administrator"
>

    <div class="admin-sidebar-brand">

        <a
            href="{{ $dashboardUrl }}"
            class="admin-brand-link"
            aria-label="Dashboard Noyo Gimbal"
        >

            <div class="admin-brand-logo">
                NG
            </div>

            <div class="admin-brand-text">

                <strong>
                    Noyo Gimbal
                </strong>

                <span>
                    Admin Panel
                </span>

            </div>        </a>

        <button
            type="button"
            class="admin-sidebar-close-button"
            id="closeAdminSidebar"
            aria-label="Tutup menu navigasi"
            title="Tutup menu"
        >
            <i class="fas fa-xmark"></i>
        </button>

    </div>

    <div class="admin-sidebar-user">

        <div
            class="admin-user-avatar"
            aria-hidden="true"
        >
            {{ $avatar }}
        </div>

        <div class="admin-user-info">

            <strong title="{{ $userName }}">
                {{ $userName }}
            </strong>

            <span>
                {{ $roleLabel }}
            </span>

        </div>

    </div>

    <nav
        class="admin-sidebar-nav"
        aria-label="Navigasi Administrator"
    >

        <div class="admin-nav-title">
            Menu Utama
        </div>

        <a
            href="{{ $dashboardUrl }}"
            class="admin-nav-link {{ $isDashboard ? 'active' : '' }}"
            aria-current="{{ $isDashboard ? 'page' : 'false' }}"
        >

            <span class="admin-nav-icon">
                <i class="fas fa-house"></i>
            </span>

            <span class="admin-nav-text">
                Dashboard
            </span>

        </a>

        <div class="admin-nav-title">
            Data Master
        </div>

        <a
            href="{{ $menuUrl }}"
            class="admin-nav-link {{ $isMenu ? 'active' : '' }}"
            aria-current="{{ $isMenu ? 'page' : 'false' }}"
        >

            <span class="admin-nav-icon">
                <i class="fas fa-utensils"></i>
            </span>

            <span class="admin-nav-text">
                Menu
            </span>

        </a>

        <a
            href="{{ $wahanaUrl }}"
            class="admin-nav-link {{ $isWahana ? 'active' : '' }}"
            aria-current="{{ $isWahana ? 'page' : 'false' }}"
        >

            <span class="admin-nav-icon">
                <i class="fas fa-ticket"></i>
            </span>

            <span class="admin-nav-text">
                Tiket Wahana
            </span>

        </a>

        <a
            href="{{ $oleholehUrl }}"
            class="admin-nav-link {{ $isOlehOleh ? 'active' : '' }}"
            aria-current="{{ $isOlehOleh ? 'page' : 'false' }}"
        >

            <span class="admin-nav-icon">
                <i class="fas fa-bag-shopping"></i>
            </span>

            <span class="admin-nav-text">
                Oleh-Oleh
            </span>

        </a>

        <a
            href="{{ $bundlingUrl }}"
            class="admin-nav-link {{ $isBundling ? 'active' : '' }}"
            aria-current="{{ $isBundling ? 'page' : 'false' }}"
        >

            <span class="admin-nav-icon">
                <i class="fas fa-boxes-stacked"></i>
            </span>

            <span class="admin-nav-text">
                Paket Bundling
            </span>

        </a>

        <a
            href="{{ $eventUrl }}"
            class="admin-nav-link {{ $isEvent ? 'active' : '' }}"
            aria-current="{{ $isEvent ? 'page' : 'false' }}"
        >

            <span class="admin-nav-icon">
                <i class="fas fa-calendar-days"></i>
            </span>

            <span class="admin-nav-text">
                Event
            </span>

        </a>

    </nav>

    <div class="admin-sidebar-footer">

        <div class="admin-system-status">

            <span
                class="admin-status-dot"
                aria-hidden="true"
            ></span>

            <span>
                Sistem Aktif
            </span>

        </div>

        @if(Route::has('logout'))

            <form
                action="{{ route('logout') }}"
                method="POST"
                class="admin-logout-form"
            >

                @csrf

                <button
                    type="submit"
                    class="admin-logout-button"
                >

                    <span class="admin-logout-icon">
                        <i class="fas fa-right-from-bracket"></i>
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
                class="admin-logout-form"
            >

                @csrf

                <button
                    type="submit"
                    class="admin-logout-button"
                >

                    <span class="admin-logout-icon">
                        <i class="fas fa-right-from-bracket"></i>
                    </span>

                    <span>
                        Keluar
                    </span>

                </button>

            </form>

        @endif

        <div class="admin-sidebar-copyright">

            <span>
                © {{ date('Y') }} Noyo Gimbal
            </span>

            <small>
                Administrator
            </small>

        </div>

    </div>

</aside>

<div
    class="admin-sidebar-overlay"
    id="adminSidebarOverlay"
    aria-hidden="true"
></div>

<style>
:root{
    --admin-sidebar-width:280px;

    --admin-bg:#0a0a0a;
    --admin-bg-secondary:#151515;
    --admin-bg-soft:#1a1a1a;
    --admin-bg-card:#121212;

    --admin-text:#f8f4ed;
    --admin-text-secondary:#d4c9b5;
    --admin-text-muted:#a89988;
    --admin-text-dim:#8d8172;

    --admin-accent:#e2c997;
    --admin-accent-hover:#d4b384;
    --admin-accent-dark:#b89a6e;

    --admin-accent-soft:rgba(226,201,151,.09);
    --admin-accent-medium:rgba(226,201,151,.15);

    --admin-border:rgba(255,255,255,.07);
    --admin-border-gold:rgba(226,201,151,.15);

    --admin-shadow:0 20px 60px rgba(0,0,0,.40);
    --admin-shadow-hover:0 25px 70px rgba(0,0,0,.52);

    --admin-radius-lg:20px;
    --admin-radius-md:15px;
    --admin-radius-sm:12px;

    --admin-transition:.25s cubic-bezier(.4,0,.2,1);

    --admin-green:#7fc995;
}

.admin-sidebar{
    position:fixed;
    inset:0 auto 0 0;
    z-index:1100;

    width:var(--admin-sidebar-width);
    height:100dvh;

    display:flex;
    flex-direction:column;

    background:
        radial-gradient(
            circle at 0% 0%,
            rgba(226,201,151,.045),
            transparent 32%
        ),
        linear-gradient(
            180deg,
            #0b0b0b 0%,
            #0a0a0a 100%
        );

    color:var(--admin-text);
    border-right:1px solid var(--admin-border);

    overflow:hidden;

    font-family:'Inter','DM Sans',Arial,sans-serif;

    box-shadow:18px 0 55px rgba(0,0,0,.16);

    isolation:isolate;
}

.admin-sidebar::after{
    content:'';
    position:absolute;
    top:0;
    right:0;
    width:1px;
    height:100%;

    background:linear-gradient(
        to bottom,
        transparent,
        rgba(226,201,151,.10),
        transparent
    );

    pointer-events:none;
}

.admin-sidebar-brand{
    flex:0 0 auto;
    padding:27px 21px 20px;
}


.admin-sidebar-close-button{
    display:none;

    position:absolute;
    top:18px;
    right:15px;

    width:42px;
    height:42px;

    align-items:center;
    justify-content:center;

    padding:0;

    color:var(--admin-text-muted);

    background:rgba(255,255,255,.035);

    border:1px solid rgba(255,255,255,.075);
    border-radius:11px;

    font-family:inherit;
    font-size:16px;

    cursor:pointer;

    transition:
        color var(--admin-transition),
        background var(--admin-transition),
        border-color var(--admin-transition),
        transform var(--admin-transition);
}

.admin-sidebar-close-button:hover{
    color:var(--admin-accent);

    background:rgba(226,201,151,.09);

    border-color:var(--admin-border-gold);

    transform:scale(1.03);
}

.admin-sidebar-close-button:active{
    transform:scale(.96);
}

.admin-sidebar-close-button:focus-visible{
    outline:2px solid rgba(226,201,151,.70);
    outline-offset:3px;
}

.admin-brand-link{
    display:flex;
    align-items:center;
    gap:13px;

    min-width:0;

    color:var(--admin-text);
    text-decoration:none;

    transition:transform var(--admin-transition);
}

.admin-brand-link:hover{
    transform:translateX(2px);
}

.admin-brand-logo{
    width:47px;
    height:47px;
    flex:0 0 47px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:linear-gradient(
        135deg,
        var(--admin-accent),
        var(--admin-accent-hover)
    );

    color:var(--admin-bg);

    border:1px solid rgba(226,201,151,.28);
    border-radius:13px;

    font-size:13px;
    font-weight:800;
    letter-spacing:1px;

    box-shadow:0 7px 22px rgba(226,201,151,.08);

    position:relative;
    overflow:hidden;
}

.admin-brand-logo::before{
    content:'';
    position:absolute;
    inset:0;

    background:linear-gradient(
        120deg,
        transparent 25%,
        rgba(255,255,255,.30),
        transparent 75%
    );

    transform:translateX(-120%);
    transition:transform .6s ease;
}

.admin-brand-link:hover .admin-brand-logo::before{
    transform:translateX(120%);
}

.admin-brand-text{
    min-width:0;
}

.admin-brand-text strong{
    display:block;

    overflow:hidden;

    color:var(--admin-text);

    font-family:'Playfair Display',Georgia,serif;
    font-size:19px;
    line-height:1.2;
    font-weight:700;
    letter-spacing:-.15px;

    text-overflow:ellipsis;
    white-space:nowrap;
}

.admin-brand-text span{
    display:block;

    margin-top:6px;

    color:var(--admin-accent);

    font-size:10px;
    line-height:1.1;
    font-weight:700;
    letter-spacing:1.35px;
    text-transform:uppercase;
}

.admin-sidebar-user{
    display:flex;
    align-items:center;
    gap:12px;

    flex:0 0 auto;

    margin:0 15px 20px;
    padding:13px;

    background:rgba(255,255,255,.028);

    border:1px solid var(--admin-border);
    border-radius:var(--admin-radius-md);

    box-shadow:inset 0 1px 0 rgba(255,255,255,.02);

    transition:
        background var(--admin-transition),
        border-color var(--admin-transition),
        transform var(--admin-transition);
}

.admin-sidebar-user:hover{
    background:rgba(226,201,151,.045);
    border-color:var(--admin-border-gold);
    transform:translateY(-1px);
}

.admin-user-avatar{
    width:43px;
    height:43px;
    flex:0 0 43px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:rgba(226,201,151,.09);

    color:var(--admin-accent);

    border:1px solid rgba(226,201,151,.18);
    border-radius:12px;

    font-size:14px;
    font-weight:800;
}

.admin-user-info{
    min-width:0;
    flex:1;
}

.admin-user-info strong{
    display:block;

    overflow:hidden;

    color:var(--admin-text);

    font-size:15px;
    line-height:1.35;
    font-weight:600;

    text-overflow:ellipsis;
    white-space:nowrap;
}

.admin-user-info span{
    display:block;

    margin-top:4px;

    overflow:hidden;

    color:var(--admin-text-muted);

    font-size:13px;
    line-height:1.35;
    font-weight:500;

    text-overflow:ellipsis;
    white-space:nowrap;
}

.admin-sidebar-nav{
    flex:1 1 auto;
    min-height:0;

    padding:0 13px 10px;

    overflow-x:hidden;
    overflow-y:auto;

    scrollbar-width:thin;
    scrollbar-color:rgba(226,201,151,.18) transparent;
}

.admin-sidebar-nav::-webkit-scrollbar{
    width:5px;
}

.admin-sidebar-nav::-webkit-scrollbar-track{
    background:transparent;
}

.admin-sidebar-nav::-webkit-scrollbar-thumb{
    background:rgba(226,201,151,.18);
    border-radius:999px;
}

.admin-nav-title{
    margin:19px 11px 9px;

    color:var(--admin-text-dim);

    font-size:11px;
    line-height:1.25;
    font-weight:700;
    letter-spacing:1.25px;

    text-transform:uppercase;
}

.admin-nav-title:first-child{
    margin-top:3px;
}

.admin-nav-link{
    position:relative;

    display:flex;
    align-items:center;
    gap:13px;

    width:100%;
    min-height:52px;

    margin:4px 0;
    padding:0 11px;

    color:rgba(248,244,237,.72);

    text-decoration:none;

    border:1px solid transparent;
    border-radius:var(--admin-radius-sm);

    transition:
        background var(--admin-transition),
        color var(--admin-transition),
        border-color var(--admin-transition),
        transform var(--admin-transition);
}

.admin-nav-link:hover{
    color:var(--admin-text);

    background:rgba(255,255,255,.032);
    border-color:rgba(255,255,255,.05);

    transform:translateX(2px);
}

.admin-nav-link:focus-visible{
    outline:2px solid rgba(226,201,151,.65);
    outline-offset:2px;
}

.admin-nav-link.active{
    color:var(--admin-text);

    background:linear-gradient(
        135deg,
        rgba(226,201,151,.105),
        rgba(226,201,151,.035)
    );

    border-color:var(--admin-border-gold);

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.02),
        0 7px 22px rgba(0,0,0,.10);
}

.admin-nav-link.active::before{
    content:'';

    position:absolute;
    left:-1px;
    top:9px;
    bottom:9px;

    width:4px;

    background:linear-gradient(
        to bottom,
        var(--admin-accent),
        var(--admin-accent-dark)
    );

    border-radius:0 5px 5px 0;

    box-shadow:0 0 10px rgba(226,201,151,.20);
}

.admin-nav-icon{
    width:38px;
    height:38px;
    flex:0 0 38px;

    display:flex;
    align-items:center;
    justify-content:center;

    color:rgba(248,244,237,.58);

    font-size:14px;

    border-radius:10px;

    transition:
        color var(--admin-transition),
        background var(--admin-transition),
        transform var(--admin-transition);
}

.admin-nav-link:hover .admin-nav-icon{
    color:var(--admin-accent);
    background:rgba(226,201,151,.05);
    transform:scale(1.03);
}

.admin-nav-link.active .admin-nav-icon{
    color:var(--admin-accent);
    background:var(--admin-accent-soft);

    box-shadow:
        inset 0 0 0 1px rgba(226,201,151,.065);
}

.admin-nav-text{
    flex:1;
    min-width:0;

    overflow:hidden;

    font-size:15px;
    line-height:1.35;
    font-weight:500;
    letter-spacing:0;

    text-overflow:ellipsis;
    white-space:nowrap;
}

.admin-nav-link.active .admin-nav-text{
    font-weight:600;
}

.admin-sidebar-footer{
    flex:0 0 auto;

    padding:13px 15px 17px;

    border-top:1px solid var(--admin-border);

    background:rgba(10,10,10,.88);

    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);
}

.admin-system-status{
    display:flex;
    align-items:center;
    gap:9px;

    margin-bottom:9px;
    padding:10px 11px;

    color:var(--admin-text-muted);

    background:rgba(255,255,255,.022);

    border:1px solid rgba(255,255,255,.04);
    border-radius:10px;

    font-size:12px;
    font-weight:500;
}

.admin-status-dot{
    width:7px;
    height:7px;
    flex:0 0 7px;

    background:var(--admin-green);
    border-radius:50%;

    box-shadow:
        0 0 0 3px rgba(127,201,149,.075),
        0 0 9px rgba(127,201,149,.15);
}

.admin-logout-form{
    width:100%;
    margin:0;
}

.admin-logout-button{
    display:flex;
    align-items:center;
    gap:10px;

    width:100%;
    min-height:45px;

    padding:0 10px;

    color:rgba(248,244,237,.66);

    background:transparent;

    border:1px solid transparent;
    border-radius:10px;

    font-family:inherit;
    font-size:14px;
    font-weight:500;

    cursor:pointer;

    transition:
        background var(--admin-transition),
        border-color var(--admin-transition),
        color var(--admin-transition);
}

.admin-logout-button:hover{
    color:var(--admin-text);

    background:rgba(226,201,151,.05);
    border-color:rgba(226,201,151,.075);
}

.admin-logout-button:focus-visible{
    outline:2px solid rgba(226,201,151,.65);
    outline-offset:2px;
}

.admin-logout-icon{
    width:30px;
    height:30px;
    flex:0 0 30px;

    display:flex;
    align-items:center;
    justify-content:center;

    color:var(--admin-text-dim);

    font-size:12px;

    border-radius:8px;

    transition:
        color var(--admin-transition),
        background var(--admin-transition);
}

.admin-logout-button:hover .admin-logout-icon{
    color:var(--admin-accent);
    background:var(--admin-accent-soft);
}

.admin-sidebar-copyright{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:8px;

    margin-top:10px;
    padding:10px 1px 0;

    color:var(--admin-text-dim);

    border-top:1px solid rgba(255,255,255,.04);

    font-size:10px;
}

.admin-sidebar-copyright small{
    color:var(--admin-text-dim);
    font-size:10px;
}

.admin-sidebar-overlay{
    display:none;

    position:fixed;
    inset:0;

    z-index:1090;

    background:rgba(0,0,0,.64);

    backdrop-filter:blur(5px);
    -webkit-backdrop-filter:blur(5px);

    opacity:0;
    transition:opacity .25s ease;
}

.admin-sidebar-overlay.show{
    display:block;
    opacity:1;
}

body.admin-sidebar-open{
    overflow:hidden;
}

@media (min-width:1400px){
    :root{
        --admin-sidebar-width:290px;
    }

    .admin-sidebar-brand{
        padding:30px 23px 22px;
    }

    .admin-brand-logo{
        width:49px;
        height:49px;
        flex-basis:49px;
    }

    .admin-brand-text strong{
        font-size:20px;
    }

    .admin-sidebar-user{
        margin-left:17px;
        margin-right:17px;
        padding:14px;
    }

    .admin-nav-link{
        min-height:54px;
    }

    .admin-nav-text{
        font-size:15.5px;
    }
}

@media (min-width:901px) and (max-width:1199px){
    :root{
        --admin-sidebar-width:270px;
    }

    .admin-sidebar-brand{
        padding:24px 18px 19px;
    }

    .admin-brand-logo{
        width:44px;
        height:44px;
        flex-basis:44px;
    }

    .admin-brand-text strong{
        font-size:18px;
    }

    .admin-brand-text span{
        font-size:9px;
    }

    .admin-sidebar-user{
        margin-left:13px;
        margin-right:13px;
        padding:11px;
    }

    .admin-user-avatar{
        width:41px;
        height:41px;
        flex-basis:41px;
    }

    .admin-user-info strong{
        font-size:14px;
    }

    .admin-user-info span{
        font-size:12px;
    }

    .admin-sidebar-nav{
        padding-left:11px;
        padding-right:11px;
    }

    .admin-nav-link{
        min-height:50px;
    }

    .admin-nav-icon{
        width:36px;
        height:36px;
        flex-basis:36px;
    }

    .admin-nav-text{
        font-size:14.5px;
    }

    .admin-nav-title{
        font-size:10.5px;
    }

    .admin-sidebar-footer{
        padding-left:13px;
        padding-right:13px;
    }
}

@media (max-width:900px){
    .admin-sidebar-close-button{
        display:flex;
    }


    .admin-sidebar{
        width:min(330px,88vw);

        transform:translate3d(-100%,0,0);

        transition:
            transform .3s cubic-bezier(.4,0,.2,1);

        box-shadow:20px 0 65px rgba(0,0,0,.48);

        will-change:transform;
    }

    .admin-sidebar.open{
        transform:translate3d(0,0,0);
    }

    .admin-sidebar-brand{
        padding:27px 21px 20px;
    }

    .admin-sidebar-user{
        margin-left:15px;
        margin-right:15px;
    }

    .admin-nav-link{
        min-height:53px;
    }

    .admin-nav-icon{
        width:39px;
        height:39px;
        flex-basis:39px;
        font-size:14px;
    }

    .admin-nav-text{
        font-size:15.5px;
    }

    .admin-nav-title{
        font-size:11px;
    }

    .admin-sidebar-footer{
        padding-bottom:max(17px,env(safe-area-inset-bottom));
    }

    .admin-sidebar-overlay{
        touch-action:none;
    }
}

@media (min-width:601px) and (max-width:900px){
    .admin-sidebar{
        width:320px;
    }

    .admin-sidebar-brand{
        padding:29px 22px 21px;
    }

    .admin-sidebar-user{
        margin-bottom:21px;
        padding:13px;
    }

    .admin-nav-title{
        margin-top:20px;
    }

    .admin-nav-link{
        min-height:54px;
    }
}

@media (max-width:600px){
    .admin-sidebar{
        width:min(320px,90vw);
    }

    .admin-sidebar-brand{
        padding:24px 18px 18px;
    }

    .admin-brand-logo{
        width:45px;
        height:45px;
        flex-basis:45px;
        border-radius:12px;
    }

    .admin-brand-text strong{
        font-size:18px;
    }

    .admin-brand-text span{
        margin-top:5px;
        font-size:8.5px;
    }

    .admin-sidebar-user{
        margin:0 13px 18px;
        padding:12px;
    }

    .admin-user-avatar{
        width:41px;
        height:41px;
        flex-basis:41px;
        font-size:13px;
    }

    .admin-user-info strong{
        font-size:14.5px;
    }

    .admin-user-info span{
        font-size:12.5px;
    }

    .admin-sidebar-nav{
        padding:0 11px 8px;
    }

    .admin-nav-title{
        margin:17px 10px 8px;
        font-size:10.5px;
    }

    .admin-nav-link{
        min-height:52px;
        margin:4px 0;
        padding:0 10px;
        border-radius:11px;
    }

    .admin-nav-icon{
        width:37px;
        height:37px;
        flex-basis:37px;
        font-size:13.5px;
    }

    .admin-nav-text{
        font-size:15px;
    }

    .admin-sidebar-footer{
        padding:12px 13px max(15px,env(safe-area-inset-bottom));
    }

    .admin-system-status{
        padding:9px 10px;
        font-size:12px;
    }

    .admin-logout-button{
        min-height:44px;
        font-size:14px;
    }
}

@media (max-width:380px){
    .admin-sidebar{
        width:min(310px,91vw);
    }

    .admin-sidebar-brand{
        padding:21px 16px 16px;
    }

    .admin-brand-logo{
        width:42px;
        height:42px;
        flex-basis:42px;
    }

    .admin-brand-text strong{
        font-size:17px;
    }

    .admin-brand-text span{
        font-size:8px;
    }

    .admin-sidebar-user{
        margin-left:11px;
        margin-right:11px;
        padding:11px;
    }

    .admin-user-avatar{
        width:39px;
        height:39px;
        flex-basis:39px;
    }

    .admin-user-info strong{
        font-size:14px;
    }

    .admin-user-info span{
        font-size:12px;
    }

    .admin-sidebar-nav{
        padding-left:9px;
        padding-right:9px;
    }

    .admin-nav-link{
        min-height:50px;
    }

    .admin-nav-icon{
        width:36px;
        height:36px;
        flex-basis:36px;
    }

    .admin-nav-text{
        font-size:14.5px;
    }

    .admin-sidebar-footer{
        padding-left:11px;
        padding-right:11px;
    }
}

@media (max-height:700px) and (min-width:901px){
    .admin-sidebar-brand{
        padding-top:19px;
        padding-bottom:16px;
    }

    .admin-sidebar-user{
        margin-bottom:15px;
        padding:11px;
    }

    .admin-user-avatar{
        width:39px;
        height:39px;
        flex-basis:39px;
    }

    .admin-user-info strong{
        font-size:14px;
    }

    .admin-user-info span{
        font-size:12px;
    }

    .admin-nav-title{
        margin-top:14px;
        margin-bottom:6px;
    }

    .admin-nav-link{
        min-height:46px;
        margin:3px 0;
    }

    .admin-nav-icon{
        width:34px;
        height:34px;
        flex-basis:34px;
    }

    .admin-nav-text{
        font-size:14px;
    }

    .admin-sidebar-footer{
        padding-top:10px;
        padding-bottom:11px;
    }
}

@media (max-width:900px){
    .admin-sidebar-overlay{
        display:block;
        pointer-events:none;
    }

    .admin-sidebar-overlay.show{
        pointer-events:auto;
    }
}

@media (min-width:901px){
    .admin-sidebar-overlay{
        display:none !important;
    }
}

@media (prefers-reduced-motion:reduce){
    .admin-sidebar,
    .admin-brand-link,
    .admin-nav-link,
    .admin-nav-icon,
    .admin-logout-button,
    .admin-sidebar-user,
    .admin-sidebar-overlay{
        transition:none !important;
    }
}
</style>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const sidebar =
            document.getElementById(
                'adminSidebar'
            );

        const overlay =
            document.getElementById(
                'adminSidebarOverlay'
            );

        const openButton =
            document.getElementById(
                'openAdminSidebar'
            );

        const closeButton =
            document.getElementById(
                'closeAdminSidebar'
            );

        function openAdminSidebar() {

            if (!sidebar) {

                return;
            }

            sidebar.classList.add(
                'open'
            );

            if (openButton) {
                openButton.setAttribute(
                    'aria-expanded',
                    'true'
                );
            }

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
                'admin-sidebar-open'
            );
        }

        function closeAdminSidebar() {

            if (sidebar) {

                sidebar.classList.remove(
                    'open'
                );
            }

            if (openButton) {
                openButton.setAttribute(
                    'aria-expanded',
                    'false'
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
                'admin-sidebar-open'
            );
        }

        if (openButton) {

            openButton.addEventListener(
                'click',
                openAdminSidebar
            );
        }

        if (closeButton) {

            closeButton.addEventListener(
                'click',
                closeAdminSidebar
            );
        }

        if (overlay) {

            overlay.addEventListener(
                'click',
                closeAdminSidebar
            );
        }

        document
            .querySelectorAll(
                '.admin-nav-link'
            )
            .forEach(
                function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            if (
                                window.innerWidth <= 900
                            ) {

                                closeAdminSidebar();
                            }
                        }
                    );
                }
            );

        document.addEventListener(
            'keydown',
            function (event) {

                if (
                    event.key === 'Escape'
                ) {

                    closeAdminSidebar();
                }
            }
        );

        window.addEventListener(
            'resize',
            function () {

                if (
                    window.innerWidth > 900
                ) {

                    closeAdminSidebar();
                }
            }
        );

    }
);

</script>
