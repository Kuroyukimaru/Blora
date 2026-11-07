@php
    use Illuminate\Support\Facades\Route;

    $items = $items ?? collect();
    $search = request('search', '');

    $stockUpdateRouteExists = Route::has('kasir.oleholeh.stock.update');
    $orderRouteExists = Route::has('kasir.oleholeh.orders');

    $kasir = auth('admin')->user();
    $namaKasir = $kasir?->nama ?? 'Kasir';
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Stok Oleh-Oleh - Noyo Gimbal</title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

:root{
    --bg-primary:#0a0a0a;
    --bg-secondary:#151515;
    --bg-soft:#1a1a1a;
    --bg-card:#121212;
    --text-primary:#f8f4ed;
    --text-secondary:#d4c9b5;
    --text-muted:#a89988;
    --text-dim:#7a6f62;
    --accent:#e2c997;
    --accent-hover:#d4b384;
    --accent-dark:#b89a6e;
    --border-soft:rgba(255,255,255,.06);
    --border-gold:rgba(226,201,151,.15);
    --white:#ffffff;
    --black:#000000;
    --success:#9bc7a8;
    --warning:#e5c477;
    --danger:#e0a09a;
    --shadow-soft:0 20px 60px rgba(0,0,0,.4);
    --shadow-hover:0 25px 70px rgba(0,0,0,.5);
    --radius-lg:28px;
    --radius-md:16px;
    --radius-full:999px;
    --transition:.25s cubic-bezier(.4,0,.2,1);
}

*{margin:0;padding:0;box-sizing:border-box}

html{scroll-behavior:smooth}

body{
    margin:0;
    min-width:320px;
    overflow-x:hidden;
    background:var(--bg-primary);
    color:var(--text-primary);
    font-family:'DM Sans',Arial,sans-serif;
    font-size:16px;
    line-height:1.65;
    -webkit-font-smoothing:antialiased;
}

button,input{font:inherit}

.ko-main{
    min-height:100vh;
    margin-left:252px;
    background:
        radial-gradient(circle at 85% 0%,rgba(226,201,151,.055),transparent 28rem),
        var(--bg-primary);
}

.ko-topbar{
    position:sticky;
    top:0;
    z-index:900;
    min-height:76px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    padding:12px 40px;
    background:rgba(10,10,10,.88);
    border-bottom:1px solid var(--border-soft);
    backdrop-filter:blur(20px);
    -webkit-backdrop-filter:blur(20px);
}

.ko-topbar-left,.ko-user,.ko-breadcrumb{
    display:flex;
    align-items:center;
}

.ko-topbar-left{gap:16px}
.ko-breadcrumb{gap:10px;color:var(--text-dim);font-size:.9rem;font-weight:500}
.ko-breadcrumb i{font-size:.65rem;color:var(--accent-dark)}
.ko-breadcrumb .current{color:var(--text-secondary);font-weight:700}

.ko-mobile-button{
    display:none;
    width:44px;
    height:44px;
    align-items:center;
    justify-content:center;
    color:var(--text-primary);
    background:var(--bg-soft);
    border:1px solid var(--border-gold);
    border-radius:12px;
    cursor:pointer;
}

.ko-user{gap:12px}
.ko-user-text{text-align:right}
.ko-user-text strong{
    display:block;
    color:var(--text-primary);
    font-size:.9rem;
    font-weight:700;
}
.ko-user-text span{
    display:block;
    margin-top:2px;
    color:var(--text-muted);
    font-size:.78rem;
}
.ko-avatar{
    width:44px;
    height:44px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:var(--bg-primary);
    background:linear-gradient(135deg,var(--accent),var(--accent-dark));
    border-radius:14px;
    font-size:.95rem;
    font-weight:800;
    box-shadow:0 8px 24px rgba(226,201,151,.12);
}

.ko-content{
    width:min(calc(100% - 80px),1400px);
    margin:0 auto;
    padding:42px 0 60px;
}

.ko-page-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:28px;
    margin-bottom:30px;
}

.ko-eyebrow{
    display:block;
    margin-bottom:8px;
    color:var(--accent);
    font-size:.78rem;
    line-height:1.2;
    font-weight:700;
    letter-spacing:2px;
    text-transform:uppercase;
}

.ko-page-header h1{
    margin:0;
    color:var(--text-primary);
    font-family:'Playfair Display',Georgia,serif;
    font-size:clamp(2rem,3vw,3rem);
    line-height:1.15;
    font-weight:700;
    letter-spacing:-.02em;
}

