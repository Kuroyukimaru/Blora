@extends('public.layouts.app')

@section('title', $olehOleh->nama)

@section('content')

@php
    $gambarRaw = trim((string) ($olehOleh->gambar ?? ''));

    if ($gambarRaw !== '' && filter_var($gambarRaw, FILTER_VALIDATE_URL)) {
        $gambarProduk = $gambarRaw;
    } elseif ($gambarRaw !== '') {
        $gambarProduk = asset('storage/' . ltrim(preg_replace('#^storage/#', '', $gambarRaw), '/'));
    } else {
        $gambarProduk = asset('images/no-image.png');
    }

    $gambarFallback = asset('images/no-image.png');
@endphp


<section class="menu-detail-breadcrumb">

    <div class="public-container">

        <div class="menu-detail-breadcrumb-inner">

            <a
                href="{{ route('public.home') }}"
                class="menu-detail-breadcrumb-link"
            >
                Home
            </a>

            <span class="menu-detail-breadcrumb-separator">
                /
            </span>

            <a
                href="{{ route('public.oleholeh.index') }}"
                class="menu-detail-breadcrumb-link"
            >
                Menu
            </a>

            <span class="menu-detail-breadcrumb-separator">
                /
            </span>

            <span class="menu-detail-breadcrumb-current">
                {{ $olehOleh->nama }}
            </span>

        </div>

    </div>

</section>


<section class="menu-detail-section">

    <div class="public-container">

        <div class="menu-detail-grid">


            

            <div class="menu-detail-image-column">

                <div class="menu-detail-image-wrapper">

                    <img
                        src="{{ $gambarProduk }}"
                        alt="Foto {{ $olehOleh->nama }}"
                        class="menu-detail-image"
                        loading="eager"
                        decoding="async"
                        onerror="this.onerror=null;this.src='{{ $gambarFallback }}';"
                    >

                    <div class="menu-detail-image-overlay"></div>


                    
                    @if($olehOleh->jenis)

                        <div class="menu-detail-image-category">

                            <span>
                                {{ $olehOleh->jenis }}
                            </span>

                        </div>

                    @endif

                </div>

            </div>


            

            <div class="menu-detail-information">

                
                @if($olehOleh->jenis)

                    <div class="menu-detail-category">
                        {{ $olehOleh->jenis }}
                    </div>

                @endif


                
                <h1 class="menu-detail-title">
                    {{ $olehOleh->nama }}
                </h1>


                
                <div class="menu-detail-price-wrapper">

                    <p class="menu-detail-price-label">
                        Harga
                    </p>

                    <p class="menu-detail-price">
                        Rp {{ number_format($olehOleh->harga, 0, ',', '.') }}
                    </p>

                </div>


                
                <div class="menu-detail-divider"></div>


                
                <div class="menu-detail-description-section">

                    <h2 class="menu-detail-description-title">
                        Tentang Produk
                    </h2>

                    @if($olehOleh->deskripsi)

                        <p class="menu-detail-description">
                            {{ $olehOleh->deskripsi }}
                        </p>

                    @else

                        <p class="menu-detail-description menu-detail-description-empty">
                            Belum ada deskripsi untuk produk ini.
                        </p>

                    @endif

                </div>


                
                <div class="menu-detail-info-grid">


                    
                    <div class="menu-detail-info-box">

                        <div class="menu-detail-info-icon">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.6"
                                stroke="currentColor"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m9 12.75 2.25 2.25L15 9.75"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />

                            </svg>

                        </div>

                        <div>

                            <p class="menu-detail-info-label">
                                Ketersediaan
                            </p>

                            <p class="menu-detail-info-value">
                                {{ $olehOleh->status }}
                            </p>

                        </div>

                    </div>


                    
                    @if($olehOleh->jenis)

                        <div class="menu-detail-info-box">

                            <div class="menu-detail-info-icon">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.6"
                                    stroke="currentColor"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9.568 3.75H6.75A2.25 2.25 0 0 0 4.5 6v2.818c0 .597.237 1.17.659 1.591l7.932 7.932a2.25 2.25 0 0 0 3.182 0l3.068-3.068a2.25 2.25 0 0 0 0-3.182L11.409 4.16a2.25 2.25 0 0 0-1.591-.66Z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M7.5 7.5h.008v.008H7.5V7.5Z"
                                    />

                                </svg>

                            </div>

                            <div>

                                <p class="menu-detail-info-label">
                                    Jenis
                                </p>

                                <p class="menu-detail-info-value">
                                    {{ $olehOleh->jenis }}
                                </p>

                            </div>

                        </div>

                    @endif

                </div>


                
                <div class="menu-detail-info-box">

                    <div class="menu-detail-info-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.6"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M20.25 7.5 12 3 3.75 7.5M20.25 7.5 12 12m8.25-4.5v9L12 21m0-9L3.75 7.5m8.25 4.5v9m-8.25-13.5v9L12 21"
                            />
                        </svg>

                    </div>

                    <div>

                        <p class="menu-detail-info-label">
                            Stok
                        </p>

                        <p class="menu-detail-info-value">
                            {{ $olehOleh->stok > 0 ? $olehOleh->stok . ' tersedia' : 'Stok habis' }}
                        </p>

                    </div>

                </div>


                
                <div class="menu-detail-actions">

                    <a
                        href="{{ route('public.oleholeh.index') }}"
                        class="menu-back-button"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                            />

                        </svg>

                        <span>
                            Kembali ke Oleh-Oleh
                        </span>

                    </a>

                    <form
                        action="{{ route('pesanan.keranjang.tambah') }}"
                        method="POST"
                        class="menu-cart-form"
                    >
                        @csrf
                        <input type="hidden" name="type" value="oleh_oleh">
                        <input type="hidden" name="id" value="{{ $olehOleh->id_oleh_oleh }}">
                        <input type="hidden" name="qty" value="1">

                        <button
                            type="submit"
                            class="menu-cart-button"
                            {{ (int) $olehOleh->stok <= 0 ? 'disabled' : '' }}
                            aria-disabled="{{ (int) $olehOleh->stok <= 0 ? 'true' : 'false' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.75 4.75h1.56l1.62 10.12a2 2 0 0 0 1.97 1.68h8.72a2 2 0 0 0 1.96-1.6l1.14-5.7H5.02"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20.25h.01M17 20.25h.01"/>
                            </svg>
                            <span>Tambah ke Keranjang</span>
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


