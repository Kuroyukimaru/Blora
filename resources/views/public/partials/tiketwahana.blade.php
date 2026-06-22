<!-- TIKET WAHANA -->
<section id="tiket-wahana"
         class="section-padding position-relative overflow-hidden">

    <!-- BACKGROUND BLUR -->
    <div class="wahana-bg-blur wahana-bg-1"></div>

    <div class="wahana-bg-blur wahana-bg-2"></div>

    <!-- CONTAINER -->
    <div class="container-custom position-relative"
         style="z-index:5;">

        <!-- HEADER -->
        <div class="wahana-header text-center">

            <!-- SUBTITLE -->
            <span class="wahana-subtitle">

                TIKET WAHANA

            </span>

            <!-- TITLE -->
            <h2 class="wahana-title text-gradient">

                Tiket
                Wahana

            </h2>

            <!-- DESCRIPTION -->
            <p class="wahana-description">

                Nikmati berbagai pilihan
                wahana seru dengan harga
                terjangkau dan pengalaman
                terbaik bersama Noyo Gimbal.

            </p>

        </div>

        <!-- GRID -->
        <div class="row g-4">

            @forelse($tiketWahanas->take(3) as $tiket)

                <!-- CARD -->
                <div class="col-lg-4 col-md-6">

                    <article class="wahana-card glass-effect">

                        <!-- TOP -->
                        <div class="wahana-top">

                            <!-- ICON -->
                            <div class="wahana-icon">

                                <i class="fas fa-ticket"></i>

                            </div>

                            <!-- BADGE -->
                            <span class="wahana-floating-badge">

                                Tiket Wahana

                            </span>

                        </div>

                        <!-- CONTENT -->
                        <div class="wahana-content">

                            <!-- TITLE -->
                            <h3 class="wahana-name">

                                {{ $tiket->wahana }}

                            </h3>

                            <!-- DESCRIPTION -->
                            <p class="wahana-text">

                                {{ Str::limit($tiket->ketentuan, 120) }}

                            </p>

                            <!-- FOOTER -->
                            <div class="wahana-footer">

                                <!-- PRICE -->
                                <div>

                                    <span class="price-label">

                                        Harga Tiket

                                    </span>

                                    <h4 class="wahana-price">

                                        Rp {{ number_format($tiket->harga, 0, ',', '.') }}

                                    </h4>

                                </div>

                                <!-- BUTTON -->
                                <a href="/tiket-wahana"
                                   class="btn-wahana-modern">

                                    <span>

                                        Detail

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

                    <div class="empty-wahana glass-effect">

                        <div class="empty-icon">

                            <i class="fas fa-ticket"></i>

                        </div>

                        <h3>

                            Belum Ada Tiket

                        </h3>

                        <p>

                            Tiket wahana belum tersedia.

                        </p>

                    </div>

                </div>

            @endforelse

        </div>

        <!-- BUTTON MORE -->
@if($tiketWahanas->count() > 3)

    <div class="wahana-more-wrapper">

        <a href="/tiket-wahana"
           class="btn-more-wahana">

            <span>

                Lihat Semua Tiket Wahana

            </span>

            <i class="fas fa-arrow-right"></i>

        </a>

    </div>

@endif

    </div>

</section>

<style>

/*
|--------------------------------------------------------------------------
| BACKGROUND BLUR
|--------------------------------------------------------------------------
*/

.wahana-bg-blur{

    position:absolute;

    width:500px;
    height:500px;

    border-radius:50%;

    filter:blur(120px);

    opacity:.06;

    z-index:1;
}

.wahana-bg-1{

    top:-200px;
    left:-150px;

    background:#000000;
}

.wahana-bg-2{

    bottom:-250px;
    right:-150px;

    background:#000000;
}

/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

.wahana-header{

    max-width:760px;

    margin:
        0 auto
        90px;
}

.wahana-subtitle{

    display:inline-block;

    color:var(--accent);

    font-size:13px;

    font-weight:700;

    letter-spacing:4px;

    margin-bottom:22px;
}

.wahana-title{

    font-size:
        clamp(48px,6vw,88px);

    font-weight:900;

    line-height:1;

    margin-bottom:24px;
}

