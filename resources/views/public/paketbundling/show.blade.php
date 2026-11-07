@extends('public.layouts.app')

@section('title', $paketBundling->nama_paket)

@section('content')

@php
    $resolveBundleImage = static function ($path) {
        if (!is_string($path) && !is_numeric($path)) {
            return null;
        }

        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $path = str_replace('\\\\', '/', $path);
        $path = ltrim($path, '/');

        do {
            $previousPath = $path;
            $path = preg_replace('#^(?:(?:public|storage)/|app/public/)+#i', '', $path);
        } while ($path !== $previousPath);

        $path = ltrim((string) $path, '/');

        return $path !== '' ? asset('storage/' . $path) : null;
    };

    $bundleImageFallback = asset('images/no-image.png');
@endphp

<section class="menu-detail-breadcrumb">
    <div class="public-container">
        <div class="menu-detail-breadcrumb-inner">

            <a href="{{ route('public.home') }}" class="menu-detail-breadcrumb-link">
                Home
            </a>

            <span class="menu-detail-breadcrumb-separator">/</span>

            <a href="{{ route('public.paketbundling.index') }}" class="menu-detail-breadcrumb-link">
                Paket Bundling
            </a>

            <span class="menu-detail-breadcrumb-separator">/</span>

            <span class="menu-detail-breadcrumb-current">
                {{ $paketBundling->nama_paket }}
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
                        src="{{ $resolveBundleImage($paketBundling->gambar) ?: $bundleImageFallback }}"
                        alt="{{ $paketBundling->nama_paket }}"
                        class="menu-detail-image"
                        onerror="
                            this.onerror=null;
                            this.src='{{ $bundleImageFallback }}';
                        "
                    >

                    <div class="menu-detail-image-overlay"></div>

                    @if($paketBundling->untuk)
                        <div class="menu-detail-image-category">
                            <span>{{ $paketBundling->untuk }}</span>
                        </div>
                    @endif

                </div>

            </div>

            <div class="menu-detail-information">

                <div class="menu-detail-category">
                    PAKET BUNDLING
                </div>

                <h1 class="menu-detail-title">
                    {{ $paketBundling->nama_paket }}
                </h1>

                <div class="menu-detail-price-wrapper">

                    <p class="menu-detail-price-label">
                        Harga Paket
                    </p>

                    <p class="menu-detail-price">
                        Rp {{ number_format($paketBundling->harga, 0, ',', '.') }}
                    </p>

                </div>

                <div class="menu-detail-divider"></div>

                <div class="menu-detail-description-section">

                    <h2 class="menu-detail-description-title">
                        Tentang Paket
                    </h2>

                    @if($paketBundling->deskripsi)

                        <p class="menu-detail-description">
                            {{ $paketBundling->deskripsi }}
                        </p>

                    @else

                        <p class="menu-detail-description menu-detail-description-empty">
                            Belum ada deskripsi untuk paket ini.
                        </p>

                    @endif

                </div>

                <div class="menu-detail-info-grid">

                    <div class="menu-detail-info-box">

                        <div class="menu-detail-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.6"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m9 12.75 2.25 2.25L15 9.75" />
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>

                        <div>
                            <p class="menu-detail-info-label">
                                Ketersediaan
                            </p>

                            <p class="menu-detail-info-value">
                                {{ $paketBundling->status }}
                            </p>
                        </div>

                    </div>

                    @if($paketBundling->untuk)

                        <div class="menu-detail-info-box">

                            <div class="menu-detail-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.6"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M9.568 3.75H6.75A2.25 2.25 0 0 0 4.5 6v2.818c0 .597.237 1.17.659 1.591l7.932 7.932a2.25 2.25 0 0 0 3.182 0l3.068-3.068a2.25 2.25 0 0 0 0-3.182L11.409 4.16a2.25 2.25 0 0 0-1.591-.66Z" />
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M7.5 7.5h.008v.008H7.5V7.5Z" />
                                </svg>
                            </div>

                            <div>
                                <p class="menu-detail-info-label">
                                    Cocok Untuk
                                </p>

                                <p class="menu-detail-info-value">
                                    {{ $paketBundling->untuk }}
                                </p>
                            </div>

                        </div>

                    @endif

                </div>

                <div class="menu-detail-actions">

                    <a
                        href="{{ route('public.paketbundling.index') }}"
                        class="menu-back-button"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="1.8"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>

                        <span>
                            Kembali ke Paket
                        </span>
                    </a>

                    <form
                        action="{{ route('pesanan.keranjang.tambah') }}"
                        method="POST"
                        class="menu-cart-form"
                    >
                        @csrf

                        <input type="hidden" name="type" value="bundling">
                        <input type="hidden" name="id" value="{{ $paketBundling->id_paket_bundling }}">
                        <input type="hidden" name="qty" value="1">

                        <button type="submit" class="menu-cart-button">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M2.75 4.75h1.56l1.62 10.12a2 2 0 0 0 1.97 1.68h8.72a2 2 0 0 0 1.96-1.6l1.14-5.7H5.02"/>
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9 20.25h.01M17 20.25h.01"/>
                            </svg>

                            <span>Tambah ke Keranjang</span>

                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="bundle-content-section">

    <div class="public-container">

        <div class="bundle-section-heading">

            <p class="bundle-section-eyebrow">
                ISI PAKET
            </p>

            <h2 class="bundle-section-title">
                Yang Kamu Dapatkan
            </h2>

            <p class="bundle-section-description">
                Berikut adalah menu dan wahana yang termasuk dalam paket bundling ini.
            </p>

        </div>

        <div class="bundle-items-grid">

            @if($paketBundling->menus->count() > 0)

                <div class="bundle-items-card">

                    <div class="bundle-items-card-header">

                        <div class="bundle-items-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                            </svg>
                        </div>

                        <div>
                            <h3>Menu</h3>
                            <span>
                                {{ $paketBundling->menus->count() }}
                                {{ $paketBundling->menus->count() === 1 ? 'item' : 'item' }}
                            </span>
                        </div>

                    </div>

                    <div class="bundle-items-list">

                        @foreach($paketBundling->menus as $menu)

                            <a
                                href="{{ route('public.menu.show', $menu->id_menu) }}"
                                class="bundle-item"
                            >

                                <div class="bundle-item-image">
                                    <img
                                        src="{{ $resolveBundleImage($menu->gambar) ?: $bundleImageFallback }}"
                                        alt="{{ $menu->nama_menu }}"
                                        onerror="this.onerror=null;this.src='{{ $bundleImageFallback }}';"
                                    >
                                </div>

                                <div class="bundle-item-info">

                                    <h4>
                                        {{ $menu->nama_menu }}
                                    </h4>

                                    @if($menu->kategori)
                                        <span>
                                            {{ $menu->kategori }}
                                        </span>
                                    @endif

                                </div>

                                <div class="bundle-item-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                    </svg>
                                </div>

                            </a>

                        @endforeach

                    </div>

                </div>

            @endif

            @if($paketBundling->wahanas->count() > 0)

                <div class="bundle-items-card">

                    <div class="bundle-items-card-header">

                        <div class="bundle-items-icon">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 3v18M5.5 6.5h13M5.5 17.5h13"/>
                            </svg>
                        </div>

                        <div>
                            <h3>Wahana</h3>
                            <span>
                                {{ $paketBundling->wahanas->count() }}
                                {{ $paketBundling->wahanas->count() === 1 ? 'item' : 'item' }}
                            </span>
                        </div>

                    </div>

                    <div class="bundle-items-list">

                        @foreach($paketBundling->wahanas as $wahana)

                            <a
                                href="{{ route('public.tiket-wahana.show', $wahana->id_tiket_wahana) }}"
                                class="bundle-item"
                            >

                                <div class="bundle-item-image">
                                    <img
                                        src="{{ $resolveBundleImage($wahana->gambar) ?: $bundleImageFallback }}"
                                        alt="{{ $wahana->nama_wahana }}"
                                        onerror="this.onerror=null;this.src='{{ $bundleImageFallback }}';"
                                    >
                                </div>

                                <div class="bundle-item-info">

                                    <h4>
                                        {{ $wahana->nama_wahana }}
                                    </h4>

                                    <span>
                                        Tiket Wahana
                                    </span>

                                </div>

                                <div class="bundle-item-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke-width="1.8"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                    </svg>
                                </div>

                            </a>

                        @endforeach

                    </div>

                </div>

            @endif

        </div>

        @if(
            $paketBundling->menus->count() === 0 &&
            $paketBundling->wahanas->count() === 0
        )

            <div class="bundle-empty">
                <div class="bundle-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </div>

                <h3>
                    Informasi isi paket belum tersedia
                </h3>

                <p>
                    Detail menu atau wahana untuk paket ini belum ditambahkan.
                </p>
            </div>

        @endif

    </div>

