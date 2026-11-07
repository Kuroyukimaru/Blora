@extends('public.layouts.app')

@section('title', 'Paket Bundling')

@section('content')

@php
    $resolvePaketImage = function ($path) {
        if (!is_string($path) || trim($path) === '') {
            return null;
        }

        $path = trim($path);

        if (preg_match('/^https?:\\/\\//i', $path)) {
            return $path;
        }

        $path = str_replace('\\', '/', $path);
        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        if (str_starts_with($path, 'public/')) {
            $path = substr($path, strlen('public/'));
        }

        $path = ltrim($path, '/');

        return $path !== '' ? asset('storage/' . $path) : null;
    };

    $paketImageFallback = asset('images/no-image.png');
@endphp

<section class="menu-hero paket-hero">

    <div class="public-container">

        <div class="menu-hero-inner">

            <div class="menu-breadcrumb">

                <a
                    href="{{ route('public.home') }}"
                    class="menu-breadcrumb-link"
                >
                    Home
                </a>

                <span class="menu-breadcrumb-separator">/</span>

                <span class="menu-breadcrumb-current">
                    Paket Bundling
                </span>

            </div>

            <div class="menu-heading">

                <span class="menu-eyebrow">
                    Pilihan Paket Noyo Gimbal
                </span>

                <h1 class="menu-title">
                    Nikmati Lebih Banyak
                    <span>dalam Satu Paket</span>
                </h1>

                <p class="menu-description">
                    Pilih paket bundling yang sesuai dengan kebutuhanmu.
                    Setiap paket berisi pilihan menu dan wahana yang
                    tersedia di Noyo Gimbal.
                </p>

            </div>

        </div>

    </div>

</section>

<section class="menu-filter-section paket-filter-section">

    <div class="public-container">

        <div class="menu-filter-box">

            <form
                id="paketFilterForm"
                action="{{ route('public.paketbundling.index') }}"
                method="GET"
                class="menu-filter-form paket-filter-form"
            >

                <div class="menu-search-wrapper paket-search-field">

                    <label
                        for="search"
                        class="menu-filter-label"
                    >
                        Cari paket
                    </label>

                    <div class="menu-search">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="menu-search-icon"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0Z"
                            />
                        </svg>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama paket..."
                            class="menu-form-input menu-search-input"
                            autocomplete="off"
                        >

                        <button
                            type="button"
                            id="clearSearch"
                            class="menu-clear-search {{ request('search') ? 'is-visible' : '' }}"
                            aria-label="Hapus pencarian"
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
                                    d="M6 18 18 6M6 6l12 12"
                                />
                            </svg>
                        </button>

                    </div>

                </div>

                <div class="menu-filter-field paket-filter-field">

                    <label
                        for="untuk"
                        class="menu-filter-label"
                    >
                        Tampilkan
                    </label>

                    <div class="menu-select-wrapper">

                        <select
                            id="untuk"
                            name="untuk"
                            class="menu-form-input menu-auto-submit"
                        >

                            <option value="">
                                Semua Paket
                            </option>

                            <option
                                value="Anak-anak"
                                @selected(request('untuk') === 'Anak-anak')
                            >
                                Anak-anak
                            </option>

                            <option
                                value="Dewasa"
                                @selected(request('untuk') === 'Dewasa')
                            >
                                Dewasa
                            </option>

                        </select>

                    </div>

                </div>

                <div class="menu-filter-field paket-filter-field">

                    <label
                        for="sort"
                        class="menu-filter-label"
                    >
                        Urutkan
                    </label>

                    <div class="menu-select-wrapper">

                        <select
                            id="sort"
                            name="sort"
                            class="menu-form-input menu-auto-submit"
                        >

                            <option
                                value="price_asc"
                                @selected(request('sort', 'price_asc') === 'price_asc')
                            >
                                Harga Terendah
                            </option>

                            <option
                                value="price_desc"
                                @selected(request('sort') === 'price_desc')
                            >
                                Harga Tertinggi
                            </option>

                        </select>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>

<section class="menu-result-section paket-result-section">

    <div class="public-container">

        <div class="menu-result-header">

            <div>

                <p class="menu-result-text">

                    Menampilkan

                    <span class="menu-result-count">
                        {{ $paketBundlings->count() }}
                    </span>

                    paket bundling

                    @if(request()->filled('search'))

                        <span class="menu-result-context">
                            untuk
                            "<strong>{{ request('search') }}</strong>"
                        </span>

                    @elseif(request()->filled('untuk'))

                        <span class="menu-result-context">
                            untuk
                            "<strong>{{ request('untuk') }}</strong>"
                        </span>

                    @endif

                </p>

            </div>
</div>

    </div>

</section>