.wahana-description{

    color:var(--text-secondary);

    font-size:18px;

    line-height:1.9;
}

/*
|--------------------------------------------------------------------------
| CARD
|--------------------------------------------------------------------------
*/

.wahana-card{

    position:relative;

    height:100%;

    min-height:520px;

    overflow:hidden;

    border-radius:34px;

    padding:34px;

    display:flex;

    flex-direction:column;

    transition:
        all .35s ease;
}

.wahana-card:hover{

    transform:
        translateY(-10px);
}

/*
|--------------------------------------------------------------------------
| TOP
|--------------------------------------------------------------------------
*/

.wahana-top{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:34px;
}

/*
|--------------------------------------------------------------------------
| ICON
|--------------------------------------------------------------------------
*/

.wahana-icon{

    width:90px;
    height:90px;

    border-radius:28px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:
        rgba(226,201,151,.08);

    border:
        1px solid rgba(255,255,255,.06);

    color:
        var(--accent);

    font-size:36px;
}

/*
|--------------------------------------------------------------------------
| BADGE
|--------------------------------------------------------------------------
*/

.wahana-floating-badge{

    padding:
        10px 18px;

    border-radius:999px;

    background:
        rgba(255,255,255,.04);

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

.wahana-content{

    height:100%;

    display:flex;

    flex-direction:column;
}

.wahana-name{

    font-size:34px;

    font-weight:900;

    line-height:1.2;

    margin-bottom:18px;
}

.wahana-text{

    color:
        var(--text-secondary);

    line-height:1.9;

    min-height:90px;

    margin-bottom:auto;
}

/*
|--------------------------------------------------------------------------
| FOOTER
|--------------------------------------------------------------------------
*/

.wahana-footer{

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;

    margin-top:40px;
}

.price-label{

    display:block;

    color:
        var(--text-muted);

    font-size:13px;

    margin-bottom:6px;
}

.wahana-price{

    font-size:30px;

    font-weight:900;

    color:
        var(--accent);
}

/*
|--------------------------------------------------------------------------
| BUTTON
|--------------------------------------------------------------------------
*/

.btn-wahana-modern{

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

.btn-wahana-modern:hover{

    background:
        rgba(255,255,255,.08);

    color:
        var(--text-primary);

    transform:
        translateY(-3px);
}

/*
|--------------------------------------------------------------------------
| MORE BUTTON
|--------------------------------------------------------------------------
*/

.wahana-more-wrapper{

    margin-top:70px;

    display:flex;

    justify-content:center;
}

.btn-more-wahana{

    display:inline-flex;

    align-items:center;

    gap:14px;

    padding:
        18px 34px;

    border-radius:22px;

    background:
        linear-gradient(
            135deg,
            var(--accent),
            var(--accent-hover)
        );

    color:
        var(--bg-primary);

    text-decoration:none;

    font-size:15px;

    font-weight:800;

    transition:
        all .3s ease;

    box-shadow:
        0 15px 40px rgba(226,201,151,.12);
}

.btn-more-wahana:hover{

    transform:
        translateY(-4px);

    color:
        var(--bg-primary);

    box-shadow:
        0 20px 50px rgba(226,201,151,.18);
}

/*
|--------------------------------------------------------------------------
| EMPTY
|--------------------------------------------------------------------------
*/

.empty-wahana{

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

.empty-wahana h3{

    font-size:38px;

    font-weight:900;

    margin-bottom:14px;
}

.empty-wahana p{

    color:
        var(--text-secondary);
}

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media(max-width:991px){

    .wahana-title{

        font-size:58px;
    }

    .wahana-card{

        padding:28px;
    }

    .wahana-name{

        font-size:28px;
    }

    .wahana-footer{

        flex-direction:column;

        align-items:flex-start;
    }

    .btn-wahana-modern{

        width:100%;

        justify-content:center;
    }
}

@media(max-width:768px){

    .wahana-header{

        margin-bottom:60px;
    }

    .wahana-title{

        font-size:46px;
    }

    .wahana-description{

        font-size:16px;
    }

    .wahana-icon{

        width:76px;
        height:76px;

        font-size:30px;
    }
}

</style>