</section>

@php
    $paketLainnya = \App\Models\PaketBundling::query()
        ->where('status', 'Tersedia')
        ->where('id_paket_bundling', '!=', $paketBundling->id_paket_bundling)
        ->with(['menus', 'wahanas'])
        ->orderBy('nama_paket', 'asc')
        ->limit(4)
        ->get();
@endphp

@if($paketLainnya->count() > 0)

<section class="other-menu-section bundle-other-section">

    <div class="public-container">

        <div class="other-menu-heading">

            <p class="other-menu-eyebrow">
                PAKET LAINNYA
            </p>

            <h2 class="other-menu-title">
                Paket Bundling Lainnya
            </h2>

        </div>

        <div class="other-menu-subheader">

            <p>
                Pilihan paket lainnya yang tersedia di Noyo Gimbal.
            </p>

            <a
                href="{{ route('public.paketbundling.index') }}"
                class="other-menu-view-all"
            >
                Lihat Semua

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.8"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>

        </div>

        <div class="other-menu-grid">

            @foreach($paketLainnya as $paket)

                <article class="other-menu-card">

                    <a
                        href="{{ route('public.paketbundling.show', $paket->id_paket_bundling) }}"
                        class="other-menu-image-link"
                    >

                        <div class="other-menu-image">

                            <img
                                src="{{ $resolveBundleImage($paket->gambar) ?: $bundleImageFallback }}"
                                alt="{{ $paket->nama_paket }}"
                                onerror="this.onerror=null;this.src='{{ $bundleImageFallback }}';"
                            >

                            <div class="other-menu-image-overlay"></div>

                            @if($paket->untuk)
                                <div class="bundle-other-badge">
                                    {{ $paket->untuk }}
                                </div>
                            @endif

                        </div>

                    </a>

                    <div class="other-menu-content">

                        <p class="other-menu-category">
                            PAKET BUNDLING
                        </p>

                        <h3 class="other-menu-name">
                            <a href="{{ route('public.paketbundling.show', $paket->id_paket_bundling) }}">
                                {{ $paket->nama_paket }}
                            </a>
                        </h3>

                        <div class="other-menu-bottom">

                            <span class="other-menu-price">
                                Rp {{ number_format($paket->harga, 0, ',', '.') }}
                            </span>

                            <a
                                href="{{ route('public.paketbundling.show', $paket->id_paket_bundling) }}"
                                class="other-menu-arrow"
                                aria-label="Lihat {{ $paket->nama_paket }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                </svg>
                            </a>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>

        <div class="other-menu-mobile-action">

            <a
                href="{{ route('public.paketbundling.index') }}"
                class="other-menu-mobile-button"
            >
                Lihat Semua Paket

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.8"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>

        </div>

    </div>

