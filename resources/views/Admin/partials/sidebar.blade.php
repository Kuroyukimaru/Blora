<aside class="admin-sidebar">

    <div>

        <div class="sidebar-logo">
            NOYO GIMBAL
        </div>

        <nav class="sidebar-menu">

            <a href="{{ url('/admin/dashboard') }}"
               class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-house"></i>
                <span>Home</span>
            </a>

            <a href="{{ url('/admin/menu') }}"
               class="sidebar-link {{ request()->is('admin/menu*') ? 'active' : '' }}">
                <i class="fas fa-mug-hot"></i>
                <span>Menu</span>
            </a>

            <a href="{{ url('/admin/paketbundling') }}"
               class="sidebar-link {{ request()->is('admin/paketbundling*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i>
                <span>Paket Bundling</span>
            </a>

            <a href="{{ url('/admin/tiket-wahana') }}"
               class="sidebar-link {{ request()->is('admin/tiket-wahana*') ? 'active' : '' }}">
                <i class="fas fa-ticket"></i>
                <span>Tiket Wahana</span>
            </a>

            <a href="{{ url('/admin/event') }}"
               class="sidebar-link {{ request()->is('admin/event*') ? 'active' : '' }}">
                <i class="fas fa-calendar-days"></i>
                <span>Event & Berita</span>
            </a>

            <a href="{{ url('/admin/oleholeh') }}"
               class="sidebar-link {{ request()->is('admin/oleholeh*') ? 'active' : '' }}">
                <i class="fas fa-bag-shopping"></i>
                <span>Oleh-Oleh</span>
            </a>

        </nav>

    </div>

    <div>

        <form action="{{ url('/admin/logout') }}" method="POST">
            @csrf

            <button type="submit" class="sidebar-link logout-btn">

                <i class="fas fa-right-from-bracket"></i>

                <span>Logout</span>

            </button>

        </form>

    </div>

</aside>

<style>

/* ==========================================================================
   PREMIUM SIDEBAR STYLING
   ========================================================================== */

.admin-sidebar{
    width:290px;
    height:100vh;
    position:fixed;
    top:0;
    left:0;
    padding:34px 24px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    background:var(--bg-secondary);
    border-right:1px solid var(--border-soft);
    backdrop-filter:blur(20px);
    -webkit-backdrop-filter:blur(20px);
    z-index:999;
}

/* Logo */

.sidebar-logo{
    color:var(--text-primary);
    font-size:30px;
    font-weight:900;
    letter-spacing:1px;
    margin-bottom:60px;
    text-transform:uppercase;
}

/* Menu */

.sidebar-menu{
    display:flex;
    flex-direction:column;
    gap:14px;
}

/* Link */

.sidebar-link{
    width:100%;
    display:flex;
    align-items:center;
    gap:16px;
    padding:18px 20px;
    border-radius:20px;
    border:none;
    background:transparent;
    color:var(--text-secondary);
    text-decoration:none;
    transition:all var(--transition);
    font-weight:600;
    font-family:'Inter',sans-serif;
    text-align:left;
}

.sidebar-link i{
    width:22px;
    font-size:18px;
    transition:color var(--transition);
}

/* Hover */

.sidebar-link:hover{
    background:rgba(255,255,255,.04);
    color:var(--text-primary);
    transform:translateX(4px);
}

/* Active */

.sidebar-link.active{
    background:
        linear-gradient(
            135deg,
            var(--accent),
            var(--accent-hover)
        );
    color:var(--bg-primary);
    font-weight:700;
    box-shadow:
        0 10px 30px rgba(226,201,151,.15);
}

.sidebar-link.active i{
    color:var(--bg-primary);
}

/* Logout */

.logout-btn{
    cursor:pointer;
    outline:none;
}

.logout-btn:hover{
    background:rgba(220,53,69,.12);
    color:#ff7b7b;
    transform:translateX(4px);
}

.logout-btn:hover i{
    color:#ff7b7b;
}

</style>