.ko-page-header p{
    max-width:720px;
    margin:10px 0 0;
    color:var(--text-muted);
    font-size:1rem;
    line-height:1.7;
}

.ko-order-link{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    min-height:48px;
    padding:0 20px;
    color:var(--bg-primary);
    background:linear-gradient(135deg,var(--accent),var(--accent-hover));
    border:1px solid transparent;
    border-radius:var(--radius-full);
    font-size:.92rem;
    font-weight:700;
    text-decoration:none;
    white-space:nowrap;
    transition:all var(--transition);
}

.ko-order-link:hover{
    color:var(--bg-primary);
    background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));
    transform:translateY(-2px);
    box-shadow:var(--shadow-soft);
}

.ko-summary{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:18px;
    margin-bottom:22px;
}

.ko-summary-card{
    display:flex;
    align-items:center;
    gap:16px;
    min-height:104px;
    padding:20px;
    background:linear-gradient(145deg,rgba(255,255,255,.045),rgba(255,255,255,.02));
    border:1px solid var(--border-gold);
    border-radius:var(--radius-md);
    box-shadow:var(--shadow-soft);
}

.ko-summary-icon{
    width:50px;
    height:50px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
    color:var(--bg-primary);
    background:linear-gradient(135deg,var(--accent),var(--accent-dark));
    border-radius:14px;
    font-size:1.15rem;
}

.ko-summary-label{
    display:block;
    margin-bottom:3px;
    color:var(--text-muted);
    font-size:.82rem;
    font-weight:500;
}

.ko-summary-value{
    display:block;
    color:var(--text-primary);
    font-size:1.35rem;
    font-weight:700;
}

.ko-panel{
    overflow:hidden;
    background:linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.018));
    border:1px solid var(--border-gold);
    border-radius:var(--radius-lg);
    box-shadow:var(--shadow-soft);
}

.ko-toolbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:18px;
    padding:20px;
    border-bottom:1px solid var(--border-soft);
}

.ko-search{
    position:relative;
    width:min(100%,560px);
}

.ko-search i{
    position:absolute;
    left:16px;
    top:50%;
    transform:translateY(-50%);
    color:var(--text-muted);
    font-size:.95rem;
    pointer-events:none;
}

.ko-search input{
    width:100%;
    height:48px;
    padding:0 86px 0 44px;
    color:var(--text-primary);
    background:var(--bg-soft);
    border:1px solid var(--border-soft);
    border-radius:12px;
    outline:none;
    font-size:.92rem;
    transition:all var(--transition);
}

.ko-search input::placeholder{color:var(--text-dim)}

.ko-search input:focus{
    border-color:rgba(226,201,151,.55);
    box-shadow:0 0 0 4px rgba(226,201,151,.08);
}

.ko-search button{
    position:absolute;
    right:5px;
    top:5px;
    height:38px;
    padding:0 15px;
    color:var(--bg-primary);
    background:var(--accent);
    border:0;
    border-radius:9px;
    font-size:.82rem;
    font-weight:700;
    cursor:pointer;
    transition:all var(--transition);
}

.ko-search button:hover{background:var(--accent-hover)}

.ko-product-count{
    color:var(--text-muted);
    font-size:.88rem;
    font-weight:500;
    white-space:nowrap;
}

.ko-table-wrapper{
    width:100%;
    overflow-x:auto;
    scrollbar-width:thin;
    scrollbar-color:var(--accent-dark) var(--bg-secondary);
}

.ko-table{
    width:100%;
    min-width:980px;
    border-collapse:collapse;
}

.ko-table th{
    padding:16px 20px;
    color:var(--text-muted);
    background:rgba(255,255,255,.025);
    border-bottom:1px solid var(--border-soft);
    font-size:.76rem;
    line-height:1.3;
    font-weight:700;
    letter-spacing:.9px;
    text-align:left;
    text-transform:uppercase;
    white-space:nowrap;
}

.ko-table td{
    padding:18px 20px;
    color:var(--text-secondary);
    border-bottom:1px solid var(--border-soft);
    font-size:.9rem;
    line-height:1.5;
    vertical-align:middle;
}

.ko-table tbody tr{transition:background var(--transition)}
.ko-table tbody tr:hover{background:rgba(226,201,151,.035)}
.ko-table tbody tr:last-child td{border-bottom:0}

.ko-product{
    display:flex;
    align-items:center;
    gap:14px;
    min-width:240px;
}