</section>

@endif

<style>

.menu-detail-breadcrumb,
.menu-detail-section,
.bundle-content-section,
.other-menu-section {

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

.menu-detail-breadcrumb {
    padding: 42px 0 0;
}

.menu-detail-breadcrumb-inner {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    font-size: 12px;
}

.menu-detail-breadcrumb-link {
    flex-shrink: 0;
    color: var(--text-muted);
    transition: color var(--transition);
}

.menu-detail-breadcrumb-link:hover {
    color: var(--accent);
}

.menu-detail-breadcrumb-separator {
    flex-shrink: 0;
    color: var(--text-dim);
}

.menu-detail-breadcrumb-current {
    min-width: 0;
    overflow: hidden;
    color: var(--text-secondary);
    white-space: nowrap;
    text-overflow: ellipsis;
}

.menu-detail-section {
    padding: 48px 0 100px;
}

.menu-detail-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.05fr) minmax(0, .95fr);
    gap: 70px;
    align-items: center;
}

.menu-detail-image-column {
    position: relative;
    align-self: center;
}

.menu-detail-image-wrapper {
    position: relative;
    width: 100%;
    min-height: 470px;
    overflow: hidden;
    border: 1px solid var(--border-gold);
    border-radius: var(--radius-lg);
    background: var(--bg-soft);
    box-shadow: var(--shadow-soft);
}