<style>

    

    .menu-detail-breadcrumb,
    .menu-detail-section,
    .other-menu-section {

        --bg-primary:
            #0a0a0a;

        --bg-secondary:
            #151515;

        --bg-soft:
            #1a1a1a;

        --bg-card:
            #121212;

        --text-primary:
            #f8f4ed;

        --text-secondary:
            #d4c9b5;

        --text-muted:
            #a89988;

        --text-dim:
            #7a6f62;

        --accent:
            #e2c997;

        --accent-hover:
            #d4b384;

        --accent-dark:
            #b89a6e;

        --border-soft:
            rgba(255,255,255,.06);

        --border-gold:
            rgba(226,201,151,.15);

        --border-gold-strong:
            rgba(226,201,151,.30);

        --shadow-soft:
            0 20px 60px rgba(0,0,0,.40);

        --shadow-hover:
            0 25px 70px rgba(0,0,0,.50);

        --transition:
            .25s cubic-bezier(.4,0,.2,1);
    }


    

    .menu-detail-breadcrumb {

        padding:
            42px 0 0;
    }


    .menu-detail-breadcrumb-inner {

        display:
            flex;

        align-items:
            center;

        gap:
            10px;

        min-width:
            0;

        font-size:
            12px;
    }


    .menu-detail-breadcrumb-link {

        flex-shrink:
            0;

        color:
            var(--text-muted);

        transition:
            color var(--transition);
    }


    .menu-detail-breadcrumb-link:hover {

        color:
            var(--accent);
    }


    .menu-detail-breadcrumb-separator {

        flex-shrink:
            0;

        color:
            var(--text-dim);
    }


    .menu-detail-breadcrumb-current {

        min-width:
            0;

        overflow:
            hidden;

        color:
            var(--text-secondary);

        white-space:
            nowrap;

        text-overflow:
            ellipsis;
    }


    

    .menu-detail-section {

        padding:
            48px 0 120px;
    }


    .menu-detail-grid {

        display:
            grid;

        grid-template-columns:
            minmax(0, 1.05fr)
            minmax(0, .95fr);

        gap:
            70px;

        align-items:
            center;
    }


    

    .menu-detail-image-column {

        position:
            sticky;

        top:
            110px;
    }


    .menu-detail-image-wrapper {

        position:
            relative;

        width:
            100%;

        min-height:
            470px;

        overflow:
            hidden;

        border:
            1px solid
            var(--border-gold);

        border-radius:
            var(--radius-lg);

        background:
            var(--bg-soft);

        box-shadow:
            var(--shadow-soft);
    }


    .menu-detail-image {

        display:
            block;

        width:
            100%;

        height:
            470px;

        object-fit:
            cover;

        object-position:
            center center;

        transition:
            transform .6s
            cubic-bezier(.2,.7,.2,1);
    }


    .menu-detail-image-wrapper:hover
    .menu-detail-image {

        transform:
            scale(1.025);
    }


    .menu-detail-image-overlay {

        position:
            absolute;

        inset:
            0;

        background:
            linear-gradient(
                to bottom,
                transparent 55%,
                rgba(10,10,10,.48) 100%
            );

        pointer-events:
            none;
    }


    .menu-detail-image-category {

        position:
            absolute;

        left:
            22px;

        bottom:
            22px;

        z-index:
            2;
    }


    .menu-detail-image-category span {

        display:
            inline-flex;

        align-items:
            center;

        min-height:
            32px;

        padding:
            0 13px;

        border:
            1px solid
            rgba(226,201,151,.28);

        border-radius:
            999px;

        background:
            rgba(10,10,10,.72);

        backdrop-filter:
            blur(12px);

        -webkit-backdrop-filter:
            blur(12px);

        color:
            var(--accent);

        font-size:
            11px;

        font-weight:
            600;

        letter-spacing:
            .06em;
    }


    

    .menu-detail-information {

        padding:
            18px 0;
    }


    .menu-detail-category {

        display:
            inline-flex;

        align-items:
            center;

        min-height:
            31px;

        padding:
            0 12px;

        margin-bottom:
            17px;

        border:
            1px solid
            var(--border-gold);

        border-radius:
            999px;

        background:
            rgba(226,201,151,.055);

        color:
            var(--accent);

        font-size:
            10px;

        font-weight:
            600;

        letter-spacing:
            .10em;

        text-transform:
            uppercase;
    }


    .menu-detail-title {

        margin:
            0;

        color:
            var(--text-primary);

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size:
            clamp(42px, 5vw, 64px);

        line-height:
            1.04;

        font-weight:
            700;

        letter-spacing:
            -.035em;
    }


    

    .menu-detail-price-wrapper {

        margin-top:
            28px;
    }


    .menu-detail-price-label {

        margin-bottom:
            4px;

        color:
            var(--text-dim);

        font-size:
            11px;

        font-weight:
            500;

        letter-spacing:
            .10em;

        text-transform:
            uppercase;
    }


    .menu-detail-price {

        color:
            var(--accent);

        font-size:
            31px;

        line-height:
            1.2;

        font-weight:
            700;
    }


    

    .menu-detail-divider {

        width:
            100%;

        height:
            1px;

        margin:
            30px 0;

        background:
            linear-gradient(
                to right,
                var(--border-gold),
                transparent
            );
    }


    

    .menu-detail-description-title {

        margin:
            0 0 11px;

        color:
            var(--text-primary);

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size:
            20px;

        font-weight:
            700;
    }


    .menu-detail-description {

        max-width:
            680px;

        color:
            var(--text-muted);

        font-size:
            14px;

        line-height:
            1.9;
    }


    .menu-detail-description-empty {

        color:
            var(--text-dim);

        font-style:
            italic;
    }


    

    .menu-detail-info-grid {

        display:
            grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            10px;

        margin-top:
            30px;
    }


    .menu-detail-info-box {

        display:
            flex;

        align-items:
            center;

        gap:
            12px;

        min-height:
            72px;

        padding:
            12px;

        border:
            1px solid
            var(--border-soft);

        border-radius:
            15px;

        background:
            rgba(255,255,255,.025);

        transition:
            border-color var(--transition),
            background var(--transition);
    }


    .menu-detail-info-box:hover {

        border-color:
            var(--border-gold);

        background:
            rgba(226,201,151,.035);
    }


    .menu-detail-info-icon {

        width:
            40px;

        height:
            40px;

        flex-shrink:
            0;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border:
            1px solid
            var(--border-gold);

        border-radius:
            11px;

        background:
            rgba(226,201,151,.06);

        color:
            var(--accent);
    }


    .menu-detail-info-icon svg {

        width:
            19px;

        height:
            19px;
    }


    .menu-detail-info-label {

        color:
            var(--text-dim);

        font-size:
            10px;

        letter-spacing:
            .04em;
    }


    .menu-detail-info-value {

        margin-top:
            2px;

        color:
            var(--text-primary);

        font-size:
            12px;

        font-weight:
            600;
    }


    

    .menu-detail-actions {

        margin-top:
            30px;

        display:
            flex;

        flex-wrap:
            wrap;

        gap:
            10px;
    }


    .menu-back-button {

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        gap:
            8px;

        min-height:
            48px;

        padding:
            0 19px;

        border:
            1px solid
            var(--border-gold);

        border-radius:
            999px;

        background:
            rgba(226,201,151,.055);

        color:
            var(--text-secondary);

        font-size:
            12px;

        font-weight:
            600;

        transition:
            all var(--transition);
    }


    .menu-back-button svg {

        width:
            17px;

        height:
            17px;
    }


    .menu-back-button:hover {

        border-color:
            var(--accent);

        background:
            rgba(226,201,151,.10);

        color:
            var(--accent);

        transform:
            translateX(-3px);
    }


    

    .other-menu-section {

        padding:
            0 0 120px;
    }


    .other-menu-heading {

        margin-bottom:
            15px;
    }


    .other-menu-eyebrow {

        margin:
            0;

        color:
            var(--accent);

        font-size:
            10px;

        font-weight:
            600;

        letter-spacing:
            .20em;

        text-transform:
            uppercase;
    }


    .other-menu-title {

        margin:
            7px 0 0;

        color:
            var(--text-primary);

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size:
            clamp(30px, 4vw, 44px);

        line-height:
            1.1;

        font-weight:
            700;
    }


    .other-menu-subheader {

        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        gap:
            20px;

        margin-bottom:
            24px;
    }


    .other-menu-subheader p {

        margin:
            0;

        color:
            var(--text-muted);

        font-size:
            13px;
    }


    .other-menu-view-all {

        display:
            inline-flex;

        align-items:
            center;

        gap:
            7px;

        flex-shrink:
            0;

        color:
            var(--text-secondary);

        font-size:
            12px;

        transition:
            color var(--transition);
    }


    .other-menu-view-all:hover {

        color:
            var(--accent);
    }


    .other-menu-view-all svg {

        width:
            16px;

        height:
            16px;
    }


    

    .other-menu-grid {

        display:
            grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap:
            20px;
    }


    

    .other-menu-card {

        overflow:
            hidden;

        display:
            flex;

        flex-direction:
            column;

        border:
            1px solid
            var(--border-soft);

        border-radius:
            20px;

        background:
            var(--bg-card);

        transition:
            transform var(--transition),
            border-color var(--transition),
            background var(--transition),
            box-shadow var(--transition);
    }


    .other-menu-card:hover {

        transform:
            translateY(-6px);

        border-color:
            var(--border-gold-strong);

        background:
            var(--bg-secondary);

        box-shadow:
            var(--shadow-hover);
    }


    .other-menu-image-link {

        display:
            block;
    }


    .other-menu-image {

        position:
            relative;

        width:
            100%;

        height:
            195px;

        overflow:
            hidden;

        background:
            var(--bg-soft);
    }


    .other-menu-image img {

        width:
            100%;

        height:
            100%;

        object-fit:
            cover;

        transition:
            transform .5s
            cubic-bezier(.2,.7,.2,1);
    }


    .other-menu-card:hover
    .other-menu-image img {

        transform:
            scale(1.06);
    }


    .other-menu-image-overlay {

        position:
            absolute;

        inset:
            0;

        background:
            linear-gradient(
                to bottom,
                transparent 45%,
                rgba(10,10,10,.45)
            );

        pointer-events:
            none;
    }


    

    .other-menu-content {

        padding:
            17px;

        display:
            flex;

        flex-direction:
            column;

        flex:
            1;
    }


    .other-menu-category {

        margin:
            0 0 6px;

        color:
            var(--accent);

        font-size:
            9px;

        font-weight:
            600;

        letter-spacing:
            .10em;

        text-transform:
            uppercase;
    }


    .other-menu-name {

        margin:
            0;

        color:
            var(--text-primary);

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size:
            18px;

        line-height:
            1.3;

        font-weight:
            700;
    }


    .other-menu-name a {

        color:
            inherit;

        transition:
            color var(--transition);
    }


    .other-menu-name a:hover {

        color:
            var(--accent);
    }


    .other-menu-bottom {

        margin-top:
            auto;

        padding-top:
            17px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        gap:
            12px;

        border-top:
            1px solid
            var(--border-soft);
    }


    .other-menu-price {

        color:
            var(--accent);

        font-size:
            13px;

        font-weight:
            700;
    }


    .other-menu-arrow {

        width:
            34px;

        height:
            34px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border:
            1px solid
            var(--border-gold);

        border-radius:
            10px;

        background:
            rgba(226,201,151,.055);

        color:
            var(--accent);

        transition:
            all var(--transition);
    }


    .other-menu-arrow svg {

        width:
            16px;

        height:
            16px;
    }


    .other-menu-arrow:hover {

        background:
            var(--accent);

        border-color:
            var(--accent);

        color:
            var(--bg-primary);

        transform:
            translateX(2px);
    }


    

    .other-menu-empty {

        padding:
            45px 25px;

        text-align:
            center;

        border:
            1px dashed
            var(--border-gold);

        border-radius:
            20px;

        background:
            rgba(255,255,255,.02);
    }


    .other-menu-empty p {

        margin:
            0;

        color:
            var(--text-muted);

        font-size:
            13px;
    }


    

    .other-menu-mobile-action {

        display:
            none;

        margin-top:
            22px;
    }


    .other-menu-mobile-button {

        width:
            100%;

        min-height:
            48px;

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        gap:
            8px;

        border:
            1px solid
            var(--accent);

        border-radius:
            999px;

        background:
            linear-gradient(
                135deg,
                var(--accent),
                var(--accent-hover)
            );

        color:
            var(--bg-primary);

        font-size:
            12px;

        font-weight:
            700;

        transition:
            all var(--transition);
    }


    .other-menu-mobile-button:hover {

        background:
            linear-gradient(
                135deg,
                var(--accent-hover),
                var(--accent-dark)
            );

        transform:
            translateY(-2px);
    }


    .other-menu-mobile-button svg {

        width:
            16px;

        height:
            16px;
    }


    

    @media (max-width: 1200px) {

        .menu-detail-grid {

            gap:
                50px;
        }


        .menu-detail-image-wrapper,
        .menu-detail-image {

            min-height:
                430px;

            height:
                430px;
        }


        .other-menu-grid {

            grid-template-columns:
                repeat(3, minmax(0, 1fr));
        }

    }


    @media (max-width: 992px) {

        .menu-detail-section {

            padding:
                40px 0 90px;
        }


        .menu-detail-grid {

            grid-template-columns:
                1fr;

            gap:
                45px;
        }


        .menu-detail-image-column {

            position:
                relative;

            top:
                auto;
        }


        .menu-detail-image-wrapper,
        .menu-detail-image {

            min-height:
                430px;

            height:
                430px;
        }


        .menu-detail-information {

            padding:
                0;
        }


        .other-menu-grid {

            grid-template-columns:
                repeat(2, minmax(0, 1fr));
        }

    }


    @media (max-width: 768px) {

        .menu-detail-breadcrumb {

            padding-top:
                30px;
        }


        .menu-detail-section {

            padding-top:
                35px;
        }


        .menu-detail-title {

            font-size:
                44px;
        }


        .menu-detail-price {

            font-size:
                28px;
        }


        .menu-detail-image-wrapper,
        .menu-detail-image {

            min-height:
                360px;

            height:
                360px;
        }


        .other-menu-section {

            padding-bottom:
                80px;
        }

    }


    @media (max-width: 640px) {

        .menu-detail-breadcrumb-inner {

            font-size:
                11px;
        }


        .menu-detail-grid {

            gap:
                35px;
        }


        .menu-detail-image-wrapper,
        .menu-detail-image {

            min-height:
                330px;

            height:
                330px;

            border-radius:
                20px;
        }


        .menu-detail-image-category {

            left:
                16px;

            bottom:
                16px;
        }


        .menu-detail-title {

            font-size:
                38px;
        }


        .menu-detail-info-grid {

            grid-template-columns:
                1fr;
        }


        .other-menu-subheader {

            align-items:
                flex-start;

            flex-direction:
                column;

            gap:
                10px;
        }


        .other-menu-view-all {

            display:
                none;
        }


        .other-menu-grid {

            grid-template-columns:
                1fr;

            gap:
                16px;
        }


        .other-menu-image {

            height:
                225px;
        }


        .other-menu-mobile-action {

            display:
                block;
        }

    }


    @media (max-width: 768px) {
        .menu-detail-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .menu-back-button,
        .menu-cart-form,
        .menu-cart-button {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .cart-success-popup {
            padding: 26px 19px 22px;
            border-radius: 20px;
        }

        .cart-success-title {
            font-size: 22px;
        }

        .cart-success-actions {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 420px) {

        .menu-detail-title {

            font-size:
                34px;
        }


        .menu-detail-price {

            font-size:
                25px;
        }


        .menu-detail-description {

            font-size:
                13px;
        }


        .menu-back-button {

            width:
                100%;
        }

    }


    

    .menu-cart-form {
        margin: 0;
    }

    .menu-cart-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 48px;
        padding: 0 21px;
        border: 1px solid var(--accent);
        border-radius: 999px;
        background: linear-gradient(135deg, var(--accent), var(--accent-hover));
        color: var(--bg-primary);
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition);
        box-shadow: 0 10px 30px rgba(226,201,151,.10);
    }

    .menu-cart-button:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, var(--accent-hover), var(--accent-dark));
        box-shadow: 0 14px 35px rgba(226,201,151,.16);
    }

    .menu-cart-button:active {
        transform: translateY(0);
    }

    .menu-cart-button svg {
        width: 17px;
        height: 17px;
        flex-shrink: 0;
    }

    

    .cart-success-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0,0,0,.68);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .cart-success-overlay.is-active {
        display: flex;
        animation: cartOverlayIn .2s ease-out;
    }

    .cart-success-popup {
        width: min(100%, 410px);
        padding: 30px 28px 27px;
        border: 1px solid var(--border-gold-strong);
        border-radius: 24px;
        background: #121212;
        box-shadow: 0 30px 90px rgba(0,0,0,.55);
        text-align: center;
        transform: translateY(10px) scale(.97);
        animation: cartPopupIn .25s cubic-bezier(.2,.7,.2,1) forwards;
    }

    .cart-success-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(226,201,151,.35);
        border-radius: 50%;
        background: rgba(226,201,151,.08);
        color: var(--accent);
    }

    .cart-success-icon svg {
        width: 27px;
        height: 27px;
    }

    .cart-success-title {
        margin: 0;
        color: var(--text-primary);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 25px;
        line-height: 1.2;
        font-weight: 700;
    }

    .cart-success-text {
        margin: 10px auto 0;
        max-width: 330px;
        color: var(--text-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .cart-success-text strong {
        color: var(--text-secondary);
        font-weight: 600;
    }

    .cart-success-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 23px;
    }

    .cart-popup-button {
        min-height: 44px;
        padding: 0 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition);
    }

    .cart-popup-continue {
        border: 1px solid var(--border-gold);
        background: rgba(226,201,151,.05);
        color: var(--text-secondary);
    }

    .cart-popup-continue:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    .cart-popup-view {
        border: 1px solid var(--accent);
        background: linear-gradient(135deg, var(--accent), var(--accent-hover));
        color: var(--bg-primary);
    }

    .cart-popup-view:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, var(--accent-hover), var(--accent-dark));
    }

    @keyframes cartOverlayIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes cartPopupIn {
        to { transform: translateY(0) scale(1); }
    }


    .menu-detail-breadcrumb-inner,
    .menu-detail-grid,
    .menu-detail-information,
    .menu-detail-actions,
    .menu-detail-info-box,
    .other-menu-card {
        min-width: 0;
    }

    .menu-detail-title,
    .menu-detail-description,
    .menu-detail-info-value,
    .other-menu-name,
    .other-menu-price {
        overflow-wrap: anywhere;
    }

    .menu-cart-button:disabled {
        opacity: .48;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
        filter: grayscale(.35);
    }

    .menu-back-button:focus-visible,
    .menu-cart-button:focus-visible,
    .cart-popup-button:focus-visible,
    .other-menu-view-all:focus-visible,
    .other-menu-mobile-button:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 4px;
    }

    .cart-success-overlay[aria-hidden="true"] {
        visibility: hidden;
        pointer-events: none;
    }

    .cart-success-overlay.is-active {
        visibility: visible;
        pointer-events: auto;
    }

    @media (max-width: 768px) {
        .menu-detail-image-column {
            width: 100%;
        }

        .menu-detail-actions {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
        }

        .menu-back-button,
        .menu-cart-form,
        .menu-cart-button {
            width: 100%;
        }

        .menu-cart-button {
            min-height: 50px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .menu-detail-breadcrumb *,
        .menu-detail-section *,
        .other-menu-section *,
        .cart-success-overlay,
        .cart-success-popup {
            scroll-behavior: auto !important;
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
        }
    }

</style>


<div class="cart-success-overlay" id="cartSuccessOverlay" aria-hidden="true">
    <div class="cart-success-popup" role="dialog" aria-modal="true" aria-labelledby="cartSuccessTitle">
        <div class="cart-success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 4.5 4.5 10.5-10.5" />
            </svg>
        </div>

        <h2 class="cart-success-title" id="cartSuccessTitle">Berhasil Ditambahkan</h2>
        <p class="cart-success-text" id="cartSuccessText">
            Pesanan sudah masuk ke keranjang.
        </p>

        <div class="cart-success-actions">
            <button type="button" class="cart-popup-button cart-popup-continue" id="cartContinueButton">
                Lanjut Belanja
            </button>
            <a href="{{ route('pesanan.keranjang') }}" class="cart-popup-button cart-popup-view">
                Lihat Keranjang
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.menu-cart-form');
    const overlay = document.getElementById('cartSuccessOverlay');
    const message = document.getElementById('cartSuccessText');
    const continueButton = document.getElementById('cartContinueButton');

    if (!form || !overlay || !message || !continueButton) return;

    const button = form.querySelector('button[type="submit"]');
    const popup = overlay.querySelector('[role="dialog"]');
    const productName = @json($olehOleh->nama);
    const originalButtonHTML = button ? button.innerHTML : '';
    let previousFocus = null;
    let previousBodyOverflow = '';

    function openPopup() {
        previousFocus = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        overlay.classList.add('is-active');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        continueButton.focus();
    }

    function closePopup() {
        overlay.classList.remove('is-active');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = previousBodyOverflow;

        if (previousFocus && typeof previousFocus.focus === 'function') {
            previousFocus.focus();
        }
    }

    function showSuccessMessage(name) {
        message.replaceChildren();

        const strong = document.createElement('strong');
        strong.textContent = name;

        message.append(strong, document.createTextNode(' sudah masuk ke keranjang.'));
    }

    async function readResponse(response) {
        const contentType = response.headers.get('content-type') || '';

        if (contentType.includes('application/json')) {
            const data = await response.json();

            if (data.success === false || data.status === 'error') {
                throw new Error(data.message || 'Pesanan gagal ditambahkan ke keranjang.');
            }

            return true;
        }

        if (response.redirected) {
            const finalUrl = new URL(response.url, window.location.origin);

            if (finalUrl.pathname.toLowerCase().includes('keranjang')) {
                return true;
            }
        }

        throw new Error('Respons server tidak dapat dikonfirmasi. Silakan periksa keranjang sebelum mencoba kembali.');
    }

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        if (!button || button.disabled) return;

        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
        button.innerHTML = '<span>Menambahkan...</span>';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json, text/html;q=0.9, */*;q=0.8'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                let errorMessage = 'Gagal menambahkan pesanan.';

                if ((response.headers.get('content-type') || '').includes('application/json')) {
                    const errorData = await response.json().catch(() => null);
                    if (errorData && errorData.message) errorMessage = errorData.message;
                }

                throw new Error(errorMessage);
            }

            await readResponse(response);
            showSuccessMessage(productName);
            openPopup();
            button.innerHTML = '<span>✓ Ditambahkan</span>';
        } catch (error) {
            button.innerHTML = originalButtonHTML;
            window.alert(error.message || 'Pesanan gagal ditambahkan ke keranjang.');
        } finally {
            button.disabled = false;
            button.removeAttribute('aria-busy');
        }
    });

    continueButton.addEventListener('click', closePopup);

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) closePopup();
    });

    document.addEventListener('keydown', function (event) {
        if (!overlay.classList.contains('is-active')) return;

        if (event.key === 'Escape') {
            event.preventDefault();
            closePopup();
            return;
        }

        if (event.key === 'Tab' && popup) {
            const focusable = popup.querySelectorAll(
                'a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])'
            );

            if (!focusable.length) return;

            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });
});
</script>

@endsection
