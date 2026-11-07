@extends('public.layouts.app')

@section('title', $tiketWahana->nama_wahana)

@section('content')

@php
    $statusWahana = trim((string) ($tiketWahana->status ?? ''));
    $wahanaTersedia = strtolower($statusWahana) === 'tersedia';
    $statusWahanaLabel = $statusWahana !== '' ? $statusWahana : 'Tidak diketahui';
    $gambarWahana = asset('images/no-image.png');
    $gambarAsli = $tiketWahana->gambar ?? null;

    if (is_string($gambarAsli) && trim($gambarAsli) !== '') {
        $pathGambar = trim(str_replace('\\', '/', $gambarAsli));

        if (filter_var($pathGambar, FILTER_VALIDATE_URL)) {
            $gambarWahana = $pathGambar;
        } else {
            $pathGambar = ltrim($pathGambar, '/');

            if (str_starts_with($pathGambar, 'storage/')) {
                $pathGambar = substr($pathGambar, strlen('storage/'));
            }

            if (str_starts_with($pathGambar, 'public/')) {
                $pathGambar = substr($pathGambar, strlen('public/'));
            }

            $pathGambar = ltrim($pathGambar, '/');

            if ($pathGambar !== '') {
                if (file_exists(public_path('storage/' . $pathGambar))) {
                    $gambarWahana = asset('storage/' . $pathGambar);
                } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($pathGambar)) {
                    $gambarWahana = asset('storage/' . $pathGambar);
                } elseif (file_exists(public_path($pathGambar))) {
                    $gambarWahana = asset($pathGambar);
                }
            }
        }
    }

    if ($gambarWahana === asset('images/no-image.png')) {
        $gambarDariDatabase = $tiketWahana->gambar_url ?? null;

        if (is_string($gambarDariDatabase) && trim($gambarDariDatabase) !== '') {
            $gambarDariDatabase = trim($gambarDariDatabase);

            if (filter_var($gambarDariDatabase, FILTER_VALIDATE_URL)) {
                $gambarWahana = $gambarDariDatabase;
            } else {
                $gambarDariDatabase = ltrim(str_replace('\\', '/', $gambarDariDatabase), '/');

                if (str_starts_with($gambarDariDatabase, 'storage/')) {
                    $gambarDariDatabase = substr($gambarDariDatabase, strlen('storage/'));
                }

                if (str_starts_with($gambarDariDatabase, 'public/')) {
                    $gambarDariDatabase = substr($gambarDariDatabase, strlen('public/'));
                }

                if ($gambarDariDatabase !== '') {
                    if (file_exists(public_path('storage/' . $gambarDariDatabase))) {
                        $gambarWahana = asset('storage/' . $gambarDariDatabase);
                    } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($gambarDariDatabase)) {
                        $gambarWahana = asset('storage/' . $gambarDariDatabase);
                    } elseif (file_exists(public_path($gambarDariDatabase))) {
                        $gambarWahana = asset($gambarDariDatabase);
                    }
                }
            }
        }
    }
@endphp

<section class="wahana-detail-breadcrumb">
    <div class="public-container">
        <div class="wahana-detail-breadcrumb-inner">
            <a href="{{ route('public.home') }}" class="wahana-detail-breadcrumb-link">Home</a>
            <span class="wahana-detail-breadcrumb-separator">/</span>
            <a href="{{ route('public.tiket-wahana.index') }}" class="wahana-detail-breadcrumb-link">Wahana</a>
            <span class="wahana-detail-breadcrumb-separator">/</span>
            <span class="wahana-detail-breadcrumb-current">{{ $tiketWahana->nama_wahana }}</span>
        </div>
    </div>
</section>