.menu-detail-image {
    display: block;
    width: 100%;
    height: 470px;
    object-fit: cover;
    transition: transform .6s cubic-bezier(.2,.7,.2,1);
}

.menu-detail-image-wrapper:hover .menu-detail-image {
    transform: scale(1.025);
}

.menu-detail-image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        transparent 55%,
        rgba(10,10,10,.48) 100%
    );
    pointer-events: none;
}

.menu-detail-image-category {
    position: absolute;
    left: 22px;
    bottom: 22px;
    z-index: 2;
}

.menu-detail-image-category span {
    display: inline-flex;
    align-items: center;
    min-height: 32px;
    padding: 0 13px;
    border: 1px solid rgba(226,201,151,.28);
    border-radius: 999px;
    background: rgba(10,10,10,.72);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    color: var(--accent);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .06em;
}

.menu-detail-information {
    padding: 18px 0;
}

.menu-detail-category {
    display: inline-flex;
    align-items: center;
    min-height: 31px;
    padding: 0 12px;
    margin-bottom: 17px;
    border: 1px solid var(--border-gold);
    border-radius: 999px;
    background: rgba(226,201,151,.055);
    color: var(--accent);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: .10em;
    text-transform: uppercase;
}

.menu-detail-title {
    margin: 0;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(42px, 5vw, 64px);
    line-height: 1.04;
    font-weight: 700;
    letter-spacing: -.035em;
}

.menu-detail-price-wrapper {
    margin-top: 28px;
}

.menu-detail-price-label {
    margin-bottom: 4px;
    color: var(--text-dim);
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .10em;
    text-transform: uppercase;
}

.menu-detail-price {
    color: var(--accent);
    font-size: 31px;
    line-height: 1.2;
    font-weight: 700;
}

.menu-detail-divider {
    width: 100%;
    height: 1px;
    margin: 30px 0;
    background: linear-gradient(
        to right,
        var(--border-gold),
        transparent
    );
}

.menu-detail-description-title {
    margin: 0 0 11px;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 20px;
    font-weight: 700;
}

.menu-detail-description {
    max-width: 680px;
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.9;
    white-space: pre-line;
}

.menu-detail-description-empty {
    color: var(--text-dim);
    font-style: italic;
}

.menu-detail-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
    margin-top: 30px;
}

.menu-detail-info-box {
    display: flex;
    align-items: center;
    gap: 12px;
    min-height: 72px;
    padding: 12px;
    border: 1px solid var(--border-soft);
    border-radius: 15px;
    background: rgba(255,255,255,.025);
    transition:
        border-color var(--transition),
        background var(--transition);
}

.menu-detail-info-box:hover {
    border-color: var(--border-gold);
    background: rgba(226,201,151,.035);
}

.menu-detail-info-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border-gold);
    border-radius: 11px;
    background: rgba(226,201,151,.06);
    color: var(--accent);
}

.menu-detail-info-icon svg {
    width: 19px;
    height: 19px;
}