.ko-product-image{
    width:58px;
    height:58px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
    overflow:hidden;
    color:var(--text-dim);
    background:var(--bg-soft);
    border:1px solid var(--border-gold);
    border-radius:14px;
    font-size:1.15rem;
}

.ko-product-image img{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
    object-position:center;
}

.ko-product-name{
    display:block;
    color:var(--text-primary);
    font-size:.94rem;
    font-weight:700;
}

.ko-product-type{
    display:block;
    margin-top:4px;
    color:var(--text-muted);
    font-size:.8rem;
}

.ko-price{
    color:var(--text-primary);
    font-size:.94rem;
    font-weight:700;
    white-space:nowrap;
}

.ko-stock-badge{
    display:inline-flex;
    align-items:center;
    gap:7px;
    padding:7px 11px;
    border-radius:var(--radius-full);
    font-size:.82rem;
    font-weight:700;
    white-space:nowrap;
}

.ko-stock-badge.good{
    color:var(--success);
    background:rgba(155,199,168,.1);
    border:1px solid rgba(155,199,168,.12);
}

.ko-stock-badge.low{
    color:var(--warning);
    background:rgba(229,196,119,.1);
    border:1px solid rgba(229,196,119,.12);
}

.ko-stock-badge.empty{
    color:var(--danger);
    background:rgba(224,160,154,.1);
    border:1px solid rgba(224,160,154,.12);
}

.ko-status{
    display:inline-flex;
    align-items:center;
    padding:7px 11px;
    border-radius:var(--radius-full);
    font-size:.8rem;
    font-weight:700;
    white-space:nowrap;
}

.ko-status.available{
    color:var(--success);
    background:rgba(155,199,168,.1);
    border:1px solid rgba(155,199,168,.12);
}

.ko-status.unavailable{
    color:var(--danger);
    background:rgba(224,160,154,.1);
    border:1px solid rgba(224,160,154,.12);
}

.ko-stock-form{
    display:flex;
    align-items:center;
    gap:8px;
}

.ko-stock-input{
    width:92px;
    height:42px;
    padding:0 10px;
    color:var(--text-primary);
    background:var(--bg-soft);
    border:1px solid var(--border-soft);
    border-radius:10px;
    outline:none;
    font-size:.9rem;
    font-weight:600;
    text-align:center;
    transition:all var(--transition);
}

.ko-stock-input:focus{
    border-color:rgba(226,201,151,.55);
    box-shadow:0 0 0 4px rgba(226,201,151,.08);
}

.ko-stock-input::-webkit-inner-spin-button,
.ko-stock-input::-webkit-outer-spin-button{opacity:1}

.ko-save-button{
    width:42px;
    height:42px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
    color:var(--bg-primary);
    background:var(--accent);
    border:0;
    border-radius:10px;
    cursor:pointer;
    transition:all var(--transition);
}

.ko-save-button:hover{
    background:var(--accent-hover);
    transform:translateY(-1px);
    box-shadow:0 8px 20px rgba(226,201,151,.12);
}

.ko-save-button:disabled{
    opacity:.55;
    cursor:not-allowed;
    transform:none;
}

.ko-route-warning{
    color:var(--danger);
    font-size:.78rem;
}

.ko-empty{
    display:flex;
    align-items:center;
    flex-direction:column;
    padding:72px 24px;
    text-align:center;
}

.ko-empty-icon{
    width:64px;
    height:64px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:16px;
    color:var(--accent);
    background:rgba(226,201,151,.07);
    border:1px solid var(--border-gold);
    border-radius:18px;
    font-size:1.4rem;
}

.ko-empty h3{
    margin:0 0 7px;
    color:var(--text-primary);
    font-size:1.1rem;
    font-weight:700;
}

.ko-empty p{
    max-width:460px;
    margin:0;
    color:var(--text-muted);
    font-size:.9rem;
    line-height:1.7;
}

.ko-pagination{
    display:flex;
    justify-content:flex-end;
    padding:18px 20px;
    border-top:1px solid var(--border-soft);
}

.ko-pagination nav span,
.ko-pagination nav a{
    color:var(--text-secondary)!important;
}

.ko-main,
.ko-content,
.ko-panel,
.ko-table-wrapper{min-width:0}

.ko-product>div:last-child{min-width:0}

.ko-product-name,
.ko-product-type{overflow-wrap:anywhere}

.ko-stock-form{flex-wrap:nowrap}

.ko-stock-input{max-width:100%}

