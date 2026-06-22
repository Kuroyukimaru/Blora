<!-- PAKET MAKAN -->
<section id="paket-makan"
         class="section-padding position-relative overflow-hidden">

    <!-- BACKGROUND BLUR -->
    <div class="paket-bg-blur paket-bg-1"></div>

    <div class="paket-bg-blur paket-bg-2"></div>

    <!-- CONTAINER -->
    <div class="container-custom position-relative"
         style="z-index:5;">

        <!-- HEADER -->
        <div class="paket-header text-center">

            <!-- SUBTITLE -->
            <span class="paket-subtitle">

                FOOD PACKAGE

            </span>

            <!-- TITLE -->
            <h2 class="paket-title text-gradient">

                Paket
                Makan

            </h2>

            <!-- DESCRIPTION -->
            <p class="paket-description">

                Nikmati berbagai pilihan
                paket makan terbaik khas
                Noyo Gimbal dengan suasana
                tradisional dan modern.

            </p>

        </div>

        <!-- GRID -->
        <div class="row g-4">

            @php

                $pakets = $menus
                    ->where('kategori', 'Paket')
                    ->where('status', 'Tersedia');

            @endphp

            @forelse($pakets as $paket)

                <!-- CARD -->
                <div class="col-lg-4 col-md-6">

                    <article class="paket-card glass-effect">

                        <!-- IMAGE -->
                        <div class="paket-image-wrapper">

                            @if($paket->gambar)

                                <img src="{{ asset('storage/' . $paket->gambar) }}"
                                     alt="{{ $paket->nama_menu }}"
                                     class="paket-image"

                                     onerror="
                                        this.onerror=null;
                                        this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop';
                                     ">

                            @else

                                <!-- FALLBACK -->
                                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop"
                                     alt="{{ $paket->nama_menu }}"
                                     class="paket-image">

                            @endif

                            <!-- OVERLAY -->
                            <div class="paket-overlay"></div>

                            <!-- BADGE -->
                            <span class="paket-floating-badge">

                                Paket Menu

                            </span>

                        </div>

                        <!-- CONTENT -->
                        <div class="paket-content">

                            <!-- TITLE -->
                            <h3 class="paket-name">

                                {{ $paket->nama_menu }}

                            </h3>

                            <!-- DESCRIPTION -->
                            <p class="paket-text">

                                {{ Str::limit($paket->deskripsi, 120) }}

                            </p>

                            <!-- FOOTER -->
                            <div class="paket-footer">

                                <!-- PRICE -->
                                <div>

                                    <span class="price-label">

                                        Harga

                                    </span>

                                    <h4 class="paket-price">

                                        Rp {{ number_format($paket->harga, 0, ',', '.') }}

                                    </h4>

                                </div>

                                <!-- BUTTON -->
                                <a href="#"
                                   class="btn-paket-modern">

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

                    <div class="empty-paket glass-effect">

                        <div class="empty-icon">

                            <i class="fas fa-utensils"></i>

                        </div>

                        <h3>

                            Belum Ada Paket

                        </h3>

                        <p>

                            Paket menu belum tersedia.

                        </p>

                    </div>

                </div>

            @endforelse

        </div>

        <!-- BUTTON -->
        <div class="text-center mt-5 pt-4">

            <a href="/menu"
               class="btn-menu-lainnya">

                <span>

                    Menu Lainnya

                </span>

                <i class="fas fa-arrow-right"></i>

            </a>

        </div>

    </div>

</section>

<style>

/*
|--------------------------------------------------------------------------
| BACKGROUND BLUR
|--------------------------------------------------------------------------
*/

.paket-bg-blur{

    position:absolute;

    width:500px;
    height:500px;

    border-radius:50%;

    filter:blur(120px);

    opacity:.06;

    z-index:1;
}

.paket-bg-1{

    top:-200px;
    left:-150px;

    background:
        #000000;
}

.paket-bg-2{

    bottom:-250px;
    right:-150px;

    background:
        #000000;
}

/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

.paket-header{

    max-width:760px;

    margin:
        0 auto
        90px;
}

.paket-subtitle{

    display:inline-block;

    color:
        var(--accent);

    font-size:13px;

    font-weight:700;

    letter-spacing:4px;

    margin-bottom:22px;
}

.paket-title{

    font-size:
        clamp(48px,6vw,88px);

    font-weight:900;

    line-height:1;

    margin-bottom:24px;
}

.paket-description{

    color:
        var(--text-secondary);

    font-size:18px;

    line-height:1.9;
}

/*
|--------------------------------------------------------------------------
| CARD
|--------------------------------------------------------------------------
*/

.paket-card{

    position:relative;

    height:100%;

    overflow:hidden;

    border-radius:34px;

    transition:
        all .35s ease;
}

.paket-card:hover{

    transform:
        translateY(-10px);
}

/*
|--------------------------------------------------------------------------
| IMAGE
|--------------------------------------------------------------------------
*/

.paket-image-wrapper{

    position:relative;

    height:280px;

    overflow:hidden;
}

.paket-image{

    width:100%;
    height:100%;

    object-fit:cover;

    transition:
        transform .6s ease;
}

.paket-card:hover .paket-image{

    transform:scale(1.08);
}

.paket-overlay{

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
| FLOATING BADGE
|--------------------------------------------------------------------------
*/

.paket-floating-badge{

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

.paket-content{

    padding:34px;
}

.paket-name{

    font-size:30px;

    font-weight:900;

    line-height:1.2;

    margin-bottom:16px;
}

.paket-text{

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

.paket-footer{

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

.paket-price{

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

.btn-paket-modern{

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

.btn-paket-modern:hover{

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

.empty-paket{

    padding:90px 20px;

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

.empty-paket h3{

    font-size:38px;

    font-weight:900;

    margin-bottom:14px;
}

.empty-paket p{

    color:
        var(--text-secondary);
}

/*
|--------------------------------------------------------------------------
| BUTTON MENU
|--------------------------------------------------------------------------
*/

.btn-menu-lainnya{

    display:inline-flex;

    align-items:center;

    gap:14px;

    padding:
        20px 38px;

    border-radius:999px;

    background:
        linear-gradient(
            135deg,
            var(--accent),
            var(--accent-hover)
        );

    color:
        var(--bg-primary);

    text-decoration:none;

    font-weight:800;

    transition:
        all .3s ease;
}

.btn-menu-lainnya:hover{

    transform:
        translateY(-4px);

    color:
        var(--bg-primary);
}

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media(max-width:991px){

    .paket-title{

        font-size:58px;
    }

    .paket-content{

        padding:28px;
    }

    .paket-name{

        font-size:24px;
    }

    .paket-footer{

        flex-direction:column;

        align-items:flex-start;
    }

    .btn-paket-modern{

        width:100%;

        justify-content:center;
    }
}

@media(max-width:768px){

    .paket-header{

        margin-bottom:60px;
    }

    .paket-title{

        font-size:46px;
    }

    .paket-description{

        font-size:16px;
    }

    .paket-image-wrapper{

        height:240px;
    }
}

</style>