.menu-detail-info-label {
    color: var(--text-dim);
    font-size: 10px;
    letter-spacing: .04em;
}

.menu-detail-info-value {
    margin-top: 2px;
    color: var(--text-primary);
    font-size: 12px;
    font-weight: 600;
}

.menu-detail-actions {
    margin-top: 30px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.menu-back-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 48px;
    padding: 0 19px;
    border: 1px solid var(--border-gold);
    border-radius: 999px;
    background: rgba(226,201,151,.055);
    color: var(--text-secondary);
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all var(--transition);
}

.menu-back-button svg {
    width: 17px;
    height: 17px;
}

.menu-back-button:hover {
    border-color: var(--accent);
    background: rgba(226,201,151,.10);
    color: var(--accent);
    transform: translateX(-3px);
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

.menu-cart-button svg {
    width: 17px;
    height: 17px;
    flex-shrink: 0;
}

.bundle-content-section {
    padding: 0 0 100px;
}

.bundle-section-heading {
    max-width: 700px;
    margin-bottom: 28px;
}

.bundle-section-eyebrow,
.other-menu-eyebrow {
    margin: 0;
    color: var(--accent);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: .20em;
    text-transform: uppercase;
}

.bundle-section-title {
    margin: 7px 0 0;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(30px, 4vw, 44px);
    line-height: 1.1;
    font-weight: 700;
}

.bundle-section-description {
    margin: 12px 0 0;
    color: var(--text-muted);
    font-size: 13px;
    line-height: 1.8;
}

.bundle-items-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.bundle-items-card {
    overflow: hidden;
    border: 1px solid var(--border-soft);
    border-radius: 20px;
    background: var(--bg-card);
    transition:
        border-color var(--transition),
        background var(--transition),
        box-shadow var(--transition);
}

.bundle-items-card:hover {
    border-color: var(--border-gold);
    background: var(--bg-secondary);
    box-shadow: var(--shadow-soft);
}

.bundle-items-card-header {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 18px;
    border-bottom: 1px solid var(--border-soft);
}

.bundle-items-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border-gold);
    border-radius: 11px;
    background: rgba(226,201,151,.055);
    color: var(--accent);
}

.bundle-items-icon svg {
    width: 18px;
    height: 18px;
}

.bundle-items-card-header h3 {
    margin: 0;
    color: var(--text-primary);
    font-size: 14px;
    font-weight: 700;
}

.bundle-items-card-header span {
    display: block;
    margin-top: 3px;
    color: var(--text-dim);
    font-size: 10px;
}

.bundle-items-list {
    padding: 7px 12px 12px;
}

.bundle-item {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 11px 7px;
    border-radius: 13px;
    text-decoration: none;
    transition: background var(--transition);
}

.bundle-item:hover {
    background: rgba(226,201,151,.045);
}

.bundle-item-image {
    width: 58px;
    height: 58px;
    flex: 0 0 58px;
    overflow: hidden;
    border-radius: 11px;
    background: var(--bg-soft);
}

.bundle-item-image img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    transition: transform .4s ease;
}

.bundle-item:hover .bundle-item-image img {
    transform: scale(1.05);
}

.bundle-item-info {
    min-width: 0;
    flex: 1;
}

.bundle-item-info h4 {
    margin: 0;
    overflow: hidden;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 15px;
    font-weight: 700;
    line-height: 1.35;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.bundle-item-info span {
    display: block;
    margin-top: 5px;
    color: var(--text-dim);
    font-size: 10px;
}

.bundle-item-arrow {
    width: 31px;
    height: 31px;
    flex: 0 0 31px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border-gold);
    border-radius: 9px;
    background: rgba(226,201,151,.045);
    color: var(--accent);
    transition: all var(--transition);
}

.bundle-item-arrow svg {
    width: 15px;
    height: 15px;
}

.bundle-item:hover .bundle-item-arrow {
    background: var(--accent);
    border-color: var(--accent);
    color: var(--bg-primary);
    transform: translateX(2px);
}