.ko-mobile-button:focus-visible,
.ko-order-link:focus-visible,
.ko-search button:focus-visible,
.ko-search input:focus-visible,
.ko-stock-input:focus-visible,
.ko-save-button:focus-visible{
    outline:3px solid rgba(226,201,151,.35);
    outline-offset:2px;
}

.ko-save-button.is-saving{pointer-events:none}

@media (max-width:1200px){
    .ko-main{margin-left:230px}
    .ko-topbar{padding-inline:30px}
    .ko-content{width:min(calc(100% - 56px),1200px)}
    .ko-summary{gap:14px}
    .ko-summary-card{padding:18px}
}

@media (max-width:992px){
    .ko-main{margin-left:0}
    .ko-mobile-button{display:flex}
    .ko-topbar{padding:12px 24px}
    .ko-content{width:calc(100% - 48px);padding-top:34px}
    .ko-page-header{align-items:flex-start}
    .ko-page-header h1{font-size:2.35rem}
    .ko-table{min-width:940px}
}

@media (max-width:768px){
    body{font-size:16px}
    .ko-topbar{min-height:70px;padding:10px 18px}
    .ko-content{width:calc(100% - 32px);padding:28px 0 44px}
    .ko-breadcrumb{font-size:.82rem}
    .ko-user-text{display:none}
    .ko-avatar{width:42px;height:42px}
    .ko-page-header{flex-direction:column;gap:18px;margin-bottom:24px}
    .ko-page-header h1{font-size:2rem}
    .ko-page-header p{font-size:.94rem}
    .ko-order-link{width:100%;min-height:50px}
    .ko-summary{grid-template-columns:1fr;gap:12px}
    .ko-summary-card{min-height:90px}
    .ko-toolbar{align-items:stretch;flex-direction:column;padding:17px}
    .ko-search{width:100%}
    .ko-product-count{align-self:flex-start}
    .ko-table th{padding:14px 16px;font-size:.72rem}
    .ko-table td{padding:16px;font-size:.86rem}
}

@media (max-width:576px){
    .ko-topbar{min-height:64px;padding:9px 14px}
    .ko-topbar-left{gap:10px}
    .ko-breadcrumb{gap:7px;font-size:.76rem}
    .ko-breadcrumb span:first-child,
    .ko-breadcrumb i{display:none}
    .ko-content{width:calc(100% - 24px);padding-top:22px}
    .ko-page-header h1{font-size:1.8rem}
    .ko-eyebrow{font-size:.7rem;letter-spacing:1.6px}
    .ko-page-header p{font-size:.9rem}
    .ko-summary-card{padding:16px}
    .ko-summary-icon{width:46px;height:46px}
    .ko-summary-value{font-size:1.2rem}
    .ko-panel{border-radius:20px}
    .ko-toolbar{padding:14px}
    .ko-search input{height:50px;font-size:.9rem}
    .ko-search button{height:40px}
    .ko-table{min-width:900px}
    .ko-product-image{width:54px;height:54px}
}

@media (prefers-reduced-motion:reduce){
    *,*::before,*::after{
        animation:none!important;
        transition:none!important;
        scroll-behavior:auto!important;
    }
}
</style>

</head>

