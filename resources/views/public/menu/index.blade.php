<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Semua Menu | Noyo Gimbal
    </title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body>

    <!-- NAVBAR -->
    @include('public.partials.navbar')

    <!-- MENU PAGE -->
    <section class="menu-page">

        <!-- BACKGROUND -->
        <div class="menu-glow glow-1"></div>

        <div class="menu-glow glow-2"></div>

        <!-- CONTAINER -->
        <div class="container-custom position-relative"
             style="z-index:5;">

            <!-- HEADER -->
            <div class="menu-header text-center">

                <span class="menu-subtitle">

                    FOOD & PACKAGE

                </span>

                <h1 class="menu-title text-gradient">

                    Semua Menu

                </h1>

                <p class="menu-description">

                    Nikmati berbagai pilihan
                    menu terbaik khas Noyo Gimbal
                    dengan cita rasa tradisional
                    dan pengalaman modern.

                </p>

            </div>

            <!-- FILTER -->
            <div class="menu-filter">

                <button class="filter-btn active"
                        data-filter="all">

                    Semua

                </button>

                <button class="filter-btn"
                        data-filter="Paket">

                    Paket

                </button>

                <button class="filter-btn"
                        data-filter="Minuman">

                    Minuman

                </button>

                <button class="filter-btn"
                        data-filter="Sambal">

                    Sambal

                </button>

                <button class="filter-btn"
                        data-filter="Lainnya">

                    Lainnya

                </button>

            </div>

            <!-- GRID -->
            <div class="row g-4">

                @forelse($menus->where('status', 'Tersedia') as $menu)

                    <!-- ITEM -->
                    <div class="col-lg-4 col-md-6 menu-item"
                         data-category="{{ $menu->kategori }}">

                        <!-- CARD -->
                        <article class="menu-card glass-effect">

                            <!-- IMAGE -->
                            <div class="menu-image-wrapper">

                                @if($menu->gambar)

                                    <img src="{{ asset('storage/' . $menu->gambar) }}"
                                         alt="{{ $menu->nama_menu }}"
                                         class="menu-image"

                                         onerror="
                                            this.onerror=null;
                                            this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop';
                                         ">

                                @else

                                    <!-- FALLBACK -->
                                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop"
                                         alt="{{ $menu->nama_menu }}"
                                         class="menu-image">

                                @endif

                                <!-- OVERLAY -->
                                <div class="menu-overlay"></div>

                                <!-- CATEGORY -->
                                <span class="menu-badge">

                                    {{ $menu->kategori }}

                                </span>

                            </div>

                            <!-- CONTENT -->
                            <div class="menu-content">

                                <!-- TITLE -->
                                <h3 class="menu-name">

                                    {{ $menu->nama_menu }}

                                </h3>

                                <!-- DESCRIPTION -->
                                <p class="menu-text">

                                    {{ Str::limit($menu->deskripsi, 120) }}

                                </p>

                                <!-- FOOTER -->
                                <div class="menu-footer">

                                    <!-- PRICE -->
                                    <div>

                                        <span class="price-label">

                                            Harga

                                        </span>

                                        <h4 class="menu-price">

                                            Rp {{ number_format($menu->harga,0,',','.') }}

                                        </h4>

                                    </div>

                                    <!-- BUTTON -->
                                    <a href="#"
                                       class="btn-menu-modern">

                                        <span>

                                            Pesan

                                        </span>

                                        <i class="fas fa-arrow-right"></i>

                                    </a>

                                </div>

                            </div>

                        </article>

                    </div>

                @empty

                    <!-- EMPTY -->
                    <div class="col-12">

                        <div class="empty-menu glass-effect">

                            <div class="empty-icon">

                                <i class="fas fa-utensils"></i>

                            </div>

                            <h3>

                                Belum Ada Menu

                            </h3>

                            <p>

                                Menu belum tersedia.

                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </section>

    <!-- FOOTER -->
    @include('public.partials.footer')

<script>

/*
|--------------------------------------------------------------------------
| FILTER MENU
|--------------------------------------------------------------------------
*/

const filterButtons =
    document.querySelectorAll('.filter-btn')

const menuItems =
    document.querySelectorAll('.menu-item')

filterButtons.forEach(button => {

    button.addEventListener('click', () => {

        /*
        |--------------------------------------------------------------------------
        | REMOVE ACTIVE
        |--------------------------------------------------------------------------
        */

        filterButtons.forEach(btn => {

            btn.classList.remove('active')

        })

        /*
        |--------------------------------------------------------------------------
        | ACTIVE BUTTON
        |--------------------------------------------------------------------------
        */

        button.classList.add('active')

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        const filter =
            button.dataset.filter

        /*
        |--------------------------------------------------------------------------
        | LOOP ITEMS
        |--------------------------------------------------------------------------
        */

        menuItems.forEach(item => {

            const category =
                item.dataset.category

            if(
                filter === 'all' ||
                category === filter
            ){

                item.style.display =
                    'block'

            }else{

                item.style.display =
                    'none'
            }
        })

    })

})

</script>

<style>

/*
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
*/

.menu-page{

    position:relative;

    min-height:100vh;

    padding:
        180px 0
        120px;

    background:
        #000000;

    overflow:hidden;
}

/*
|--------------------------------------------------------------------------
| BACKGROUND
|--------------------------------------------------------------------------
*/

.menu-glow{

    position:absolute;

    width:500px;
    height:500px;

    border-radius:50%;

    filter:blur(120px);

    opacity:.05;

    z-index:1;
}

.glow-1{

    top:-250px;
    left:-200px;

    background:
        #000000;
}