<section class="wahana-detail-section">
    <div class="public-container">
        <div class="wahana-detail-grid">

            <div class="wahana-detail-image-column">
                <div class="wahana-detail-image-wrapper">
                    <img
                        src="{{ $gambarWahana }}"
                        alt="{{ $tiketWahana->nama_wahana }}"
                        class="wahana-detail-image"
                        onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';"
                    >
                    <div class="wahana-detail-image-overlay"></div>

                    <div class="wahana-detail-image-category">
                        <span>Wahana</span>
                    </div>
                </div>
            </div>

            <div class="wahana-detail-information">

                <div class="wahana-detail-category">
                    Wahana Noyo Gimbal
                </div>

                <h1 class="wahana-detail-title">
                    {{ $tiketWahana->nama_wahana }}
                </h1>

                <div class="wahana-detail-price-wrapper">
                    <p class="wahana-detail-price-label">Harga</p>
                    <p class="wahana-detail-price">
                        Rp {{ number_format((float) ($tiketWahana->harga ?? 0), 0, ',', '.') }}
                    </p>
                </div>

                <div class="wahana-detail-divider"></div>

                <div class="wahana-detail-description-section">
                    <h2 class="wahana-detail-description-title">
                        Ketentuan Wahana
                    </h2>

                    @if($tiketWahana->ketentuan)
                        <p class="wahana-detail-description">
                            {{ $tiketWahana->ketentuan }}
                        </p>
                    @else
                        <p class="wahana-detail-description wahana-detail-description-empty">
                            Belum ada ketentuan khusus untuk wahana ini.
                        </p>
                    @endif
                </div>

                <div class="wahana-detail-info-grid">

                    <div class="wahana-detail-info-box">
                        <div class="wahana-detail-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 2.25 2.25L15 9.75"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="wahana-detail-info-label">Ketersediaan</p>
                            <p class="wahana-detail-info-value {{ $wahanaTersedia ? 'is-available' : 'is-unavailable' }}">{{ $statusWahanaLabel }}</p>
                        </div>
                    </div>

                    <div class="wahana-detail-info-box">
                        <div class="wahana-detail-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3.75H6.75A2.25 2.25 0 0 0 4.5 6v2.818c0 .597.237 1.17.659 1.591l7.932 7.932a2.25 2.25 0 0 0 3.182 0l3.068-3.068a2.25 2.25 0 0 0 0-3.182L11.409 4.16a2.25 2.25 0 0 0-1.591-.66Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h.008v.008H7.5V7.5Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="wahana-detail-info-label">Jenis</p>
                            <p class="wahana-detail-info-value">Tiket Wahana</p>
                        </div>
                    </div>

                </div>

                <div class="wahana-detail-actions">

                    <a href="{{ route('public.tiket-wahana.index') }}" class="wahana-back-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                        </svg>
                        <span>Kembali ke Wahana</span>
                    </a>

                    @if($wahanaTersedia)
                        <form action="{{ route('pesanan.keranjang.tambah') }}" method="POST" class="wahana-cart-form">
                            @csrf
                            <input type="hidden" name="type" value="wahana">
                            <input type="hidden" name="id" value="{{ $tiketWahana->id_tiket_wahana }}">
                            <input type="hidden" name="qty" value="1">

                            <button type="submit" class="wahana-cart-button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.75 4.75h1.56l1.62 10.12a2 2 0 0 0 1.97 1.68h8.72a2 2 0 0 0 1.96-1.6l1.14-5.7H5.02"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 20.25h.01M17 20.25h.01"/>
                                </svg>
                                <span>Tambah ke Keranjang</span>
                            </button>
                        </form>
                    @else
                        <div class="wahana-unavailable-note" role="status" aria-live="polite">
                            Tiket wahana ini sedang tidak tersedia.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .wahana-detail-breadcrumb,
    .wahana-detail-section,
    .other-wahana-section {
        --bg-primary: #0a0a0a;
        --bg-secondary: #151515;
        --bg-soft: #1a1a1a;
        --bg-card: #121212;
        --text-primary: #f8f4ed;
        --text-secondary: #d4c9b5;
        --text-muted: #a89988;
        --text-dim: #7a6f62;
        --accent: #e2c997;
        --accent-hover: #d4b384;
        --accent-dark: #b89a6e;
        --border-soft: rgba(255,255,255,.06);
        --border-gold: rgba(226,201,151,.15);
        --border-gold-strong: rgba(226,201,151,.30);
        --shadow-soft: 0 20px 60px rgba(0,0,0,.40);
        --shadow-hover: 0 25px 70px rgba(0,0,0,.50);
        --transition: .25s cubic-bezier(.4,0,.2,1);
    }

    .wahana-detail-breadcrumb { padding: 42px 0 0; }

    .wahana-detail-breadcrumb-inner {
        display:flex;
        align-items:center;
        gap:10px;
        min-width:0;
        font-size:12px;
    }

    .wahana-detail-breadcrumb-link {
        flex-shrink:0;
        color:var(--text-muted);
        transition:color var(--transition);
    }

    .wahana-detail-breadcrumb-link:hover { color:var(--accent); }

    .wahana-detail-breadcrumb-separator {
        flex-shrink:0;
        color:var(--text-dim);
    }

    .wahana-detail-breadcrumb-current {
        min-width:0;
        overflow:hidden;
        color:var(--text-secondary);
        white-space:nowrap;
        text-overflow:ellipsis;
    }

    .wahana-detail-section { padding:48px 0 120px; }

    .wahana-detail-grid {
        display:grid;
        grid-template-columns:minmax(0,1.05fr) minmax(0,.95fr);
        gap:70px;
        align-items:center;
    }

    .wahana-detail-image-column {
        position:relative;
        align-self:center;
    }

    .wahana-detail-image-wrapper {
        position:relative;
        width:100%;
        min-height:470px;
        overflow:hidden;
        border:1px solid var(--border-gold);
        border-radius:var(--radius-lg, 24px);
        background:var(--bg-soft);
        box-shadow:var(--shadow-soft);
    }

    .wahana-detail-image {
        display:block;
        width:100%;
        height:470px;
        object-fit:cover;
        transition:transform .6s cubic-bezier(.2,.7,.2,1);
    }

    .wahana-detail-image-wrapper:hover .wahana-detail-image { transform:scale(1.025); }

    .wahana-detail-image-overlay {
        position:absolute;
        inset:0;
        background:linear-gradient(to bottom,transparent 55%,rgba(10,10,10,.48) 100%);
        pointer-events:none;
    }

    .wahana-detail-image-category {
        position:absolute;
        left:22px;
        bottom:22px;
        z-index:2;
    }

    .wahana-detail-image-category span {
        display:inline-flex;
        align-items:center;
        min-height:32px;
        padding:0 13px;
        border:1px solid rgba(226,201,151,.28);
        border-radius:999px;
        background:rgba(10,10,10,.72);
        backdrop-filter:blur(12px);
        -webkit-backdrop-filter:blur(12px);
        color:var(--accent);
        font-size:11px;
        font-weight:600;
        letter-spacing:.06em;
    }

    .wahana-detail-information { padding:18px 0; }

    .wahana-detail-category {
        display:inline-flex;
        align-items:center;
        min-height:31px;
        padding:0 12px;
        margin-bottom:17px;
        border:1px solid var(--border-gold);
        border-radius:999px;
        background:rgba(226,201,151,.055);
        color:var(--accent);
        font-size:10px;
        font-weight:600;
        letter-spacing:.10em;
        text-transform:uppercase;
    }

    .wahana-detail-title {
        margin:0;
        color:var(--text-primary);
        font-family:'Playfair Display',Georgia,serif;
        font-size:clamp(42px,5vw,64px);
        line-height:1.04;
        font-weight:700;
        letter-spacing:-.035em;
    }

    .wahana-detail-price-wrapper { margin-top:28px; }

    .wahana-detail-price-label {
        margin-bottom:4px;
        color:var(--text-dim);
        font-size:11px;
        font-weight:500;
        letter-spacing:.10em;
        text-transform:uppercase;
    }

    .wahana-detail-price {
        color:var(--accent);
        font-size:31px;
        line-height:1.2;
        font-weight:700;
    }

    .wahana-detail-divider {
        width:100%;
        height:1px;
        margin:30px 0;
        background:linear-gradient(to right,var(--border-gold),transparent);
    }

    .wahana-detail-description-title {
        margin:0 0 11px;
        color:var(--text-primary);
        font-family:'Playfair Display',Georgia,serif;
        font-size:20px;
        font-weight:700;
    }

    .wahana-detail-description {
        max-width:680px;
        color:var(--text-muted);
        font-size:14px;
        line-height:1.9;
        white-space:pre-line;
    }

    .wahana-detail-description-empty {
        color:var(--text-dim);
        font-style:italic;
    }

    .wahana-detail-info-grid {
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:10px;
        margin-top:30px;
    }

    .wahana-detail-info-box {
        display:flex;
        align-items:center;
        gap:12px;
        min-height:72px;
        padding:12px;
        border:1px solid var(--border-soft);
        border-radius:15px;
        background:rgba(255,255,255,.025);
        transition:border-color var(--transition),background var(--transition);
    }

    .wahana-detail-info-box:hover {
        border-color:var(--border-gold);
        background:rgba(226,201,151,.035);
    }

    .wahana-detail-info-icon {
        width:40px;
        height:40px;
        flex-shrink:0;
        display:flex;
        align-items:center;
        justify-content:center;
        border:1px solid var(--border-gold);
        border-radius:11px;
        background:rgba(226,201,151,.06);
        color:var(--accent);
    }

    .wahana-detail-info-icon svg { width:19px; height:19px; }

    .wahana-detail-info-label {
        color:var(--text-dim);
        font-size:10px;
        letter-spacing:.04em;
    }

    .wahana-detail-info-value {
        margin-top:2px;
        color:var(--text-primary);
        font-size:12px;
        font-weight:600;
    }

    .wahana-detail-info-value.is-available {
        color: #9bc9a1;
    }

    .wahana-detail-info-value.is-unavailable {
        color: #dfa69e;
    }

    .wahana-detail-actions {
        margin-top:30px;
        display:flex;
        flex-wrap:wrap;
        gap:10px;
    }

    .wahana-back-button,
    .wahana-cart-button {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        min-height:48px;
        padding:0 19px;
        border-radius:999px;
        font-size:12px;
        font-weight:600;
        transition:all var(--transition);
    }

    .wahana-back-button {
        border:1px solid var(--border-gold);
        background:rgba(226,201,151,.055);
        color:var(--text-secondary);
    }

    .wahana-back-button:hover {
        border-color:var(--accent);
        background:rgba(226,201,151,.10);
        color:var(--accent);
        transform:translateX(-3px);
    }

    .wahana-back-button svg,
    .wahana-cart-button svg { width:17px; height:17px; flex-shrink:0; }

    .wahana-cart-form { margin:0; }

    .wahana-unavailable-note {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 12px 18px;
        border: 1px solid rgba(217, 130, 118, .28);
        border-radius: 999px;
        color: #dfa69e;
        background: rgba(217, 130, 118, .07);
        font-size: 12px;
        font-weight: 600;
        line-height: 1.5;
    }

    .wahana-cart-button {
        border:1px solid var(--accent);
        background:linear-gradient(135deg,var(--accent),var(--accent-hover));
        color:var(--bg-primary);
        cursor:pointer;
        box-shadow:0 10px 30px rgba(226,201,151,.10);
    }

    .wahana-cart-button:hover {
        transform:translateY(-2px);
        background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));
        box-shadow:0 14px 35px rgba(226,201,151,.16);
    }

    .wahana-cart-button:active { transform:translateY(0); }

    .other-wahana-section { padding:0 0 120px; }

    .other-wahana-heading { margin-bottom:15px; }

    .other-wahana-eyebrow {
        margin:0;
        color:var(--accent);
        font-size:10px;
        font-weight:600;
        letter-spacing:.20em;
        text-transform:uppercase;
    }

    .other-wahana-title {
        margin:7px 0 0;
        color:var(--text-primary);
        font-family:'Playfair Display',Georgia,serif;
        font-size:clamp(30px,4vw,44px);
        line-height:1.1;
        font-weight:700;
    }

    .other-wahana-subheader {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
        margin-bottom:24px;
    }

    .other-wahana-subheader p {
        margin:0;
        color:var(--text-muted);
        font-size:13px;
    }

    .other-wahana-view-all {
        display:inline-flex;
        align-items:center;
        gap:7px;
        flex-shrink:0;
        color:var(--text-secondary);
        font-size:12px;
        transition:color var(--transition);
    }

    .other-wahana-view-all:hover { color:var(--accent); }

    .other-wahana-view-all svg { width:16px; height:16px; }

    .other-wahana-grid {
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:20px;
    }

    .other-wahana-card {
        overflow:hidden;
        display:flex;
        flex-direction:column;
        border:1px solid var(--border-soft);
        border-radius:20px;
        background:var(--bg-card);
        transition:transform var(--transition),border-color var(--transition),background var(--transition),box-shadow var(--transition);
    }

    .other-wahana-card:hover {
        transform:translateY(-6px);
        border-color:var(--border-gold-strong);
        background:var(--bg-secondary);
        box-shadow:var(--shadow-hover);
    }

    .other-wahana-image-link { display:block; }

    .other-wahana-image {
        position:relative;
        width:100%;
        height:195px;
        overflow:hidden;
        background:var(--bg-soft);
    }

    .other-wahana-image img {
        width:100%;
        height:100%;
        object-fit:cover;
        transition:transform .5s cubic-bezier(.2,.7,.2,1);
    }

    .other-wahana-card:hover .other-wahana-image img { transform:scale(1.06); }

    .other-wahana-image-overlay {
        position:absolute;
        inset:0;
        background:linear-gradient(to bottom,transparent 45%,rgba(10,10,10,.45));
        pointer-events:none;
    }

    .other-wahana-content {
        padding:17px;
        display:flex;
        flex-direction:column;
        flex:1;
    }

    .other-wahana-category {
        margin:0 0 6px;
        color:var(--accent);
        font-size:9px;
        font-weight:600;
        letter-spacing:.10em;
        text-transform:uppercase;
    }

    .other-wahana-name {
        margin:0;
        color:var(--text-primary);
        font-family:'Playfair Display',Georgia,serif;
        font-size:18px;
        line-height:1.3;
        font-weight:700;
    }

    .other-wahana-name a {
        color:inherit;
        transition:color var(--transition);
    }

    .other-wahana-name a:hover { color:var(--accent); }

    .other-wahana-description {
        margin:8px 0 0;
        color:var(--text-muted);
        font-size:11px;
        line-height:1.65;
        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
    }

    .other-wahana-bottom {
        margin-top:auto;
        padding-top:17px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        border-top:1px solid var(--border-soft);
    }

    .other-wahana-price {
        color:var(--accent);
        font-size:13px;
        font-weight:700;
    }

    .other-wahana-arrow {
        width:34px;
        height:34px;
        display:flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
        border:1px solid var(--border-gold);
        border-radius:10px;
        background:rgba(226,201,151,.055);
        color:var(--accent);
        transition:all var(--transition);
    }

    .other-wahana-arrow svg { width:16px; height:16px; }

    .other-wahana-arrow:hover {
        background:var(--accent);
        border-color:var(--accent);
        color:var(--bg-primary);
        transform:translateX(2px);
    }

    .other-wahana-empty {
        padding:45px 25px;
        text-align:center;
        border:1px dashed var(--border-gold);
        border-radius:20px;
        background:rgba(255,255,255,.02);
    }

    .other-wahana-empty p {
        margin:0;
        color:var(--text-muted);
        font-size:13px;
    }

    .other-wahana-mobile-action { display:none; margin-top:22px; }

    .other-wahana-mobile-button {
        width:100%;
        min-height:48px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        border:1px solid var(--accent);
        border-radius:999px;
        background:linear-gradient(135deg,var(--accent),var(--accent-hover));
        color:var(--bg-primary);
        font-size:12px;
        font-weight:700;
        transition:all var(--transition);
    }

    .other-wahana-mobile-button:hover {
        background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));
        transform:translateY(-2px);
    }

    .other-wahana-mobile-button svg { width:16px; height:16px; }

    @media (max-width:1200px) {
        .wahana-detail-grid { gap:50px; }
        .wahana-detail-image-wrapper,
        .wahana-detail-image { min-height:430px; height:430px; }
        .other-wahana-grid { grid-template-columns:repeat(3,minmax(0,1fr)); }
    }

    @media (max-width:992px) {
        .wahana-detail-section { padding:40px 0 90px; }
        .wahana-detail-grid { grid-template-columns:1fr; gap:45px; }
        .wahana-detail-image-column { position:relative; top:auto; }
        .wahana-detail-image-wrapper,
        .wahana-detail-image { min-height:430px; height:430px; }
        .wahana-detail-information { padding:0; }
        .other-wahana-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
    }

    @media (max-width:768px) {
        .wahana-detail-breadcrumb { padding-top:30px; }
        .wahana-detail-section { padding-top:35px; }
        .wahana-detail-title { font-size:44px; }
        .wahana-detail-price { font-size:28px; }
        .wahana-detail-image-wrapper,
        .wahana-detail-image { min-height:360px; height:360px; }
    }

    @media (max-width:640px) {
        .wahana-detail-breadcrumb-inner { font-size:11px; }
        .wahana-detail-grid { gap:35px; }
        .wahana-detail-image-wrapper,
        .wahana-detail-image {
            min-height:330px;
            height:330px;
            border-radius:20px;
        }
        .wahana-detail-image-category { left:16px; bottom:16px; }
        .wahana-detail-title { font-size:38px; }
        .wahana-detail-info-grid { grid-template-columns:1fr; }
        .other-wahana-subheader {
            align-items:flex-start;
            flex-direction:column;
            gap:10px;
        }
        .other-wahana-view-all { display:none; }
        .other-wahana-grid { grid-template-columns:1fr; gap:16px; }
        .other-wahana-image { height:225px; }
        .other-wahana-mobile-action { display:block; }
    }

    @media (max-width:768px) {
        .wahana-detail-actions {
            display:grid;
            grid-template-columns:1fr;
        }
        .wahana-back-button,
        .wahana-cart-form,
        .wahana-cart-button,
        .wahana-unavailable-note {
            width:100%;
        }
    }

    @media (max-width:420px) {
        .wahana-detail-title { font-size:34px; }
        .wahana-detail-price { font-size:25px; }
        .wahana-detail-description { font-size:13px; }
        .wahana-back-button,
        .wahana-cart-button { width:100%; }
    }

    .wahana-cart-success-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0, 0, 0, .72);
        backdrop-filter: blur(9px);
        -webkit-backdrop-filter: blur(9px);
    }

    .wahana-cart-success-overlay.is-active {
        display: flex;
        animation: wahanaCartOverlayIn .2s ease-out;
    }

    .wahana-cart-success-popup {
        width: min(100%, 410px);
        padding: 30px 28px 27px;
        border: 1px solid var(--border-gold-strong);
        border-radius: 24px;
        background: #121212;
        box-shadow: 0 30px 90px rgba(0, 0, 0, .58);
        text-align: center;
        transform: translateY(12px) scale(.97);
        animation: wahanaCartPopupIn .25s cubic-bezier(.2, .7, .2, 1) forwards;
    }

    .wahana-cart-success-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(226, 201, 151, .35);
        border-radius: 50%;
        background: rgba(226, 201, 151, .08);
        color: var(--accent);
    }

    .wahana-cart-success-icon svg {
        width: 27px;
        height: 27px;
    }

    .wahana-cart-success-title {
        margin: 0;
        color: var(--text-primary);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 25px;
        line-height: 1.2;
        font-weight: 700;
    }

    .wahana-cart-success-text {
        margin: 10px auto 0;
        max-width: 330px;
        color: var(--text-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .wahana-cart-success-text strong {
        color: var(--text-secondary);
        font-weight: 600;
    }

    .wahana-cart-success-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 23px;
    }

    .wahana-cart-popup-button {
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
        text-decoration: none;
    }

    .wahana-cart-popup-continue {
        border: 1px solid var(--border-gold);
        background: rgba(226, 201, 151, .055);
        color: var(--text-secondary);
    }

    .wahana-cart-popup-continue:hover {
        border-color: var(--accent);
        background: rgba(226, 201, 151, .10);
        color: var(--accent);
    }

    .wahana-cart-popup-view {
        border: 1px solid var(--accent);
        background: linear-gradient(135deg, var(--accent), var(--accent-hover));
        color: var(--bg-primary);
        box-shadow: 0 10px 30px rgba(226, 201, 151, .10);
    }

    .wahana-cart-popup-view:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, var(--accent-hover), var(--accent-dark));
        box-shadow: 0 14px 35px rgba(226, 201, 151, .16);
    }

    .wahana-cart-button.is-loading {
        opacity: .78;
        cursor: wait;
        pointer-events: none;
    }

    .wahana-cart-button.is-added {
        pointer-events: none;
    }

    @keyframes wahanaCartOverlayIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes wahanaCartPopupIn {
        to {
            transform: translateY(0) scale(1);
        }
    }

    @keyframes wahanaCartSpin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 480px) {
        .wahana-cart-success-popup {
            padding: 26px 19px 22px;
            border-radius: 20px;
        }

        .wahana-cart-success-title {
            font-size: 22px;
        }

        .wahana-cart-success-actions {
            grid-template-columns: 1fr;
        }
    }