.bundle-empty {
    padding: 45px 25px;
    text-align: center;
    border: 1px dashed var(--border-gold);
    border-radius: 20px;
    background: rgba(255,255,255,.02);
}

.bundle-empty-icon {
    width: 44px;
    height: 44px;
    margin: 0 auto 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border-gold);
    border-radius: 12px;
    color: var(--accent);
}

.bundle-empty-icon svg {
    width: 20px;
    height: 20px;
}

.bundle-empty h3 {
    margin: 0;
    color: var(--text-primary);
    font-size: 15px;
}

.bundle-empty p {
    margin: 8px 0 0;
    color: var(--text-muted);
    font-size: 12px;
}

.bundle-other-section {
    padding-bottom: 120px;
}

.bundle-other-badge {
    position: absolute;
    top: 13px;
    left: 13px;
    z-index: 2;
    display: inline-flex;
    align-items: center;
    min-height: 28px;
    padding: 0 10px;
    border: 1px solid rgba(226,201,151,.28);
    border-radius: 999px;
    background: rgba(10,10,10,.72);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    color: var(--accent);
    font-size: 9px;
    font-weight: 600;
    letter-spacing: .06em;
}

@media (max-width: 1200px) {

    .menu-detail-grid {
        gap: 50px;
    }

    .menu-detail-image-wrapper,
    .menu-detail-image {
        min-height: 430px;
        height: 430px;
    }

    .other-menu-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

}

@media (max-width: 992px) {

    .menu-detail-section {
        padding: 40px 0 90px;
    }

    .menu-detail-grid {
        grid-template-columns: 1fr;
        gap: 45px;
    }

    .menu-detail-image-column {
        position: relative;
        top: auto;
    }

    .menu-detail-image-wrapper,
    .menu-detail-image {
        min-height: 430px;
        height: 430px;
    }

    .menu-detail-information {
        padding: 0;
    }

    .bundle-items-grid {
        grid-template-columns: 1fr;
    }

    .other-menu-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

}

@media (max-width: 768px) {

    .menu-detail-breadcrumb {
        padding-top: 30px;
    }

    .menu-detail-section {
        padding-top: 35px;
    }

    .menu-detail-title {
        font-size: 44px;
    }

    .menu-detail-price {
        font-size: 28px;
    }

    .menu-detail-image-wrapper,
    .menu-detail-image {
        min-height: 360px;
        height: 360px;
    }

    .menu-detail-actions {
        display: grid;
        grid-template-columns: 1fr;
    }

    .menu-back-button,
    .menu-cart-form,
    .menu-cart-button {
        width: 100%;
    }

    .bundle-content-section {
        padding-bottom: 80px;
    }

    .other-menu-section {
        padding-bottom: 80px;
    }

}

@media (max-width: 640px) {

    .menu-detail-breadcrumb-inner {
        font-size: 11px;
    }

    .menu-detail-grid {
        gap: 35px;
    }

    .menu-detail-image-wrapper,
    .menu-detail-image {
        min-height: 330px;
        height: 330px;
        border-radius: 20px;
    }

    .menu-detail-image-category {
        left: 16px;
        bottom: 16px;
    }

    .menu-detail-title {
        font-size: 38px;
    }

    .menu-detail-info-grid {
        grid-template-columns: 1fr;
    }

    .other-menu-subheader {
        align-items: flex-start;
        flex-direction: column;
        gap: 10px;
    }

    .other-menu-view-all {
        display: none;
    }

    .other-menu-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .other-menu-image {
        height: 225px;
    }

    .other-menu-mobile-action {
        display: block;
    }

}

@media (max-width: 420px) {

    .menu-detail-title {
        font-size: 34px;
    }

    .menu-detail-price {
        font-size: 25px;
    }

    .menu-detail-description {
        font-size: 13px;
    }

    .menu-back-button {
        width: 100%;
    }

}

</style>