<section class="menu-list-section paket-list-section">

    <div class="public-container">

        @if($paketBundlings->count() > 0)

            <div class="paket-grid">

                @foreach($paketBundlings as $paket)

                    <article class="public-menu-card paket-card">

                        <a
                            href="{{ route('public.paketbundling.show', $paket->id_paket_bundling) }}"
                            class="menu-image-link"
                            aria-label="Lihat {{ $paket->nama_paket }}"
                        >

                            <div class="public-menu-image-wrapper">

                                <img
                                    src="{{ $resolvePaketImage($paket->gambar) ?: $paketImageFallback }}"
                                    alt="{{ $paket->nama_paket }}"
                                    class="public-menu-image"
                                    loading="lazy"
                                    onerror="
                                        this.onerror=null;
                                        this.src='{{ $paketImageFallback }}';
                                    "
                                >

                                @if($paket->untuk)

                                    <div class="menu-category-position">

                                        <span class="public-menu-category">
                                            {{ $paket->untuk }}
                                        </span>

                                    </div>

                                @endif

                                <div class="menu-image-overlay"></div>

                                <div class="menu-image-view">

                                    <span>
                                        Lihat detail
                                    </span>

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.7"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                                        />
                                    </svg>

                                </div>

                            </div>

                        </a>

                        <div class="menu-card-content paket-card-content">

                            @if($paket->untuk)

                                <div class="menu-card-category">
                                    Paket {{ $paket->untuk }}
                                </div>

                            @else

                                <div class="menu-card-category">
                                    Paket Bundling
                                </div>

                            @endif

                            <h2 class="menu-card-name">

                                <a
                                    href="{{ route('public.paketbundling.show', $paket->id_paket_bundling) }}"
                                >
                                    {{ $paket->nama_paket }}
                                </a>

                            </h2>

                            @if($paket->deskripsi)

                                <p class="menu-card-description">
                                    {{ $paket->deskripsi }}
                                </p>

                            @else

                                <p class="menu-card-description menu-card-description-empty">
                                    Pilihan paket untuk melengkapi pengalaman wisata kamu.
                                </p>

                            @endif

                            <div class="paket-components">

                                @if($paket->menus->count() > 0)

                                    <div class="paket-component-group">

                                        <div class="paket-component-heading">

                                            <span class="paket-component-icon">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.7"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M3.75 6.75h16.5M5.25 6.75v10.5A2.25 2.25 0 0 0 7.5 19.5h9a2.25 2.25 0 0 0 2.25-2.25V6.75"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M8.25 3.75v3M15.75 3.75v3"
                                                    />
                                                </svg>
                                            </span>

                                            <span>
                                                Menu
                                            </span>

                                        </div>

                                        <div class="paket-component-tags">

                                            @foreach($paket->menus->take(3) as $menu)

                                                <span class="paket-component-tag">
                                                    {{ $menu->nama_menu }}
                                                </span>

                                            @endforeach

                                            @if($paket->menus->count() > 3)

                                                <span class="paket-component-tag paket-more-tag">
                                                    +{{ $paket->menus->count() - 3 }}
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                @endif

                                @if($paket->wahanas->count() > 0)

                                    <div class="paket-component-group">

                                        <div class="paket-component-heading">

                                            <span class="paket-component-icon">
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.7"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M8.25 18.75a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm7.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M3.75 15.75V6.75A2.25 2.25 0 0 1 6 4.5h8.25A2.25 2.25 0 0 1 16.5 6.75v9.75M16.5 9h2.25l1.5 2.25v5.25h-3.75"
                                                    />
                                                </svg>
                                            </span>

                                            <span>
                                                Wahana
                                            </span>

                                        </div>

                                        <div class="paket-component-tags">

                                            @foreach($paket->wahanas->take(3) as $wahana)

                                                <span class="paket-component-tag">
                                                    {{ $wahana->nama_wahana }}
                                                </span>

                                            @endforeach

                                            @if($paket->wahanas->count() > 3)

                                                <span class="paket-component-tag paket-more-tag">
                                                    +{{ $paket->wahanas->count() - 3 }}
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                @endif

                            </div>

                            <div class="menu-card-bottom paket-card-bottom">

                                <div class="menu-price-wrapper">

                                    <p class="menu-price-label">
                                        Harga Paket
                                    </p>

                                    <p class="menu-price">
                                        Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                    </p>

                                </div>

                                <div class="menu-card-actions paket-card-actions">

                                    <form
                                        action="{{ route('pesanan.keranjang.tambah') }}"
                                        method="POST"
                                        class="menu-cart-form paket-cart-form"
                                        data-paket-name="{{ $paket->nama_paket }}"
                                    >
                                        @csrf

                                        <input type="hidden" name="type" value="bundling">
                                        <input type="hidden" name="id" value="{{ $paket->id_paket_bundling }}">
                                        <input type="hidden" name="qty" value="1">

                                        <button
                                            type="submit"
                                            class="public-cart-button"
                                            aria-label="Tambah {{ $paket->nama_paket }} ke keranjang"
                                            title="Tambah ke keranjang"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.8"
                                                stroke="currentColor"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.25 3h1.386c.51 0 .955.343 1.084.837L5.74 6.75m0 0h14.51c.64 0 1.127.59.995 1.216l-1.5 7.125a1.125 1.125 0 0 1-1.1.894H8.04a1.125 1.125 0 0 1-1.1-.894L5.74 6.75Zm2.3 12.375a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5Zm9 0a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5Z"
                                                />
                                            </svg>
                                        </button>
                                    </form>

                                    <a
                                        href="{{ route('public.paketbundling.show', $paket->id_paket_bundling) }}"
                                        class="public-detail-button"
                                        aria-label="Lihat {{ $paket->nama_paket }}"
                                        title="Lihat detail"
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
                                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                                            />
                                        </svg>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @else

            <div class="menu-empty-state">

                <div class="menu-empty-icon">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                        />
                    </svg>

                </div>

                <h2>
                    Paket bundling tidak ditemukan
                </h2>

                <p>
                    Tidak ada paket yang sesuai dengan pencarian
                    atau filter yang kamu pilih.
                </p>

                <a
                    href="{{ route('public.paketbundling.index') }}"
                    class="menu-empty-button"
                >
                    Tampilkan Semua Paket
                </a>

            </div>

        @endif

    </div>

</section>

<div class="paket-cart-success-overlay" id="paketCartSuccess">
    <div class="paket-cart-success-popup" role="dialog" aria-modal="true" aria-labelledby="paketCartSuccessTitle">
        <button
            type="button"
            class="paket-cart-success-close"
            id="paketCartSuccessClose"
            aria-label="Tutup"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="paket-cart-success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m5 12.5 4.2 4.2L19 7"/>
            </svg>
        </div>

        <span class="paket-cart-success-eyebrow">Keranjang</span>

        <h2 id="paketCartSuccessTitle">Berhasil Ditambahkan</h2>

        <p>
            <span id="paketCartSuccessItem">Paket</span>
            sudah masuk ke keranjang.
        </p>

        <div class="paket-cart-success-actions">
            <button type="button" class="paket-cart-continue" id="paketCartContinue">
                Lanjut Belanja
            </button>

            <a href="{{ route('pesanan.keranjang') }}" class="paket-cart-view">
                Lihat Keranjang
            </a>
        </div>
    </div>