<body>

    @include('kasir.partials.sidebar')

    

    <main class="ko-main">

        <header class="ko-topbar">

            <div class="ko-topbar-left">

                <button
                    type="button"
                    class="ko-mobile-button"
                    id="openKasirSidebar"
                    aria-label="Buka menu"
                >
                    <i class="fas fa-bars"></i>
                </button>

                <div class="ko-breadcrumb">

                    <span>
                        Kasir
                    </span>

                    <i class="fas fa-chevron-right"></i>

                    <span class="current">
                        Stok Oleh-Oleh
                    </span>

                </div>

            </div>

            <div class="ko-user">

                <div class="ko-user-text">

                    <strong>
                        {{ $namaKasir }}
                    </strong>

                    <span>
                        Kasir Oleh-Oleh
                    </span>

                </div>

                <div class="ko-avatar">

                    {{ strtoupper(
                        mb_substr(
                            trim($namaKasir),
                            0,
                            1
                        )
                    ) }}

                </div>

            </div>

        </header>

        

        <div class="ko-content">

            <section class="ko-page-header">

                <div>

                    <span class="ko-eyebrow">
                        Inventaris
                    </span>

                    <h1>
                        Stok Oleh-Oleh
                    </h1>

                    <p>
                        Kelola jumlah stok produk oleh-oleh yang
                        tersedia untuk transaksi pelanggan.
                    </p>

                </div>

                @if($orderRouteExists)

                    <a
                        href="{{ route('kasir.oleholeh.orders') }}"
                        class="ko-order-link"
                    >

                        <i class="fas fa-receipt"></i>

                        Lihat Pesanan

                    </a>

                @else

                    <a
                        href="{{ url('/kasir-oleholeh/pesanan') }}"
                        class="ko-order-link"
                    >

                        <i class="fas fa-receipt"></i>

                        Lihat Pesanan

                    </a>

                @endif

            </section>

            

            @php

                $summaryCollection =
                    $items instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
                        ? collect($items->items())
                        : collect($items);

                $totalProducts =
                    method_exists($items, 'total')
                        ? $items->total()
                        : $summaryCollection->count();

                $outOfStock =
                    $summaryCollection
                        ->filter(fn ($item) => (int) ($item->stok ?? 0) <= 0)
                        ->count();

                $lowStock =
                    $summaryCollection
                        ->filter(function ($item) {
                            $stok = (int) ($item->stok ?? 0);

                            return $stok > 0 && $stok <= 5;
                        })
                        ->count();

            @endphp

            <section class="ko-summary">

                <div class="ko-summary-card">

                    <div class="ko-summary-icon">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>

                    <div>

                        <span class="ko-summary-label">
                            Total Produk
                        </span>

                        <strong class="ko-summary-value">
                            {{ number_format($totalProducts, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>

                <div class="ko-summary-card">

                    <div class="ko-summary-icon">
                        <i class="fas fa-triangle-exclamation"></i>
                    </div>

                    <div>

                        <span class="ko-summary-label">
                            Stok Menipis (Halaman Ini)
                        </span>

                        <strong class="ko-summary-value">
                            {{ number_format($lowStock, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>

                <div class="ko-summary-card">

                    <div class="ko-summary-icon">
                        <i class="fas fa-circle-xmark"></i>
                    </div>

                    <div>

                        <span class="ko-summary-label">
                            Stok Habis (Halaman Ini)
                        </span>

                        <strong class="ko-summary-value">
                            {{ number_format($outOfStock, 0, ',', '.') }}
                        </strong>

                    </div>

                </div>

            </section>

            

            <section class="ko-panel">

                <div class="ko-toolbar">

                    <form
                        method="GET"
                        action="{{ url()->current() }}"
                        class="ko-search"
                    >

                        <i class="fas fa-search"></i>

                        <input
                            type="search"
                            name="search"
                            aria-label="Cari produk oleh-oleh"
                            value="{{ $search }}"
                            placeholder="Cari nama produk atau jenis..."
                            autocomplete="off"
                        >

                        <button type="submit">
                            Cari
                        </button>

                    </form>

                    <span class="ko-product-count">

                        {{ number_format(
                            $totalProducts,
                            0,
                            ',',
                            '.'
                        ) }}

                        produk

                    </span>

                </div>

                

                @if($items->count() > 0)

                    <div class="ko-table-wrapper">

                        <table class="ko-table">

                            <thead>

                                <tr>

                                    <th>
                                        Produk
                                    </th>

                                    <th>
                                        Harga
                                    </th>

                                    <th>
                                        Stok Saat Ini
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Perbarui Stok
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($items as $item)

                                    @php

                                        $stok =
                                            max(
                                                0,
                                                (int) (
                                                    $item->stok
                                                        ?? 0
                                                )
                                            );

                                        

                                        $stockClass =
                                            $stok <= 0
                                                ? 'empty'
                                                : (
                                                    $stok <= 5
                                                        ? 'low'
                                                        : 'good'
                                                );

                                        

                                        $isAvailable =
                                            $stok > 0;

                                        

                                        $imageUrl =
                                            $item->gambar_url
                                                ?? (
                                                    !empty(
                                                        $item->gambar
                                                    )
                                                        ? asset(
                                                            'storage/' .
                                                            ltrim(
                                                                $item->gambar,
                                                                '/'
                                                            )
                                                        )
                                                        : null
                                                );

                                    @endphp

                                    <tr>

                                        <td>

                                            <div class="ko-product">

                                                <div class="ko-product-image">

                                                    @if($imageUrl)

                                                        <img
                                                            src="{{ $imageUrl }}"
                                                            alt="{{ $item->nama }}"
                                                            loading="lazy"
                                                            decoding="async"
                                                            onerror="this.onerror=null; this.remove(); this.parentElement.innerHTML='<i class=&quot;fas fa-bag-shopping&quot; aria-hidden=&quot;true&quot;></i>';"
                                                        >

                                                    @else

                                                        <i class="fas fa-bag-shopping"></i>

                                                    @endif

                                                </div>

                                                <div>

                                                    <span class="ko-product-name">
                                                        {{ $item->nama }}
                                                    </span>

                                                    <span class="ko-product-type">
                                                        {{ $item->jenis ?? '-' }}
                                                    </span>

                                                </div>

                                            </div>

                                        </td>

                                        

                                        <td>

                                            <span class="ko-price">

                                                Rp
                                                {{ number_format(
                                                    $item->harga ?? 0,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                            </span>

                                        </td>

                                        

                                        <td>

                                            <span
                                                class="ko-stock-badge {{ $stockClass }}"
                                            >

                                                @if($stok <= 0)

                                                    <i class="fas fa-circle-xmark"></i>

                                                @elseif($stok <= 5)

                                                    <i class="fas fa-triangle-exclamation"></i>

                                                @else

                                                    <i class="fas fa-circle-check"></i>

                                                @endif

                                                {{ number_format(
                                                    $stok,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }}

                                                pcs

                                            </span>

                                        </td>

                                        

                                        <td>

                                            @if($isAvailable)

                                                <span class="ko-status available">
                                                    Tersedia
                                                </span>

                                            @else

                                                <span class="ko-status unavailable">
                                                    Tidak Tersedia
                                                </span>

                                            @endif

                                        </td>

                                        

                                        <td>

                                            @if($stockUpdateRouteExists)

                                                <form
                                                    method="POST"
                                                    action="{{ route(
                                                        'kasir.oleholeh.stock.update',
                                                        $item->id_oleh_oleh
                                                    ) }}"
                                                    class="ko-stock-form"
                                                >

                                                    @csrf

                                                    @method('PUT')

                                                    <input
                                                        type="number"
                                                        name="stok"
                                                        class="ko-stock-input"
                                                        min="0"
                                                        max="2147483647"
                                                        step="1"
                                                        value="{{ $stok }}"
                                                        inputmode="numeric"
                                                        aria-label="Stok {{ $item->nama }}"
                                                        required
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="ko-save-button"
                                                        title="Simpan stok"
                                                        aria-label="Simpan stok {{ $item->nama }}"
                                                    >

                                                        <i class="fas fa-check"></i>

                                                    </button>

                                                </form>

                                            @else

                                                <span class="ko-route-warning">
                                                    Route update stok belum tersedia.
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    

                    @if(method_exists($items, 'links'))

                        <div class="ko-pagination">

                            {{ $items->withQueryString()->links() }}

                        </div>

                    @endif

                @else

                    <div class="ko-empty">

                        <div class="ko-empty-icon">
                            <i class="fas fa-box-open"></i>
                        </div>

                        <h3>
                            Belum Ada Produk
                        </h3>

                        <p>
                            Data oleh-oleh belum tersedia atau
                            tidak ditemukan berdasarkan pencarian.
                        </p>

                    </div>

                @endif

            </section>

        </div>

    </main>

    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.ko-stock-form').forEach(function (form) {
                const input = form.querySelector('.ko-stock-input');
                const button = form.querySelector('button[type="submit"]');

                if (!input || !button) {
                    return;
                }

                input.addEventListener('input', function () {
                    if (this.value === '') {
                        return;
                    }

                    const value = Number(this.value);

                    if (!Number.isFinite(value) || value < 0) {
                        this.value = '0';
                    }
                });

                form.addEventListener('submit', function (event) {
                    const value = Number(input.value);

                    if (
                        input.value.trim() === ''
                        || !Number.isInteger(value)
                        || value < 0
                    ) {
                        event.preventDefault();
                        input.setCustomValidity('Masukkan jumlah stok berupa bilangan bulat minimal 0.');
                        input.reportValidity();
                        input.focus();
                        return;
                    }

                    input.setCustomValidity('');

                    if (button.dataset.submitted === '1') {
                        event.preventDefault();
                        return;
                    }

                    button.dataset.submitted = '1';
                    button.disabled = true;
                    button.classList.add('is-saving');
                    button.setAttribute('aria-label', 'Menyimpan stok');

                    button.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i>';
                });

                input.addEventListener('input', function () {
                    this.setCustomValidity('');
                });
            });
        });
    </script>

</body>
</html>