</style>

<div
    id="wahanaCartSuccessOverlay"
    class="wahana-cart-success-overlay"
    aria-hidden="true"
>
    <div
        class="wahana-cart-success-popup"
        role="dialog"
        aria-modal="true"
        aria-labelledby="wahanaCartSuccessTitle"
    >
        <div class="wahana-cart-success-icon">
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.8"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m5 12.5 4 4L19 6.5"/>
            </svg>
        </div>

        <h2 id="wahanaCartSuccessTitle" class="wahana-cart-success-title">
            Berhasil Ditambahkan
        </h2>

        <p class="wahana-cart-success-text">
            <strong>{{ $tiketWahana->nama_wahana }}</strong>
            sudah masuk ke keranjang.
            Kamu tetap berada di halaman ini dan bisa melihat pesananmu
            melalui halaman keranjang.
        </p>

        <div class="wahana-cart-success-actions">
            <button
                type="button"
                id="wahanaCartContinueButton"
                class="wahana-cart-popup-button wahana-cart-popup-continue"
            >
                Lanjut Melihat
            </button>

            <a
                href="{{ route('pesanan.keranjang') }}"
                class="wahana-cart-popup-button wahana-cart-popup-view"
            >
                Lihat Keranjang
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cartForm = document.querySelector('.wahana-cart-form');
    const cartButton = cartForm ? cartForm.querySelector('.wahana-cart-button') : null;
    const overlay = document.getElementById('wahanaCartSuccessOverlay');
    const continueButton = document.getElementById('wahanaCartContinueButton');
    const cartUrl = @json(route('pesanan.keranjang'));

    if (!cartForm || !cartButton || !overlay) {
        return;
    }

    const originalButtonHtml = cartButton.innerHTML;
    let previousFocus = null;
    let previousBodyOverflow = '';
    let submitting = false;

    function normalizedPath(url) {
        try {
            const parsedUrl = new URL(url, window.location.origin);
            return parsedUrl.pathname.replace(/\/+$/, '') || '/';
        } catch (error) {
            return '';
        }
    }

    const expectedCartPath = normalizedPath(cartUrl);

    function openCartPopup() {
        previousFocus = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        overlay.classList.add('is-active');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        if (continueButton) {
            window.requestAnimationFrame(function () {
                continueButton.focus();
            });
        }
    }

    function closeCartPopup() {
        if (!overlay.classList.contains('is-active')) {
            return;
        }

        overlay.classList.remove('is-active');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = previousBodyOverflow;
        cartButton.innerHTML = originalButtonHtml;
        cartButton.classList.remove('is-loading', 'is-added');
        cartButton.removeAttribute('aria-busy');
        cartButton.disabled = false;
        submitting = false;

        if (previousFocus && typeof previousFocus.focus === 'function') {
            previousFocus.focus();
        }
    }

    function setLoadingState() {
        cartButton.disabled = true;
        cartButton.classList.remove('is-added');
        cartButton.classList.add('is-loading');
        cartButton.setAttribute('aria-busy', 'true');
        cartButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:17px;height:17px;animation:wahanaCartSpin .8s linear infinite;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v3m0 12v3m9-9h-3M6 12H3m15.364-6.364-2.121 2.121M8.757 15.243l-2.121 2.121m10.607 0-2.121-2.121M8.757 8.757 6.636 6.636" />
            </svg>
            <span>Menambahkan...</span>
        `;
    }

    function setAddedState() {
        cartButton.classList.remove('is-loading');
        cartButton.classList.add('is-added');
        cartButton.removeAttribute('aria-busy');
        cartButton.disabled = true;
        cartButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:17px;height:17px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12.5 4 4L19 6.5" />
            </svg>
            <span>Sudah Ditambahkan</span>
        `;
    }

    function resetButtonAfterError() {
        cartButton.classList.remove('is-loading', 'is-added');
        cartButton.removeAttribute('aria-busy');
        cartButton.disabled = false;
        cartButton.innerHTML = originalButtonHtml;
        submitting = false;
    }

    cartForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        if (submitting || cartButton.disabled) {
            return;
        }

        submitting = true;
        setLoadingState();

        try {
            const response = await fetch(cartForm.action, {
                method: 'POST',
                body: new FormData(cartForm),
                credentials: 'same-origin',
                redirect: 'follow',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json, text/html;q=0.9'
                }
            });

            const contentType = response.headers.get('content-type') || '';
            const finalPath = normalizedPath(response.url);
            const redirectedToCart = response.redirected && finalPath === expectedCartPath;
            let result = null;

            if (contentType.includes('application/json')) {
                try {
                    result = await response.json();
                } catch (parseError) {
                    throw new Error('Respons server tidak valid.');
                }
            }

            const jsonSuccess = result !== null && (
                result.success === true ||
                result.status === 'success' ||
                result.status === true
            );

            if (!response.ok || (!jsonSuccess && !redirectedToCart)) {
                const message = result && (result.message || result.error);
                throw new Error(message || 'Server tidak mengonfirmasi penambahan tiket ke keranjang.');
            }

            setAddedState();
            openCartPopup();
        } catch (error) {
            console.error('Tambah keranjang gagal:', error);
            resetButtonAfterError();
            window.alert(error.message || 'Tiket wahana gagal ditambahkan ke keranjang. Periksa koneksi dan ketersediaan tiket, lalu coba lagi.');
        }
    });

    if (continueButton) {
        continueButton.addEventListener('click', closeCartPopup);
    }

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) {
            closeCartPopup();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!overlay.classList.contains('is-active')) {
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            closeCartPopup();
            return;
        }

        if (event.key === 'Tab') {
            const focusableElements = overlay.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])');
            if (!focusableElements.length) {
                event.preventDefault();
                return;
            }

            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];

            if (event.shiftKey && document.activeElement === firstElement) {
                event.preventDefault();
                lastElement.focus();
            } else if (!event.shiftKey && document.activeElement === lastElement) {
                event.preventDefault();
                firstElement.focus();
            }
        }
    });
});
</script>

@endsection
