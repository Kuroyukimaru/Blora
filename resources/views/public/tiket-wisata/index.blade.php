<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Semua Tiket Wahana | Noyo Gimbal
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

@php

    $currentPage =
        request('page', 1);

    $perPage = 6;

    $totalData =
        $tiketWahanas->count();

    $totalPages =
        ceil($totalData / $perPage);

    $paginatedData =
        $tiketWahanas->forPage(
            $currentPage,
            $perPage
        );

@endphp

<!-- PAGE -->
<section class="wahana-page">

    <!-- BG -->
    <div class="wahana-glow glow-1"></div>

    <div class="wahana-glow glow-2"></div>

    <!-- CONTAINER -->
    <div class="container-custom position-relative"
         style="z-index:5;">

        <!-- HEADER -->
        <div class="wahana-header text-center">

            <span class="wahana-subtitle">

                TIKET WAHANA

            </span>

            <h1 class="wahana-title text-gradient">

                Semua Tiket Wahana

            </h1>

            <p class="wahana-description">

                Nikmati berbagai wahana
                seru dan pengalaman terbaik
                bersama keluarga di
                Noyo Gimbal.

            </p>

        </div>

        <!-- GRID -->
        <div class="row g-4">

            @forelse($paginatedData as $tiket)

                <!-- ITEM -->
                <div class="col-lg-4 col-md-6">

                    <!-- CARD -->
                    <article class="wahana-card glass-effect">

                        <!-- TOP -->
                        <div class="wahana-top">

                            <!-- ICON -->
                            <div class="wahana-icon">

                                <i class="fas fa-ticket"></i>

                            </div>

                            <!-- BADGE -->
                            <span class="wahana-badge">

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

                                {{ $tiket->ketentuan }}

                            </p>

                            <!-- FOOTER -->
                            <div class="wahana-footer">

                                <!-- PRICE -->
                                <div>

                                    <span class="price-label">

                                        Harga Tiket

                                    </span>

                                    <h4 class="wahana-price">

                                        Rp {{ number_format($tiket->harga,0,',','.') }}

                                    </h4>

                                </div>

                                <!-- BUTTON -->
                                <a href="#"
                                   class="btn-wahana-modern">

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

        <!-- PAGINATION -->
        @if($totalPages > 1)

            <div class="custom-pagination">

                <!-- PREV -->
                @if($currentPage > 1)

                    <a href="?page={{ $currentPage - 1 }}"
                       class="pagination-btn">

                        <i class="fas fa-chevron-left"></i>

                    </a>

                @endif

                <!-- NUMBER -->
                @for($i = 1; $i <= $totalPages; $i++)

                    <a href="?page={{ $i }}"
                       class="pagination-btn {{ $currentPage == $i ? 'active' : '' }}">

                        {{ $i }}

                    </a>

                @endfor

                <!-- NEXT -->
                @if($currentPage < $totalPages)

                    <a href="?page={{ $currentPage + 1 }}"
                       class="pagination-btn">

                        <i class="fas fa-chevron-right"></i>

                    </a>

                @endif

            </div>

        @endif

    </div>

</section>

<!-- FOOTER -->
@include('public.partials.footer')

<style>

/*
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
*/

.wahana-page{

    position:relative;

    min-height:100vh;

    padding:
        180px 0
        120px;

    background:#000000;

    overflow:hidden;
}

/*
|--------------------------------------------------------------------------
| BACKGROUND
|--------------------------------------------------------------------------
*/

.wahana-glow{

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

    background:#000000;
}

.glow-2{

    bottom:-250px;
    right:-200px;

    background:#000000;
}

/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

.wahana-header{

    max-width:1000px;

    margin:
        0 auto
        90px;
}

.wahana-subtitle{

    display:inline-block;

    margin-bottom:20px;

    color:var(--accent);

    font-size:13px;

    font-weight:700;

    letter-spacing:4px;
}

.wahana-title{

    font-size:
        clamp(60px,8vw,120px);

    font-weight:900;

    line-height:1.1;

    margin-bottom:26px;
}

.wahana-description{

    color:var(--text-secondary);

    font-size:20px;

    line-height:1.9;

    max-width:850px;

    margin:auto;
}

/*
|--------------------------------------------------------------------------
| CARD
|--------------------------------------------------------------------------
*/

.wahana-card{

    position:relative;

    min-height:520px;

    height:100%;

    display:flex;

    flex-direction:column;

    overflow:hidden;

    border-radius:34px;

    padding:34px;

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

.wahana-badge{

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

    min-height:100px;

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
| PAGINATION
|--------------------------------------------------------------------------
*/

.custom-pagination{

    margin-top:90px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:14px;

    flex-wrap:wrap;
}

.pagination-btn{

    width:58px;
    height:58px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:20px;

    background:
        rgba(255,255,255,.04);

    border:
        1px solid rgba(255,255,255,.06);

    color:
        var(--text-primary);

    text-decoration:none;

    font-weight:800;

    transition:
        all .3s ease;
}

.pagination-btn:hover{

    transform:
        translateY(-4px);

    background:
        rgba(255,255,255,.08);

    color:
        var(--text-primary);
}

.pagination-btn.active{

    background:
        linear-gradient(
            135deg,
            var(--accent),
            var(--accent-hover)
        );

    color:
        var(--bg-primary);

    border:none;
}

/*
|--------------------------------------------------------------------------
| EMPTY
|--------------------------------------------------------------------------
*/

.empty-wahana{

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

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/

@media(max-width:991px){

    .wahana-title{

        font-size:68px;
    }

    .wahana-card{

        min-height:auto;

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

    .wahana-page{

        padding:
            150px 0
            100px;
    }

    .wahana-header{

        margin-bottom:60px;
    }

    .wahana-title{

        font-size:52px;
    }

    .wahana-description{

        font-size:16px;
    }

    .pagination-btn{

        width:52px;
        height:52px;
    }
}

</style>

</body>

</html>