</div>

<style>

    .menu-hero,
    .menu-filter-section,
    .menu-result-section,
    .menu-list-section {

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

    .menu-hero {

        position: relative;

        overflow: hidden;

        background:
            radial-gradient(
                circle at 15% 25%,
                rgba(226,201,151,.055),
                transparent 32%
            );

    }

    .menu-hero::after {

        content: "";

        position: absolute;

        width: 500px;
        height: 500px;

        top: -300px;
        right: -180px;

        border-radius: 50%;

        background: rgba(226,201,151,.025);

        filter: blur(20px);

        pointer-events: none;

    }

    .menu-hero-inner {

        padding: 64px 0 70px;

    }

    .menu-breadcrumb {

        display: flex;

        align-items: center;

        gap: 10px;

        margin-bottom: 28px;

        font-size: 12px;

    }

    .menu-breadcrumb-link {

        color: var(--text-muted);

        text-decoration: none;

        transition: color var(--transition);

    }

    .menu-breadcrumb-link:hover {

        color: var(--accent);

    }

    .menu-breadcrumb-separator {

        color: var(--text-dim);

    }

    .menu-breadcrumb-current {

        color: var(--text-secondary);

    }

    .menu-eyebrow {

        display: inline-flex;

        align-items: center;

        gap: 10px;

        margin-bottom: 20px;

        padding: 7px 13px;

        border: 1px solid var(--border-gold);

        border-radius: 999px;

        background: rgba(226,201,151,.055);

        color: var(--accent);

        font-size: 10px;

        font-weight: 600;

        letter-spacing: .12em;

        text-transform: uppercase;

    }

    .menu-eyebrow::before {

        content: "";

        width: 5px;
        height: 5px;

        border-radius: 50%;

        background: var(--accent);

        box-shadow:
            0 0 10px rgba(226,201,151,.5);

    }

    .menu-heading {

        max-width: 760px;

    }

    .menu-title {

        margin: 0;

        color: var(--text-primary);

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size: clamp(42px, 6vw, 72px);

        line-height: 1.04;

        font-weight: 700;

        letter-spacing: -.035em;

    }

    .menu-title span {

        display: block;

        color: var(--accent);

        font-style: italic;

    }

    .menu-description {

        max-width: 650px;

        margin-top: 22px;

        color: var(--text-muted);

        font-size: 15px;

        line-height: 1.9;

    }

    .menu-filter-section {

        padding: 0 0 28px;

    }

    .menu-filter-box {

        padding: 18px;

        border: 1px solid var(--border-gold);

        border-radius: 20px;

        background:
            rgba(255,255,255,.025);

        box-shadow: var(--shadow-soft);

    }

    .menu-filter-form {

        display: grid;

        grid-template-columns:
            minmax(0, 1.7fr)
            minmax(180px, 1fr)
            minmax(180px, 1fr)
            auto;

        gap: 12px;

        align-items: end;

    }

    .menu-filter-label {

        display: block;

        margin-bottom: 7px;

        color: var(--text-secondary);

        font-size: 11px;

        font-weight: 600;

        letter-spacing: .02em;

    }

    .menu-form-input {

        width: 100%;

        min-height: 48px;

        padding: 0 15px;

        border: 1px solid var(--border-soft);

        border-radius: 12px;

        outline: none;

        background: rgba(255,255,255,.035);

        color: var(--text-primary);

        font-family: inherit;

        font-size: 13px;

        transition:
            border-color var(--transition),
            background var(--transition),
            box-shadow var(--transition);

    }

    .menu-form-input::placeholder {

        color: var(--text-dim);

    }

    .menu-form-input:hover {

        background:
            rgba(226,201,151,.045);

        border-color:
            var(--border-gold);

    }

    .menu-form-input:focus {

        background:
            rgba(226,201,151,.055);

        border-color:
            var(--accent);

        box-shadow:
            0 0 0 3px rgba(226,201,151,.07);

    }

    .menu-form-input option {

        background:
            var(--bg-card);

        color:
            var(--text-primary);

    }

    .menu-search-wrapper {

        min-width: 0;

    }

    .menu-search {

        position: relative;

    }

    .menu-search-input {

        padding-left: 44px;

        padding-right: 42px;

    }

    .menu-search-icon {

        position: absolute;

        left: 15px;
        top: 50%;

        width: 18px;
        height: 18px;

        transform: translateY(-50%);

        color: var(--text-dim);

        pointer-events: none;

    }

    .menu-clear-search {

        position: absolute;

        top: 50%;
        right: 10px;

        width: 28px;
        height: 28px;

        display: flex;

        align-items: center;
        justify-content: center;

        transform: translateY(-50%);

        border: 0;

        border-radius: 50%;

        background: transparent;

        color: var(--text-dim);

        opacity: 0;

        visibility: hidden;

        cursor: pointer;

        transition:
            color .2s ease,
            background .2s ease,
            opacity .2s ease;

    }

    .menu-clear-search.is-visible {

        opacity: 1;

        visibility: visible;

    }

    .menu-clear-search:hover {

        background:
            rgba(226,201,151,.08);

        color:
            var(--accent);

    }

    .menu-clear-search svg {

        width: 15px;
        height: 15px;

    }

    .menu-auto-filter-hint {

        display: block;

        margin-top: 6px;

        color: var(--text-dim);

        font-size: 9px;

    }

    .menu-select-wrapper {

        position: relative;

    }

    .menu-select-wrapper::after {

        content: "";

        position: absolute;

        top: 50%;
        right: 15px;

        width: 7px;
        height: 7px;

        border-right: 1.5px solid var(--accent);
        border-bottom: 1.5px solid var(--accent);

        transform:
            translateY(-65%)
            rotate(45deg);

        pointer-events: none;

    }

    .menu-select-wrapper select {

        appearance: none;

        -webkit-appearance: none;

        padding-right: 40px;

        cursor: pointer;

    }

    .menu-filter-status {

        min-height: 48px;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 8px;

        padding: 0 13px;

        border: 1px solid rgba(226,201,151,.10);

        border-radius: 12px;

        background:
            rgba(226,201,151,.025);

        color: var(--text-dim);

        font-size: 10px;

        white-space: nowrap;

    }

    .menu-filter-status-dot {

        width: 6px;
        height: 6px;

        border-radius: 50%;

        background: var(--accent);

        box-shadow:
            0 0 10px rgba(226,201,151,.45);

    }

    .menu-result-section {

        padding: 20px 0 25px;

    }

    .menu-result-header {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

    }

    .menu-result-text {

        margin: 0;

        color: var(--text-muted);

        font-size: 13px;

    }

    .menu-result-count {

        margin: 0 4px;

        color: var(--accent);

        font-weight: 700;

    }

    .menu-result-context {

        color: var(--text-dim);

    }

    .menu-result-context strong {

        color: var(--text-secondary);

        font-weight: 600;

    }

    .menu-reset-button {

        display: inline-flex;

        align-items: center;

        gap: 7px;

        color: var(--text-muted);

        font-size: 12px;

        text-decoration: none;

        transition: color var(--transition);

    }

    .menu-reset-button:hover {

        color: var(--accent);

    }

    .menu-reset-button svg {

        width: 15px;
        height: 15px;

    }

    .menu-list-section {

        padding: 0 0 110px;

    }

    .menu-grid {

        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 22px;

    }

    .public-menu-card {

        overflow: hidden;

        display: flex;

        flex-direction: column;

        border: 1px solid var(--border-soft);

        border-radius: 28px;

        background: var(--bg-card);

        transition:
            transform var(--transition),
            border-color var(--transition),
            box-shadow var(--transition),
            background var(--transition);

    }

    .public-menu-card:hover {

        transform: translateY(-7px);

        border-color:
            var(--border-gold-strong);

        background:
            #151515;

        box-shadow:
            var(--shadow-hover);

    }

    .menu-image-link {

        display: block;

        text-decoration: none;

    }

    .public-menu-image-wrapper {

        position: relative;

        width: 100%;

        height: 245px;

        overflow: hidden;

        background:
            var(--bg-soft);

    }

    .public-menu-image {

        width: 100%;
        height: 100%;

        object-fit: cover;

        transition:
            transform .55s cubic-bezier(.2,.7,.2,1),
            filter .4s ease;

    }

    .public-menu-card:hover
    .public-menu-image {

        transform:
            scale(1.055);

        filter:
            saturate(1.04);

    }

    .menu-image-overlay {

        position: absolute;

        inset: 0;

        background:
            linear-gradient(
                to bottom,
                rgba(10,10,10,.05) 0%,
                transparent 45%,
                rgba(10,10,10,.65) 100%
            );

        pointer-events: none;

    }

    .menu-image-view {

        position: absolute;

        left: 50%;
        bottom: 18px;

        display: inline-flex;

        align-items: center;

        gap: 7px;

        padding: 8px 12px;

        border: 1px solid rgba(226,201,151,.30);

        border-radius: 999px;

        background:
            rgba(10,10,10,.72);

        backdrop-filter: blur(10px);

        color: var(--accent);

        font-size: 10px;

        font-weight: 600;

        transform:
            translate(-50%, 10px);

        opacity: 0;

        transition:
            opacity .3s ease,
            transform .3s ease;

        pointer-events: none;

        white-space: nowrap;

    }

    .menu-image-view svg {

        width: 13px;
        height: 13px;

    }

    .public-menu-card:hover
    .menu-image-view {

        opacity: 1;

        transform:
            translate(-50%, 0);

    }

    .menu-category-position {

        position: absolute;

        top: 14px;
        left: 14px;

        z-index: 2;

    }

    .public-menu-category {

        display: inline-flex;

        align-items: center;

        min-height: 28px;

        padding: 0 10px;

        border: 1px solid
            rgba(226,201,151,.25);

        border-radius: 999px;

        background:
            rgba(10,10,10,.72);

        backdrop-filter: blur(10px);

        -webkit-backdrop-filter: blur(10px);

        color: var(--accent);

        font-size: 10px;

        font-weight: 600;

        letter-spacing: .04em;

    }

    .menu-card-content {

        display: flex;

        flex: 1;

        flex-direction: column;

        padding: 21px;

    }

    .menu-card-category {

        margin-bottom: 7px;

        color: var(--accent);

        font-size: 10px;

        font-weight: 600;

        letter-spacing: .10em;

        text-transform: uppercase;

    }

    .menu-card-name {

        margin: 0;

        color: var(--text-primary);

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size: 20px;

        line-height: 1.25;

        font-weight: 700;

    }

    .menu-card-name a {

        color: inherit;

        text-decoration: none;

        transition: color var(--transition);

    }

    .menu-card-name a:hover {

        color: var(--accent);

    }

    .menu-card-description {

        min-height: 48px;

        margin-top: 10px;

        overflow: hidden;

        display: -webkit-box;

        -webkit-line-clamp: 2;

        -webkit-box-orient: vertical;

        color: var(--text-muted);

        font-size: 12px;

        line-height: 1.8;

    }

    .menu-card-description-empty {

        color: var(--text-dim);

        font-style: italic;

    }

    .menu-card-bottom {
        margin-top: auto;
        padding-top: 20px;

        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 14px;

        border-top: 1px solid var(--border-soft);
    }

    .menu-price-wrapper {
        min-width: 0;
        flex: 1;
    }

    .menu-price-label {
        margin: 0 0 3px;
        color: var(--text-dim);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .menu-price {
        margin: 0;
        color: var(--accent);
        font-size: 17px;
        line-height: 1.2;
        font-weight: 700;
        white-space: nowrap;
    }

    .menu-card-actions {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .menu-cart-form {
        margin: 0;
    }

    .public-cart-button,
    .public-detail-button {
        min-height: 42px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 1px solid var(--border-gold);
        border-radius: 12px;

        background: rgba(226,201,151,.07);
        color: var(--accent);

        font-family: inherit;
        font-size: 11px;
        font-weight: 700;

        cursor: pointer;
        text-decoration: none;

        transition:
            background var(--transition),
            border-color var(--transition),
            color var(--transition),
            transform var(--transition),
            box-shadow var(--transition);
    }

    .public-cart-button {
        gap: 7px;
        padding: 0 13px;
        white-space: nowrap;
    }

    .public-cart-button svg {
        width: 17px;
        height: 17px;
        flex-shrink: 0;
    }

    .public-cart-button:hover {
        border-color: var(--accent);
        background: var(--accent);
        color: var(--bg-primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(226,201,151,.12);
    }

    .public-detail-button {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
    }

    .public-detail-button svg {
        width: 18px;
        height: 18px;
        transition: transform var(--transition);
    }

    .public-detail-button:hover {
        border-color: var(--accent);
        background: var(--accent);
        color: var(--bg-primary);
        transform: translateX(3px);
    }

    .public-detail-button:hover svg {
        transform: translateX(2px);
    }

    .menu-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 42px;
    }

    .menu-pagination-pages {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .menu-pagination-button,
    .menu-pagination-page {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-gold);
        border-radius: 12px;
        background: rgba(226,201,151,.045);
        color: var(--text-secondary);
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition:
            background var(--transition),
            border-color var(--transition),
            color var(--transition),
            transform var(--transition);
    }

    .menu-pagination-button svg {
        width: 17px;
        height: 17px;
    }

    .menu-pagination-page:hover,
    .menu-pagination-button:hover {
        border-color: var(--accent);
        background: rgba(226,201,151,.10);
        color: var(--accent);
        transform: translateY(-2px);
    }

    .menu-pagination-page.is-active {
        border-color: var(--accent);
        background: var(--accent);
        color: var(--bg-primary);
        box-shadow: 0 8px 24px rgba(226,201,151,.12);
    }

    .menu-pagination-button.is-disabled {
        opacity: .30;
        cursor: not-allowed;
        pointer-events: none;
    }

    .menu-pagination-info {
        margin: 12px 0 0;
        color: var(--text-dim);
        font-size: 10px;
        text-align: center;
    }

    .menu-empty-state {

        padding: 90px 30px;

        text-align: center;

        border: 1px dashed
            var(--border-gold);

        border-radius: 28px;

        background:
            rgba(255,255,255,.02);

    }

    .menu-empty-icon {

        width: 68px;
        height: 68px;

        margin: 0 auto 22px;

        display: flex;

        align-items: center;
        justify-content: center;

        border: 1px solid
            var(--border-gold);

        border-radius: 20px;

        background:
            rgba(226,201,151,.055);

        color:
            var(--accent);

    }

    .menu-empty-icon svg {

        width: 30px;
        height: 30px;

    }

    .menu-empty-state h2 {

        margin: 0;

        color: var(--text-primary);

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size: 27px;

        font-weight: 700;

    }

    .menu-empty-state p {

        max-width: 420px;

        margin: 9px auto 0;

        color: var(--text-muted);

        font-size: 13px;

        line-height: 1.8;

    }

    .menu-empty-button {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-height: 46px;

        margin-top: 24px;

        padding: 0 20px;

        border: 1px solid
            var(--accent);

        border-radius: 999px;

        background:
            linear-gradient(
                135deg,
                var(--accent),
                var(--accent-hover)
            );

        color:
            var(--bg-primary);

        font-size: 12px;

        font-weight: 700;

        text-decoration: none;

        transition:
            all var(--transition);

    }

    .menu-empty-button:hover {

        background:
            linear-gradient(
                135deg,
                var(--accent-hover),
                var(--accent-dark)
            );

        transform:
            translateY(-2px);

        box-shadow:
            var(--shadow-soft);

    }

    @media (max-width: 1200px) {

        .menu-grid {

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

        }

        .menu-filter-form {

            grid-template-columns:
                minmax(0, 1.5fr)
                minmax(160px, 1fr)
                minmax(160px, 1fr)
                auto;

        }

    }

    @media (max-width: 992px) {

        .menu-grid {

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

        }

        .menu-filter-form {

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

        }

        .menu-search-wrapper {

            grid-column:
                span 2;

        }

        .menu-filter-status {

            grid-column:
                span 2;

        }

    }

    @media (max-width: 768px) {

        .menu-hero-inner {

            padding:
                50px 0 55px;

        }

        .menu-title {

            font-size:
                44px;

        }

        .menu-description {

            font-size:
                13px;

        }

        .menu-list-section {

            padding-bottom:
                80px;

        }

        .public-menu-image-wrapper {

            height:
                225px;

        }

    }

    @media (max-width: 640px) {

        .menu-filter-box {
            padding: 14px;
        }

        .menu-filter-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .menu-search-wrapper,
        .menu-filter-status {
            grid-column: 1 / -1;
        }

        .menu-filter-field {
            min-width: 0;
        }

        .menu-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .public-menu-card {
            width: 100%;
            min-width: 0;
            border-radius: 18px;
        }

        .public-menu-image-wrapper {
            height: 145px;
        }

        .menu-card-content {
            padding: 16px;
        }

        .menu-filter-field .menu-form-input {
            min-height: 46px;
            padding: 0 12px;
            font-size: 12px;
        }

        .menu-card-category {
            margin-bottom: 5px;
            font-size: 9px;
        }

        .menu-card-name {
            font-size: 18px;
            line-height: 1.25;
        }

        .menu-card-description {
            min-height: 42px;
            margin-top: 8px;
            font-size: 11px;
            line-height: 1.65;
        }

        .menu-card-bottom {
            padding-top: 14px;
            gap: 10px;
        }

        .menu-price-label {
            font-size: 9px;
        }

        .menu-price {
            font-size: 15px;
        }

        .menu-card-actions {
            gap: 6px;
        }

        .public-cart-button,
        .public-detail-button {
            min-height: 40px;
            height: 40px;
            border-radius: 11px;
        }

        .public-detail-button {
            width: 40px;
            flex-basis: 40px;
        }

        .public-cart-button {
            width: 40px;
            min-width: 40px;
            padding: 0;
        }

        .public-cart-button span {
            display: none;
        }

        .public-cart-button svg,
        .public-detail-button svg {
            width: 17px;
            height: 17px;
        }

        .menu-title {
            font-size: 39px;
        }

        .menu-result-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .menu-hero-inner {
            padding: 42px 0 48px;
        }

    }

    @media (max-width: 420px) {

        .menu-pagination {
            gap: 7px;
            margin-top: 30px;
        }

        .menu-pagination-pages {
            gap: 5px;
        }

        .menu-pagination-button,
        .menu-pagination-page {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            font-size: 11px;
        }

        .menu-pagination-button svg {
            width: 15px;
            height: 15px;
        }

        .menu-pagination-info {
            font-size: 9px;
        }

        .menu-title {
            font-size: 35px;
        }

        .menu-eyebrow {
            font-size: 9px;
        }

        .menu-grid {
            gap: 10px;
        }

        .public-menu-card {
            width: 100%;
            border-radius: 17px;
        }

        .public-menu-image-wrapper {
            height: 125px;
        }

        .menu-card-content {
            padding: 12px;
        }

        .menu-card-category {
            font-size: 8px;
            margin-bottom: 4px;
        }

        .menu-card-name {
            font-size: 14px;
            line-height: 1.2;
        }

        .menu-card-description {
            font-size: 9.5px;
            line-height: 1.5;
            min-height: 29px;
            margin-top: 6px;
        }

        .menu-card-bottom {
            padding-top: 13px;
            gap: 8px;
        }

        .menu-price {
            font-size: 15px;
        }

        .menu-card-actions {
            gap: 6px;
        }

    }

    @media (max-width: 350px) {

        .menu-pagination {
            gap: 5px;
        }

        .menu-pagination-pages {
            gap: 4px;
        }

        .menu-pagination-button,
        .menu-pagination-page {
            width: 33px;
            height: 33px;
            border-radius: 9px;
            font-size: 10px;
        }

        .menu-pagination-button svg {
            width: 14px;
            height: 14px;
        }

        .menu-grid {
            gap: 8px;
        }

        .public-menu-card {
            width: 100%;
            border-radius: 15px;
        }

        .public-menu-image-wrapper {
            height: 108px;
        }

        .menu-card-content {
            padding: 10px;
        }

        .menu-card-category {
            font-size: 7px;
        }

        .menu-card-name {
            font-size: 13px;
        }

        .menu-card-description {
            font-size: 9px;
            min-height: 27px;
        }

        .menu-card-bottom {
            gap: 7px;
        }

        .menu-price {
            font-size: 14px;
        }

        .menu-card-actions {
            gap: 5px;
        }

        .public-cart-button,
        .public-detail-button {
            min-height: 38px;
            height: 38px;
        }

        .public-cart-button {
            width: 39px;
            min-width: 39px;
        }

        .public-detail-button {
            width: 39px;
            flex-basis: 39px;
        }

        .public-detail-button svg {
            width: 16px;
            height: 16px;
        }
    }

</style>

<style>

    .paket-hero .menu-description {
        max-width: 650px;
    }

    .paket-filter-form {
        grid-template-columns:
            minmax(0, 1.7fr)
            minmax(180px, 1fr)
            minmax(180px, 1fr)
            auto;
    }

    .paket-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }

    .paket-card {
        min-width: 0;
    }

    .paket-card-content {
        min-width: 0;
    }

    .paket-card .public-menu-image-wrapper {
        height: 235px;
    }

    .paket-card .public-menu-image {
        height: 235px;
        object-fit: cover;
    }

    .paket-components {
        display: flex;
        flex-direction: column;
        gap: 11px;

        margin-top: 14px;
    }

    .paket-component-group {
        min-width: 0;
    }

    .paket-component-heading {
        display: flex;
        align-items: center;
        gap: 7px;

        margin-bottom: 7px;

        color: var(--text-secondary);

        font-size: 10px;
        font-weight: 600;
        letter-spacing: .02em;
    }

    .paket-component-icon {
        width: 26px;
        height: 26px;

        flex: 0 0 auto;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 1px solid var(--border-gold);
        border-radius: 8px;

        background: rgba(226,201,151,.045);
        color: var(--accent);
    }

    .paket-component-icon svg {
        width: 14px;
        height: 14px;
    }

    .paket-component-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .paket-component-tag {
        display: inline-flex;
        align-items: center;

        max-width: 100%;
        min-width: 0;

        padding: 5px 8px;

        border: 1px solid var(--border-soft);
        border-radius: 8px;

        background: rgba(255,255,255,.025);
        color: var(--text-muted);

        font-size: 9px;
        line-height: 1.35;

        transition:
            border-color var(--transition),
            color var(--transition),
            background var(--transition);
    }

    .paket-card:hover .paket-component-tag {
        border-color: rgba(226,201,151,.10);
    }

    .paket-card-bottom {
        margin-top: 18px;
    }

    .paket-cart-form .public-cart-button {
        width: 42px;
        min-width: 42px;
        height: 42px;
        min-height: 42px;
        padding: 0;
        gap: 0;
    }

    .paket-cart-form .public-cart-button svg {
        width: 18px;
        height: 18px;
    }

    .paket-cart-form .public-cart-button:disabled {
        opacity: .55;
        cursor: wait;
        transform: none;
    }

    .paket-cart-form .public-cart-button.is-loading svg {
        animation: paketCartSpin .7s linear infinite;
    }

    @keyframes paketCartSpin {
        to {
            transform: rotate(360deg);
        }
    }

    .paket-cart-success-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0, 0, 0, .72);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity .25s ease, visibility .25s ease;
    }

    .paket-cart-success-overlay.is-visible {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .paket-cart-success-popup {
        position: relative;
        width: min(100%, 420px);
        padding: 32px 30px 28px;
        text-align: center;
        border: 1px solid var(--border-gold-strong);
        border-radius: 24px;
        background:
            radial-gradient(circle at 50% 0%, rgba(226,201,151,.09), transparent 42%),
            #121212;
        box-shadow: 0 30px 90px rgba(0,0,0,.55);
        transform: translateY(14px) scale(.98);
        transition: transform .25s ease;
    }

    .paket-cart-success-overlay.is-visible .paket-cart-success-popup {
        transform: translateY(0) scale(1);
    }

    .paket-cart-success-close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-soft);
        border-radius: 50%;
        background: rgba(255,255,255,.035);
        color: var(--text-dim);
        cursor: pointer;
        transition: all var(--transition);
    }

    .paket-cart-success-close:hover {
        border-color: var(--border-gold);
        color: var(--accent);
        background: rgba(226,201,151,.07);
    }

    .paket-cart-success-close svg {
        width: 15px;
        height: 15px;
    }

    .paket-cart-success-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-gold-strong);
        border-radius: 18px;
        background: rgba(226,201,151,.08);
        color: var(--accent);
    }

    .paket-cart-success-icon svg {
        width: 27px;
        height: 27px;
    }

    .paket-cart-success-eyebrow {
        display: block;
        margin-bottom: 7px;
        color: var(--accent);
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .paket-cart-success-popup h2 {
        margin: 0;
        color: var(--text-primary);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 25px;
        line-height: 1.2;
        font-weight: 700;
    }

    .paket-cart-success-popup p {
        margin: 9px auto 0;
        max-width: 320px;
        color: var(--text-muted);
        font-size: 12px;
        line-height: 1.7;
    }

    #paketCartSuccessItem {
        color: var(--text-secondary);
        font-weight: 600;
    }

    .paket-cart-success-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
        margin-top: 24px;
    }

    .paket-cart-continue,
    .paket-cart-view {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 15px;
        border-radius: 12px;
        font-family: inherit;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all var(--transition);
    }

    .paket-cart-continue {
        border: 1px solid var(--border-gold);
        background: rgba(226,201,151,.06);
        color: var(--accent);
    }

    .paket-cart-continue:hover {
        border-color: var(--accent);
        background: rgba(226,201,151,.12);
        transform: translateY(-1px);
    }

    .paket-cart-view {
        border: 1px solid var(--accent);
        background: linear-gradient(135deg, var(--accent), var(--accent-hover));
        color: var(--bg-primary);
    }

    .paket-cart-view:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 28px rgba(226,201,151,.14);
    }

    @media (max-width: 1100px) {

        .paket-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 900px) {

        .paket-filter-form {
            grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 1fr);
        }

        .paket-search-field {
            grid-column: 1 / -1;
        }

    }

    @media (max-width: 640px) {

        .paket-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .paket-card .public-menu-image-wrapper,
        .paket-card .public-menu-image {
            height: 145px;
        }

        .paket-card .menu-card-content {
            padding: 13px;
        }

        .paket-card .menu-card-category {
            font-size: 8px;
            margin-bottom: 5px;
        }

        .paket-card .menu-card-name {
            font-size: 15px;
        }

        .paket-card .menu-card-description {
            min-height: 0;
            margin-top: 7px;
            font-size: 9.5px;
            line-height: 1.55;
        }

        .paket-components {
            gap: 8px;
            margin-top: 10px;
        }

        .paket-component-heading {
            font-size: 8px;
            margin-bottom: 5px;
        }

        .paket-component-icon {
            width: 22px;
            height: 22px;
            border-radius: 6px;
        }

        .paket-component-icon svg {
            width: 12px;
            height: 12px;
        }

        .paket-component-tag {
            padding: 4px 6px;
            font-size: 7.5px;
        }

        .paket-card-bottom {
            margin-top: 12px;
            padding-top: 12px;
            gap: 7px;
        }

        .paket-card .menu-price-label {
            font-size: 8px;
        }

        .paket-card .menu-price {
            font-size: 13px;
        }

        .paket-card .public-detail-button {
            width: 38px;
            height: 38px;
            min-height: 38px;
        }

    }

    @media (max-width: 430px) {

        .paket-grid {
            gap: 10px;
        }

        .paket-card .public-menu-image-wrapper,
        .paket-card .public-menu-image {
            height: 125px;
        }

        .paket-card .menu-card-content {
            padding: 11px;
        }

        .paket-card .menu-card-name {
            font-size: 14px;
        }

        .paket-card .menu-card-description {
            font-size: 9px;
        }

        .paket-component-tag {
            font-size: 7px;
            padding: 3px 5px;
        }

    }

    @media (max-width: 360px) {

        .paket-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .paket-card .public-menu-image-wrapper,
        .paket-card .public-menu-image {
            height: 180px;
        }

    }