<div class="cart-success-overlay" id="cartSuccessOverlay" aria-hidden="true">

    <div
        class="cart-success-popup"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cartSuccessTitle"
    >

        <div class="cart-success-icon">

            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="2"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m4.5 12.75 4.5 4.5 10.5-10.5"/>
            </svg>

        </div>

        <h2 class="cart-success-title" id="cartSuccessTitle">
            Berhasil Ditambahkan
        </h2>

        <p class="cart-success-text" id="cartSuccessText">
            Pesanan sudah masuk ke keranjang.
        </p>

        <div class="cart-success-actions">

            <button
                type="button"
                class="cart-popup-button cart-popup-continue"
                id="cartContinueButton"
            >
                Lanjut Belanja
            </button>

            <a
                href="{{ route('pesanan.keranjang') }}"
                class="cart-popup-button cart-popup-view"
            >
                Lihat Keranjang
            </a>

        </div>

    </div>

</div>

<style>

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
}

.cart-success-popup {
    width: min(100%, 410px);
    padding: 30px 28px 27px;
    border: 1px solid rgba(226,201,151,.30);
    border-radius: 24px;
    background: #121212;
    box-shadow: 0 30px 90px rgba(0,0,0,.55);
    text-align: center;
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
    color: #e2c997;
}

.cart-success-icon svg {
    width: 27px;
    height: 27px;
}

.cart-success-title {
    margin: 0;
    color: #f8f4ed;
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 25px;
    line-height: 1.2;
    font-weight: 700;
}

.cart-success-text {
    margin: 10px auto 0;
    max-width: 330px;
    color: #a89988;
    font-size: 13px;
    line-height: 1.7;
}

.cart-success-text strong {
    color: #d4c9b5;
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
    transition: all .25s ease;
}

.cart-popup-continue {
    border: 1px solid rgba(226,201,151,.15);
    background: rgba(226,201,151,.05);
    color: #d4c9b5;
}

.cart-popup-continue:hover {
    border-color: #e2c997;
    color: #e2c997;
}

.cart-popup-view {
    border: 1px solid #e2c997;
    background: linear-gradient(135deg,#e2c997,#d4b384);
    color: #0a0a0a;
    text-decoration: none;
}

.cart-popup-view:hover {
    transform: translateY(-2px);
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

</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('.menu-cart-form');
    const overlay = document.getElementById('cartSuccessOverlay');
    const text = document.getElementById('cartSuccessText');
    const continueButton = document.getElementById('cartContinueButton');

    if (!form || !overlay) return;

    const originalButtonHTML =
        form.querySelector('button')?.innerHTML || '';

    function closePopup() {

        overlay.classList.remove('is-active');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';

    }

    function openPopup() {

        overlay.classList.add('is-active');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

    }

    form.addEventListener('submit', async function (event) {

        event.preventDefault();

        const button =
            form.querySelector('button[type="submit"]');

        const paketName =
            @json($paketBundling->nama_paket);

        if (!button) return;

        button.disabled = true;
        button.innerHTML =
            '<span>Menambahkan...</span>';

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
                throw new Error(
                    'Gagal menambahkan paket ke keranjang.'
                );
            }

            const finalUrl = response.url || '';

            if (
                finalUrl &&
                !finalUrl.includes('/keranjang')
            ) {
                throw new Error(
                    'Paket belum berhasil ditambahkan.'
                );
            }

            text.innerHTML =
                '<strong>' +
                paketName +
                '</strong> sudah masuk ke keranjang.';

            openPopup();

            button.innerHTML =
                '<span>✓ Ditambahkan</span>';

        } catch (error) {

            button.innerHTML = originalButtonHTML;

            window.alert(
                error.message ||
                'Paket gagal ditambahkan ke keranjang.'
            );

        } finally {

            button.disabled = false;

        }

    });

    continueButton.addEventListener(
        'click',
        closePopup
    );

    overlay.addEventListener(
        'click',
        function (event) {

            if (event.target === overlay) {
                closePopup();
            }

        }
    );

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                overlay.classList.contains('is-active')
            ) {
                closePopup();
            }

        }
    );

});

</script>

@endsection