.glow-2{

    bottom:-250px;
    right:-200px;

    background:
        #000000;
}

/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

.menu-header{

    max-width:760px;

    margin:
        0 auto
        80px;
}

.menu-subtitle{

    display:inline-block;

    margin-bottom:20px;

    color:
        var(--accent);

    font-size:13px;

    font-weight:700;

    letter-spacing:4px;
}

.menu-title{

    font-size:
        clamp(52px,6vw,92px);

    font-weight:900;

    line-height:1;

    margin-bottom:24px;
}

.menu-description{

    color:
        var(--text-secondary);

    font-size:18px;

    line-height:1.9;
}

/*
|--------------------------------------------------------------------------
| FILTER
|--------------------------------------------------------------------------
*/

.menu-filter{

    display:flex;

    align-items:center;

    justify-content:center;

    flex-wrap:wrap;

    gap:16px;

    margin-bottom:70px;
}

.filter-btn{

    padding:
        16px 28px;

    border:none;

    border-radius:999px;

    background:
        rgba(255,255,255,.04);

    border:
        1px solid rgba(255,255,255,.06);

    color:
        var(--text-secondary);

    font-weight:700;

    cursor:pointer;

    backdrop-filter:
        blur(16px);

    transition:
        all .3s ease;
}

.filter-btn.active{

    background:
        var(--accent);

    color:
        var(--bg-primary);
}

.filter-btn:hover{

    background:
        rgba(255,255,255,.08);

    color:
        var(--text-primary);
}

/*
|--------------------------------------------------------------------------
| CARD
|--------------------------------------------------------------------------
*/

.menu-card{

    position:relative;

    height:100%;

    overflow:hidden;

    border-radius:34px;

    transition:
        all .35s ease;
}

.menu-card:hover{

    transform:
        translateY(-10px);
}

/*
|--------------------------------------------------------------------------
| IMAGE
|--------------------------------------------------------------------------
*/

.menu-image-wrapper{

    position:relative;

    height:280px;

    overflow:hidden;
}

.menu-image{

    width:100%;
    height:100%;

    object-fit:cover;

    transition:
        transform .6s ease;
}

.menu-card:hover .menu-image{

    transform:scale(1.08);
}

.menu-overlay{

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,.75),
            rgba(0,0,0,.1)
        );
}

/*
|--------------------------------------------------------------------------
| BADGE
|--------------------------------------------------------------------------
*/

.menu-badge{

    position:absolute;

    top:22px;
    left:22px;

    padding:
        10px 18px;

    border-radius:999px;

    background:
        rgba(0,0,0,.45);

    backdrop-filter:
        blur(16px);

    border:
        1px solid rgba(255,255,255,.08);

    color:
        var(--text-primary);

    font-size:12px;

    font-weight:700;

    letter-spacing:1px;
}

/*
|--------------------------------------------------------------------------
| CONTENT
|--------------------------------------------------------------------------
*/

.menu-content{

    padding:34px;
}

.menu-name{

    font-size:30px;

    font-weight:900;

    line-height:1.2;

    margin-bottom:16px;
}

.menu-text{

    color:
        var(--text-secondary);

    line-height:1.9;

    margin-bottom:34px;
}

/*
|--------------------------------------------------------------------------
| FOOTER
|--------------------------------------------------------------------------
*/

.menu-footer{

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;
}

.price-label{

    display:block;

    color:
        var(--text-muted);

    font-size:13px;

    margin-bottom:6px;
}

.menu-price{

    font-size:28px;

    font-weight:900;

    color:
        var(--accent);
}

/*
|--------------------------------------------------------------------------
| BUTTON
|--------------------------------------------------------------------------
*/

.btn-menu-modern{

    display:inline-flex;

    align-items:center;

    gap:12px;

    padding:
        16px 24px;

    border-radius:18px;

    background:
        rgba(255,255,255,.05);

    border:
        1px solid var(--border-gold);

    color:
        var(--text-primary);

    text-decoration:none;

    font-weight:700;

    transition:
        all .3s ease;
}

.btn-menu-modern:hover{

    background:
        rgba(255,255,255,.08);

    color:
        var(--text-primary);

    transform:
        translateY(-3px);
}

/*
|--------------------------------------------------------------------------
| EMPTY
|--------------------------------------------------------------------------
*/

.empty-menu{

    padding:100px 20px;

    border-radius:36px;

    text-align:center;
}

.empty-icon{

    width:100px;
    height:100px;

    margin:
        auto auto 28px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:
        rgba(226,201,151,.08);

    color:
        var(--accent);

    font-size:42px;
}

.empty-menu h3{

    font-size:40px;

    font-weight:900;

    margin-bottom:14px;
}

.empty-menu p{

    color:
        var(--text-secondary);
}

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media(max-width:991px){

    .menu-title{

        font-size:58px;
    }

    .menu-content{

        padding:28px;
    }

    .menu-name{

        font-size:24px;
    }

    .menu-footer{

        flex-direction:column;

        align-items:flex-start;
    }

    .btn-menu-modern{

        width:100%;

        justify-content:center;
    }
}

@media(max-width:768px){

    .menu-page{

        padding:
            140px 0
            100px;
    }

    .menu-header{

        margin-bottom:60px;
    }

    .menu-title{

        font-size:46px;
    }

    .menu-description{

        font-size:16px;
    }

    .menu-image-wrapper{

        height:240px;
    }

    .menu-filter{

        gap:12px;
    }

    .filter-btn{

        width:100%;
    }
}

</style>

</body>

</html>