<style>
.paket-grid{
    align-items:stretch;
    grid-auto-rows:1fr;
}

.paket-card{
    height:100%;
    min-height:100%;
    display:flex;
    flex-direction:column;
}

.paket-card .menu-image-link{
    flex:0 0 auto;
}

.paket-card .paket-card-content{
    flex:1 1 auto;
    min-height:0;
    display:flex;
    flex-direction:column;
}

.paket-card .menu-card-category{
    min-height:15px;
}

.paket-card .menu-card-name{
    min-height:50px;
    max-height:50px;
    overflow:hidden;
    display:-webkit-box;
    -webkit-box-orient:vertical;
    -webkit-line-clamp:2;
    line-height:1.25;
}

.paket-card .menu-card-description{
    min-height:43px;
    max-height:43px;
    overflow:hidden;
    display:-webkit-box;
    -webkit-box-orient:vertical;
    -webkit-line-clamp:2;
    line-height:1.8;
}

.paket-card .paket-components{
    min-height:170px;
    max-height:170px;
    overflow:hidden;
    display:flex;
    flex-direction:column;
    gap:10px;
}

.paket-card .paket-component-group{
    min-height:80px;
    max-height:80px;
    overflow:hidden;
}

.paket-card .paket-component-heading{
    min-height:26px;
}

.paket-card .paket-component-tags{
    height:49px;
    max-height:49px;
    overflow:hidden;
    align-content:flex-start;
}

.paket-card .paket-component-tag{
    max-width:100%;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.paket-card .paket-more-tag{
    color:var(--accent);
    border-color:rgba(226,201,151,.22);
    background:rgba(226,201,151,.08);
    font-weight:700;
}

.paket-card .paket-card-bottom{
    margin-top:auto;
    min-height:78px;
    flex:0 0 78px;
    display:flex;
    align-items:flex-end;
}

.paket-card .menu-price-wrapper{
    min-width:0;
}

.paket-card .menu-price{
    white-space:nowrap;
}

@media (max-width:1100px){
    .paket-card .paket-components{
        min-height:170px;
        max-height:170px;
    }
}

@media (max-width:640px){
    .paket-grid{
        grid-auto-rows:1fr;
        align-items:stretch;
    }

    .paket-card .menu-card-name{
        min-height:38px;
        max-height:38px;
        font-size:15px;
    }

    .paket-card .menu-card-description{
        min-height:30px;
        max-height:30px;
        line-height:1.55;
    }

    .paket-card .paket-components{
        min-height:134px;
        max-height:134px;
        gap:6px;
    }

    .paket-card .paket-component-group{
        min-height:64px;
        max-height:64px;
    }

    .paket-card .paket-component-heading{
        min-height:22px;
        margin-bottom:4px;
    }

    .paket-card .paket-component-tags{
        height:39px;
        max-height:39px;
    }

    .paket-card .paket-card-bottom{
        min-height:66px;
        flex-basis:66px;
    }
}

@media (max-width:360px){
    .paket-grid{
        grid-template-columns:1fr;
    }

    .paket-card .paket-components{
        min-height:150px;
        max-height:150px;
    }

    .paket-card .paket-component-group{
        min-height:72px;
        max-height:72px;
    }

    .paket-card .paket-component-tags{
        height:45px;
        max-height:45px;
    }
}
</style>

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('search');
    const clearSearch = document.getElementById('clearSearch');
    const form = document.getElementById('paketFilterForm');

    if (!form) {
        return;
    }

    if (searchInput && clearSearch) {

        function updateClearButton() {
            clearSearch.classList.toggle(
                'is-visible',
                searchInput.value.trim().length > 0
            );
        }

        searchInput.addEventListener('input', updateClearButton);

        clearSearch.addEventListener('click', function () {
            searchInput.value = '';
            updateClearButton();
            searchInput.focus();
            form.submit();
        });

        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                form.submit();
            }
        });

    }

    form.querySelectorAll('.menu-auto-submit').forEach(function (select) {
        select.addEventListener('change', function () {
            form.submit();
        });
    });

    const cartOverlay = document.getElementById('paketCartSuccess');
    const cartClose = document.getElementById('paketCartSuccessClose');
    const cartContinue = document.getElementById('paketCartContinue');
    const cartItem = document.getElementById('paketCartSuccessItem');

    function closeCartPopup() {
        if (cartOverlay) {
            cartOverlay.classList.remove('is-visible');
            document.body.style.overflow = '';
        }
    }

    function openCartPopup(name) {
        if (!cartOverlay) {
            return;
        }

        if (cartItem) {
            cartItem.textContent = name || 'Paket';
        }

        cartOverlay.classList.add('is-visible');
        document.body.style.overflow = 'hidden';
    }

    document.querySelectorAll('.paket-cart-form').forEach(function (cartForm) {

        cartForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            const button = cartForm.querySelector('button[type="submit"]');
            const itemName = cartForm.dataset.paketName || 'Paket';

            if (button) {
                button.disabled = true;
                button.classList.add('is-loading');
            }

            try {
                const response = await fetch(cartForm.action, {
                    method: 'POST',
                    body: new FormData(cartForm),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html,application/xhtml+xml'
                    },
                    redirect: 'follow'
                });

                if (!response.ok) {
                    throw new Error('Gagal menambahkan ke keranjang.');
                }

                await response.text();

                openCartPopup(itemName);

            } catch (error) {
                console.error(error);
                alert('Paket gagal ditambahkan ke keranjang. Silakan coba lagi.');
            } finally {
                if (button) {
                    button.disabled = false;
                    button.classList.remove('is-loading');
                }
            }
        });

    });

    if (cartClose) {
        cartClose.addEventListener('click', closeCartPopup);
    }

    if (cartContinue) {
        cartContinue.addEventListener('click', closeCartPopup);
    }

    if (cartOverlay) {
        cartOverlay.addEventListener('click', function (event) {
            if (event.target === cartOverlay) {
                closeCartPopup();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && cartOverlay?.classList.contains('is-visible')) {
            closeCartPopup();
        }
    });

});
</script>

@endsection
