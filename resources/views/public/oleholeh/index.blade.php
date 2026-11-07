@extends('public.layouts.app')

@section('title', 'Oleh-Oleh')

@section('content')

<section class="menu-hero">
    <div class="public-container">
        <div class="menu-hero-inner">

            <div class="menu-breadcrumb">
                <a href="{{ route('public.home') }}" class="menu-breadcrumb-link">
                    Home
                </a>

                <span class="menu-breadcrumb-separator">/</span>

                <span class="menu-breadcrumb-current">
                    Oleh-Oleh
                </span>
            </div>

            <div class="menu-heading">

                <span class="menu-eyebrow">
                    Oleh-Oleh Khas Noyo Gimbal
                </span>

                <h1 class="menu-title">
                    Bawa Pulang
                    <span>Kenangan</span>
                </h1>

                <p class="menu-description">
                    Temukan berbagai pilihan oleh-oleh yang tersedia di Noyo Gimbal
                    untuk dibawa pulang dan menjadi bagian dari kenangan perjalananmu.
                </p>

            </div>

        </div>
    </div>
</section>

<section class="menu-filter-section">

    <div class="public-container">

        <div class="menu-filter-box">

            <form
                id="olehOlehFilterForm"
                action="{{ route('public.oleholeh.index') }}"
                method="GET"
                class="menu-filter-form"
            >

                <div class="menu-search-wrapper">

                    <label for="search" class="menu-filter-label">
                        Cari oleh-oleh
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
                                d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                            />
                        </svg>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama atau jenis oleh-oleh..."
                            class="menu-form-input menu-search-input"
                            autocomplete="off"
                        >

                        <button
                            type="button"
                            id="clearOlehOlehSearch"
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

                <div class="menu-filter-field">

                    <label for="jenis" class="menu-filter-label">
                        Jenis
                    </label>

                    <div class="menu-select-wrapper">

                        <select
                            id="jenis"
                            name="jenis"
                            class="menu-form-input menu-auto-submit"
                        >
                            <option value="">
                                Semua Jenis
                            </option>

                            @foreach([
                                'Totebag',
                                'Baju',
                                'Celana',
                                'Topi',
                                'Gantungan Kunci',
                                'Ikat Rambut',
                                'Kacamata',
                                'Daster',
                                'Sandal',
                                'Pajangan Tumbuhan',
                                'Barongan'
                            ] as $jenis)
                                <option
                                    value="{{ $jenis }}"
                                    @selected(request('jenis') === $jenis)
                                >
                                    {{ $jenis }}
                                </option>
                            @endforeach

                        </select>

                    </div>
                </div>

                <div class="menu-filter-field">

                    <label for="sort" class="menu-filter-label">
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

<section class="menu-result-section">

    <div class="public-container">

        <div class="menu-result-header">

            <div>

                <p class="menu-result-text">

                    Menampilkan

                    <span class="menu-result-count">
                        {{ $olehOleh->count() }}
                    </span>

                    oleh-oleh

        </div>

    </div>

</section>

<section class="menu-list-section">

    <div class="public-container">

        @if($olehOleh->isNotEmpty())

            <div class="menu-grid">

                @foreach($olehOleh as $item)

                    <article class="public-menu-card">

                        <a
                            href="{{ route('public.oleholeh.show', $item->id_oleh_oleh) }}"
                            class="menu-image-link"
                            aria-label="Lihat {{ $item->nama }}"
                        >

                            <div class="public-menu-image-wrapper">

                                <img
                                    src="{{ !empty($item->gambar) ? (filter_var($item->gambar, FILTER_VALIDATE_URL) ? $item->gambar : asset('storage/' . ltrim(preg_replace('#^storage/#', '', $item->gambar), '/'))) : asset('images/no-image.png') }}"
                                    alt="{{ $item->nama }}"
                                    class="public-menu-image"
                                    loading="lazy"
                                    decoding="async"
                                    onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';this.classList.add('image-fallback');"
                                >

                                @if($item->jenis)

                                    <div class="menu-category-position">

                                        <span class="public-menu-category">
                                            {{ $item->jenis }}
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

                        <div class="menu-card-content">

                            @if($item->jenis)

                                <div class="menu-card-category">
                                    {{ $item->jenis }}
                                </div>

                            @endif

                            <h2 class="menu-card-name">

                                <a
                                    href="{{ route('public.oleholeh.show', $item->id_oleh_oleh) }}"
                                >
                                    {{ $item->nama }}
                                </a>

                            </h2>

                            @if($item->deskripsi)

                                <p class="menu-card-description">
                                    {{ $item->deskripsi }}
                                </p>

                            @else

                                <p class="menu-card-description menu-card-description-empty">
                                    Tidak ada deskripsi.
                                </p>

                            @endif

                            <div class="menu-card-bottom">

                                <div class="menu-price-wrapper">

                                    <p class="menu-price-label">
                                        Harga
                                    </p>

                                    <p class="menu-price">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </p>

                                </div>

                                <div class="menu-card-actions">

                                    @if($item->stok > 0)

                                        <form
                                            action="{{ route('pesanan.keranjang.tambah') }}"
                                            method="POST"
                                            class="menu-cart-form"
                                        >
                                            @csrf

                                            <input
                                                type="hidden"
                                                name="type"
                                                value="oleh_oleh"
                                            >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="{{ $item->id_oleh_oleh }}"
                                            >

                                            <input
                                                type="hidden"
                                                name="qty"
                                                value="1"
                                            >

                                            <button
                                                type="submit"
                                                class="public-cart-button"
                                                aria-label="Tambah {{ $item->nama }} ke keranjang"
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

                                                <span>
                                                    Tambah
                                                </span>

                                            </button>

                                        </form>

                                    @else

                                        <span
                                            class="public-cart-button is-out-of-stock"
                                            title="Stok habis"
                                            aria-label="Stok {{ $item->nama }} habis"
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
                                                    d="M2.25 3h1.386c.51 0 .955.343 1.084.837L5.74 6.75m0 0h14.51c.64 0 1.127.59.995 1.216l-1.5 7.125a1.125 1.125 0 0 1-1.1.894H8.04a1.125 1.125 0 0 1-1.1-.894L5.74 6.75Zm2.3 12.375a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5Zm9 0a.75.75 0 1 0 0 1.5.75.75 0 0 0-0 1.5Z"
                                                />
                                            </svg>

                                            <span>
                                                Habis
                                            </span>
                                        </span>

                                    @endif

                                    <a
                                        href="{{ route('public.oleholeh.show', $item->id_oleh_oleh) }}"
                                        class="public-detail-button"
                                        aria-label="Lihat {{ $item->nama }}"
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

                            <div class="oleh-stock-line">
                                <span class="oleh-stock-dot {{ $item->stok > 0 ? 'is-available' : 'is-empty' }}"></span>
                                <span class="oleh-stock-text">
                                    {{ $item->stok > 0 ? 'Stok tersedia' : 'Stok habis' }}
                                </span>

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
                    Oleh-oleh tidak ditemukan
                </h2>

                <p>
                    Tidak ada oleh-oleh yang sesuai dengan pencarian
                    atau filter yang kamu pilih.
                </p>

                <a
                    href="{{ route('public.oleholeh.index') }}"
                    class="menu-empty-button"
                >
                    Tampilkan Semua Oleh-Oleh
                </a>

            </div>

        @endif

    </div>

</section>

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
            minmax(180px, 1fr);

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
.menu-list-section {

        padding: 0 0 110px;

    }

    .menu-grid {
        min-width: 0;
        display: grid;

        grid-template-columns:
            repeat(4, minmax(0, 1fr));

        gap: 22px;

    }

    .public-menu-card {
        min-width: 0;
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
        overflow-wrap: anywhere;
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

    .menu-image-link:focus-visible,
    .menu-card-name a:focus-visible,
    .public-cart-button:focus-visible,
    .public-detail-button:focus-visible,
    .menu-empty-button:focus-visible {
        outline: 2px solid var(--accent);
        outline-offset: 3px;
    }

    @media (prefers-reduced-motion: reduce) {
        .menu-hero *,
        .menu-filter-section *,
        .menu-result-section *,
        .menu-list-section *,
        .public-footer *,
        .oleh-cart-popup * {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            scroll-behavior: auto !important;
            transition-duration: .01ms !important;
        }
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
                minmax(180px, 1fr);

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

        .menu-search-wrapper {
            grid-column: 1 / -1;
            min-width: 0;
        }

        .menu-filter-field {
            grid-column: span 1;
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

.public-footer {
    --footer-bg: #0a0a0a;
    --footer-text: #f8f4ed;
    --footer-muted: #8b8174;
    --footer-dim: #625a50;
    --footer-gold: #e2c997;
    --footer-gold-dark: #b89a6e;
    --footer-border: rgba(226, 201, 151, .13);

    position: relative;
    width: 100%;
    margin-top: clamp(48px, 6vw, 90px);
    background:
        radial-gradient(
            circle at 85% 10%,
            rgba(226, 201, 151, .075),
            transparent 28%
        ),
        radial-gradient(
            circle at 10% 90%,
            rgba(226, 201, 151, .035),
            transparent 25%
        ),
        var(--footer-bg);
    border-top: 1px solid rgba(226, 201, 151, .10);
    overflow: hidden;
}

.public-footer::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 1px;
    background: linear-gradient(
        90deg,
        transparent 0%,
        rgba(226, 201, 151, .12) 15%,
        rgba(226, 201, 151, .70) 50%,
        rgba(226, 201, 151, .12) 85%,
        transparent 100%
    );
}

.public-footer::after {
    content: "";
    position: absolute;
    width: clamp(280px, 35vw, 500px);
    height: clamp(280px, 35vw, 500px);
    right: clamp(-280px, -18vw, -120px);
    bottom: clamp(-340px, -22vw, -180px);
    border-radius: 50%;
    background: rgba(226, 201, 151, .025);
    filter: blur(25px);
    pointer-events: none;
}

.public-footer .public-container {
    width: min(
        calc(100% - clamp(28px, 5vw, 64px)),
        1280px
    );
    margin-inline: auto;
}

.footer-main {
    position: relative;
    z-index: 2;

    display: grid;
    grid-template-columns:
        minmax(260px, 1.65fr)
        minmax(135px, .78fr)
        minmax(135px, .78fr)
        minmax(220px, 1fr);

    gap: clamp(28px, 4vw, 64px);

    padding:
        clamp(54px, 6vw, 86px)
        0
        clamp(42px, 5vw, 64px);
}

.footer-brand {
    max-width: 420px;
    min-width: 0;
}

.footer-logo {
    display: inline-flex;
    align-items: center;
    gap: clamp(10px, 1vw, 14px);
    max-width: 100%;
    color: var(--footer-text);
    text-decoration: none;
}

.footer-logo-mark {
    width: clamp(42px, 3.2vw, 50px);
    height: clamp(42px, 3.2vw, 50px);
    display: grid;
    place-items: center;
    flex: 0 0 auto;

    border: 1px solid rgba(226, 201, 151, .30);
    border-radius: clamp(12px, 1vw, 14px);

    background:
        linear-gradient(
            145deg,
            rgba(226, 201, 151, .14),
            rgba(226, 201, 151, .025)
        );

    color: var(--footer-gold);

    font-family:
        "Playfair Display",
        Georgia,
        serif;

    font-size: clamp(13px, 1vw, 15px);
    font-weight: 700;
    letter-spacing: .04em;

    box-shadow:
        inset 0 0 20px rgba(226, 201, 151, .025),
        0 10px 35px rgba(0, 0, 0, .25);

    transition:
        transform .25s ease,
        border-color .25s ease,
        background .25s ease;
}

.footer-logo:hover .footer-logo-mark {
    transform: translateY(-3px);
    border-color: rgba(226, 201, 151, .65);
    background:
        linear-gradient(
            145deg,
            rgba(226, 201, 151, .20),
            rgba(226, 201, 151, .045)
        );
}

.footer-logo-text {
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.footer-logo-name {
    color: var(--footer-text);
    font-size: clamp(13px, 1vw, 15px);
    font-weight: 700;
    letter-spacing: .10em;
    line-height: 1.3;
    white-space: nowrap;
}

.footer-logo-tagline {
    margin-top: 5px;
    color: #8d806f;
    font-size: clamp(6px, .55vw, 8px);
    font-weight: 600;
    letter-spacing: .16em;
    line-height: 1.3;
}

.footer-description {
    max-width: 390px;
    margin: clamp(17px, 1.8vw, 22px) 0 0;
    color: #968b7d;
    font-size: clamp(11px, .82vw, 12px);
    line-height: 1.85;
}

.footer-column {
    min-width: 0;
}

.footer-heading {
    position: relative;
    display: inline-block;
    margin: 0 0 clamp(18px, 1.8vw, 22px);
    color: #f0eadf;
    font-size: clamp(12px, .9vw, 13px);
    font-weight: 700;
    letter-spacing: .02em;
}

.footer-heading::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -8px;
    width: 24px;
    height: 1px;
    background: var(--footer-gold);
}

.footer-links {
    display: flex;
    flex-direction: column;
    gap: 2px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.footer-links li {
    margin: 0;
    padding: 0;
}

.footer-links li a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    width: 100%;
    padding: clamp(6px, .55vw, 8px) 0;

    color: var(--footer-muted);
    font-size: clamp(11px, .82vw, 12px);
    line-height: 1.55;
    text-decoration: none;

    transition:
        color .25s ease,
        transform .25s ease;
}

.footer-links li a:hover {
    color: var(--footer-gold);
    transform: translateX(4px);
}

.footer-link-arrow {
    flex: 0 0 auto;
    color: #5d554b;
    font-size: 12px;
    opacity: 0;
    transform: translateX(-5px);
    transition:
        opacity .25s ease,
        transform .25s ease,
        color .25s ease;
}

.footer-links li a:hover .footer-link-arrow {
    color: var(--footer-gold);
    opacity: 1;
    transform: translateX(0);
}

.footer-cta {
    position: relative;
    min-width: 0;
    padding: clamp(21px, 2vw, 28px);

    border: 1px solid var(--footer-border);
    border-radius: clamp(18px, 1.6vw, 22px);

    background:
        linear-gradient(
            145deg,
            rgba(226, 201, 151, .065),
            rgba(255, 255, 255, .018)
        );

    box-shadow: 0 20px 60px rgba(0, 0, 0, .20);
    overflow: hidden;
}

.footer-cta::before {
    content: "";
    position: absolute;
    top: -70px;
    right: -70px;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: rgba(226, 201, 151, .055);
    filter: blur(3px);
    pointer-events: none;
}

.footer-eyebrow {
    position: relative;
    display: block;
    margin-bottom: 12px;
    color: var(--footer-gold-dark);
    font-size: clamp(7px, .6vw, 8px);
    font-weight: 700;
    letter-spacing: .20em;
}

.footer-cta h3 {
    position: relative;
    max-width: 260px;
    margin: 0;
    color: var(--footer-text);

    font-family:
        "Playfair Display",
        Georgia,
        serif;

    font-size: clamp(22px, 1.8vw, 28px);
    font-weight: 500;
    line-height: 1.25;
}

.footer-cta h3 span {
    color: var(--footer-gold);
    font-style: italic;
}

.footer-cta-description {
    position: relative;
    max-width: 290px;
    margin: 14px 0 0;
    color: #8e8375;
    font-size: clamp(10px, .75vw, 11px);
    line-height: 1.8;
}

.footer-action {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;

    margin-top: 20px;
    min-height: 40px;
    padding: 10px 17px;

    border: 1px solid rgba(226, 201, 151, .25);
    border-radius: 999px;

    background: rgba(226, 201, 151, .08);
    color: var(--footer-gold);

    font-size: clamp(10px, .75vw, 11px);
    font-weight: 700;
    letter-spacing: .02em;
    text-decoration: none;

    transition:
        background .25s ease,
        border-color .25s ease,
        transform .25s ease,
        box-shadow .25s ease;
}

.footer-action:hover {
    border-color: rgba(226, 201, 151, .60);
    background: rgba(226, 201, 151, .15);
    color: var(--footer-text);
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, .30);
}

.footer-action-icon {
    font-size: 14px;
    line-height: 1;
    transition: transform .25s ease;
}

.footer-action:hover .footer-action-icon {
    transform: translateX(4px);
}

.footer-divider {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: clamp(12px, 1.5vw, 18px);
    width: 100%;
}

.footer-divider > span {
    flex: 1;
    min-width: 0;
    height: 1px;
    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(226, 201, 151, .13)
        );
}

.footer-divider > span:last-child {
    background:
        linear-gradient(
            90deg,
            rgba(226, 201, 151, .13),
            transparent
        );
}

.footer-divider-mark {
    width: 32px;
    height: 32px;
    display: grid;
    place-items: center;
    flex: 0 0 auto;

    border: 1px solid rgba(226, 201, 151, .22);
    border-radius: 50%;
    background: var(--footer-bg);
    color: #a98b62;

    font-family:
        "Playfair Display",
        Georgia,
        serif;

    font-size: 8px;
    font-weight: 700;
    letter-spacing: .04em;
}

.footer-bottom {
    position: relative;
    z-index: 2;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;

    padding:
        clamp(18px, 1.8vw, 23px)
        0
        clamp(20px, 2vw, 27px);
}

.footer-copyright {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    color: var(--footer-dim);
    font-size: clamp(9px, .7vw, 10px);
    line-height: 1.6;
}

.footer-copyright-dot {
    color: #9a815c;
}

.footer-bottom-links {
    color: var(--footer-dim);
    font-size: clamp(9px, .7vw, 10px);
    text-align: right;
}

@media (min-width: 1440px) {
    .public-footer .public-container {
        width: min(calc(100% - 80px), 1320px);
    }

    .footer-main {
        grid-template-columns:
            minmax(300px, 1.7fr)
            minmax(155px, .8fr)
            minmax(155px, .8fr)
            minmax(250px, 1fr);
        gap: 64px;
    }
}

@media (max-width: 1180px) {
    .public-footer .public-container {
        width: min(calc(100% - 40px), 1080px);
    }

    .footer-main {
        grid-template-columns:
            minmax(240px, 1.45fr)
            minmax(130px, .75fr)
            minmax(130px, .75fr);
        gap: 34px;
    }

    .footer-cta {
        grid-column: 1 / -1;

        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: center;
        gap: 24px;
    }

    .footer-cta-description {
        max-width: 520px;
    }

    .footer-action {
        margin-top: 0;
    }
}

@media (max-width: 900px) {
    .public-footer .public-container {
        width: min(calc(100% - 32px), 760px);
    }

    .footer-main {
        grid-template-columns: 1.15fr .85fr;
        gap: 32px 28px;
        padding: 54px 0 44px;
    }

    .footer-brand,
    .footer-cta {
        grid-column: 1 / -1;
    }

    .footer-brand {
        max-width: 680px;
    }

    .footer-description {
        max-width: 620px;
    }

    .footer-cta {
        display: block;
    }

    .footer-cta-description {
        max-width: 100%;
    }

    .footer-action {
        margin-top: 19px;
    }
}

@media (max-width: 700px) {
    .public-footer {
        margin-top: 50px;
    }

    .public-footer .public-container {
        width: calc(100% - 30px);
    }

    .footer-main {
        grid-template-columns: 1fr 1fr;
        gap: 30px 22px;
        padding: 48px 0 38px;
    }

    .footer-brand,
    .footer-cta {
        grid-column: 1 / -1;
    }

    .footer-logo {
        gap: 12px;
    }

    .footer-logo-mark {
        width: 44px;
        height: 44px;
        border-radius: 13px;
    }

    .footer-description {
        margin-top: 17px;
        font-size: 11.5px;
        line-height: 1.8;
    }

    .footer-heading {
        margin-bottom: 18px;
    }

    .footer-links {
        gap: 2px;
    }

    .footer-links li a {
        padding: 6px 0;
        font-size: 11.5px;
    }

    .footer-cta {
        padding: 23px;
        border-radius: 19px;
    }

    .footer-cta h3 {
        font-size: 24px;
    }

    .footer-bottom {
        align-items: flex-start;
        flex-direction: column;
        gap: 8px;
        padding: 20px 0 22px;
    }

    .footer-bottom-links {
        text-align: left;
    }
}

@media (max-width: 430px) {
    .public-footer .public-container {
        width: calc(100% - 24px);
    }

    .footer-main {
        grid-template-columns: 1fr;
        gap: 27px;
        padding: 42px 0 32px;
    }

    .footer-brand,
    .footer-cta {
        grid-column: auto;
    }

    .footer-column {
        width: 100%;
    }

    .footer-links li a {
        padding: 7px 0;
    }

    .footer-cta {
        padding: 21px;
    }

    .footer-cta h3 {
        font-size: 22px;
    }

    .footer-action {
        width: 100%;
    }

    .footer-divider {
        gap: 12px;
    }
}

@media (max-width: 360px) {
    .public-footer .public-container {
        width: calc(100% - 20px);
    }

    .footer-main {
        gap: 24px;
        padding-top: 38px;
    }

    .footer-logo {
        gap: 10px;
    }

    .footer-logo-mark {
        width: 40px;
        height: 40px;
        border-radius: 12px;
    }

    .footer-logo-name {
        font-size: 12px;
    }

    .footer-logo-tagline {
        font-size: 6px;
    }

    .footer-description {
        font-size: 11px;
    }

    .footer-copyright {
        display: block;
    }

    .footer-copyright-dot {
        display: none;
    }
}

@media (hover: none) {
    .footer-links li a:hover,
    .footer-action:hover,
    .footer-logo:hover .footer-logo-mark {
        transform: none;
    }

    .footer-link-arrow {
        opacity: .55;
        transform: none;
    }
}

@media (prefers-reduced-motion: reduce) {
    .public-footer *,
    .public-footer *::before,
    .public-footer *::after {
        scroll-behavior: auto !important;
        transition-duration: .01ms !important;
        animation-duration: .01ms !important;
        animation-iteration-count: 1 !important;
    }
}

    .menu-filter-form {
        grid-template-columns:
            minmax(0, 1.7fr)
            minmax(180px, 1fr)
            minmax(180px, 1fr) !important;
    }

    @media (max-width: 1200px) {
        .menu-filter-form {
            grid-template-columns:
                minmax(0, 1.5fr)
                minmax(160px, 1fr)
                minmax(160px, 1fr) !important;
        }
    }

    @media (max-width: 992px) {
        .menu-filter-form {
            grid-template-columns:
                repeat(2, minmax(0, 1fr)) !important;
        }

        .menu-search-wrapper {
            grid-column: span 2 !important;
        }
    }

    @media (max-width: 640px) {
        .menu-filter-form {
            grid-template-columns:
                repeat(2, minmax(0, 1fr)) !important;
            gap: 10px !important;
        }

        .menu-search-wrapper {
            grid-column: 1 / -1 !important;
        }
    }

    .oleh-stock-line {
        margin-top: 14px;
    }

    @media (max-width: 640px) {
        .oleh-stock-line {
            margin-top: 10px;
        }
    }

    .oleh-cart-popup {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(0,0,0,.68);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity .25s ease, visibility .25s ease;
    }

    .oleh-cart-popup.is-visible {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .oleh-cart-popup-card {
        width: min(430px, 100%);
        padding: 34px 28px 25px;
        border: 1px solid rgba(226,201,151,.25);
        border-radius: 24px;
        background: #121212;
        box-shadow: 0 30px 90px rgba(0,0,0,.55);
        text-align: center;
        transform: translateY(12px) scale(.98);
        transition: transform .28s ease;
    }

    .oleh-cart-popup.is-visible .oleh-cart-popup-card {
        transform: translateY(0) scale(1);
    }

    .oleh-cart-popup-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(226,201,151,.3);
        border-radius: 18px;
        background: rgba(226,201,151,.08);
        color: #e2c997;
    }

    .oleh-cart-popup-icon svg {
        width: 28px;
        height: 28px;
    }

    .oleh-cart-popup-title {
        margin: 0;
        color: #f8f4ed;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 24px;
        font-weight: 700;
    }

    .oleh-cart-popup-text {
        margin: 9px auto 0;
        max-width: 330px;
        color: #a89988;
        font-size: 12px;
        line-height: 1.7;
    }

    .oleh-cart-popup-actions {
        display: flex;
        gap: 9px;
        margin-top: 23px;
    }

    .oleh-cart-popup-button {
        flex: 1;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 15px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: transform .2s ease, background .2s ease, border-color .2s ease;
    }

    .oleh-cart-popup-button:hover {
        transform: translateY(-2px);
    }

    .oleh-cart-popup-button.secondary {
        border: 1px solid rgba(226,201,151,.20);
        background: rgba(255,255,255,.035);
        color: #d4c9b5;
    }

    .oleh-cart-popup-button.secondary:hover {
        border-color: rgba(226,201,151,.35);
        background: rgba(255,255,255,.06);
        color: #e2c997;
    }

    .oleh-cart-popup-button.primary {
        border: 1px solid #e2c997;
        background: #e2c997;
        color: #0a0a0a;
    }

    .oleh-cart-popup-button.primary:hover {
        border-color: #d4b384;
        background: #d4b384;
    }

    .public-cart-button.is-out-of-stock {
        opacity: .45;
        cursor: not-allowed;
        pointer-events: none;
    }

    .oleh-stock-line {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid rgba(255,255,255,.06);
    }

    .oleh-stock-dot {
        width: 5px;
        height: 5px;
        flex: 0 0 5px;
        border-radius: 50%;
    }

    .oleh-stock-dot.is-available {
        background: #e2c997;
        box-shadow: 0 0 8px rgba(226,201,151,.35);
    }

    .oleh-stock-dot.is-empty {
        background: rgba(255,255,255,.25);
    }

    .oleh-stock-text {
        color: rgba(255,255,255,.48);
        font-size: 10px;
    }

    .public-menu-image.image-fallback {
        object-fit: contain;
        padding: 28px;
        opacity: .55;
    }

    .public-menu-card,
    .menu-card-content,
    .menu-card-bottom,
    .menu-price-wrapper {
        min-width: 0;
    }

    .menu-card-description {
        overflow-wrap: anywhere;
    }

    .public-cart-button.is-loading {
        opacity: .65;
        pointer-events: none;
    }

    .public-cart-button.is-added {
        border-color: #e2c997;
        background: #e2c997;
        color: #0a0a0a;
    }

    @media (max-width: 480px) {
        .oleh-cart-popup {
            padding: 16px;
        }

        .oleh-cart-popup-card {
            padding: 25px 19px 20px;
            border-radius: 20px;
        }

        .oleh-cart-popup-title {
            font-size: 21px;
        }

        .oleh-cart-popup-actions {
            flex-direction: column-reverse;
        }

        .oleh-cart-popup-button {
            width: 100%;
        }
    }
</style>

<div
    id="olehCartPopup"
    class="oleh-cart-popup"
    aria-hidden="true"
>
    <div
        class="oleh-cart-popup-card"
        role="dialog"
        aria-modal="true"
        aria-labelledby="olehCartPopupTitle"
        aria-describedby="olehCartPopupText"
    >

        <div class="oleh-cart-popup-icon">
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
                    d="m5 12 4 4L19 6"
                />
            </svg>
        </div>

        <h3
            id="olehCartPopupTitle"
            class="oleh-cart-popup-title"
        >
            Berhasil Ditambahkan
        </h3>

        <p
            id="olehCartPopupText"
            class="oleh-cart-popup-text"
        >
            Pesanan sudah masuk ke keranjang.
        </p>

        <div class="oleh-cart-popup-actions">

            <button
                type="button"
                id="olehCartPopupClose"
                class="oleh-cart-popup-button secondary"
            >
                Lanjut Belanja
            </button>

            <a
                href="{{ route('pesanan.keranjang') }}"
                class="oleh-cart-popup-button primary"
            >
                Lihat Keranjang
            </a>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('olehOlehFilterForm');

    if (form) {

        const search = form.querySelector('[name="search"]');
        const jenis = form.querySelector('[name="jenis"]');
        const sort = form.querySelector('[name="sort"]');
        const clearSearch = document.getElementById('clearOlehOlehSearch');

        let timer = null;

        function submitFilter() {
            form.submit();
        }

        if (jenis) {
            jenis.addEventListener('change', submitFilter);
        }

        if (sort) {
            sort.addEventListener('change', submitFilter);
        }

        if (search) {

            search.addEventListener('input', function () {
                const hasValue = search.value.trim().length > 0;

                if (clearSearch) {
                    clearSearch.classList.toggle('is-visible', hasValue);
                }

                clearTimeout(timer);
                timer = setTimeout(submitFilter, 500);
            });

            search.addEventListener('keydown', function (event) {

                if (event.key === 'Enter') {

                    event.preventDefault();

                    clearTimeout(timer);

                    submitFilter();

                }

            });

        }

        if (clearSearch) {

            clearSearch.addEventListener('click', function () {

                if (search) {
                    search.value = '';
                }

                clearSearch.classList.remove('is-visible');

                submitFilter();

            });

        }

    }

    const cartForms = document.querySelectorAll('.menu-cart-form');
    const popup = document.getElementById('olehCartPopup');
    const popupText = document.getElementById('olehCartPopupText');
    const popupClose = document.getElementById('olehCartPopupClose');

    if (!cartForms.length || !popup) {
        return;
    }

    let popupTimer = null;
    let previousFocus = null;
    let previousBodyOverflow = '';

    function showCartPopup(itemName) {

        if (popupText) {
            popupText.textContent = itemName
                ? itemName + ' sudah masuk ke keranjang.'
                : 'Pesanan sudah masuk ke keranjang.';
        }

        previousFocus = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        popup.classList.add('is-visible');
        popup.setAttribute('aria-hidden', 'false');

        document.body.style.overflow = 'hidden';

        if (popupClose) {
            popupClose.focus();
        }

        clearTimeout(popupTimer);

        popupTimer = setTimeout(function () {
            hideCartPopup();
        }, 4500);

    }

    function hideCartPopup() {

        clearTimeout(popupTimer);

        popup.classList.remove('is-visible');
        popup.setAttribute('aria-hidden', 'true');

        document.body.style.overflow = previousBodyOverflow;

        if (previousFocus && typeof previousFocus.focus === 'function') {
            previousFocus.focus();
        }

    }

    if (popupClose) {
        popupClose.addEventListener('click', hideCartPopup);
    }

    popup.addEventListener('click', function (event) {

        if (event.target === popup) {
            hideCartPopup();
        }

    });

    popup.addEventListener('keydown', function (event) {
        if (event.key !== 'Tab') return;

        const focusable = Array.from(popup.querySelectorAll(
            'button:not([disabled]), a[href], [tabindex]:not([tabindex="-1"])'
        )).filter(function (element) {
            return element.offsetParent !== null;
        });

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
    });

    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape' &&
            popup.classList.contains('is-visible')
        ) {
            hideCartPopup();
        }

    });

    cartForms.forEach(function (form) {

        form.addEventListener('submit', async function (event) {

            event.preventDefault();

            const button =
                form.querySelector('.public-cart-button');

            if (
                !button ||
                button.classList.contains('is-loading')
            ) {
                return;
            }

            const originalHTML = button.innerHTML;

            const card =
                form.closest('.public-menu-card');

            const nameElement =
                card
                    ? card.querySelector('.menu-card-name a')
                    : null;

            const itemName =
                nameElement
                    ? nameElement.textContent.trim()
                    : '';

            button.classList.add('is-loading');
            button.innerHTML = '<span>Menambahkan...</span>';

            try {

                const response = await fetch(
                    form.action,
                    {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html, application/xhtml+xml'
                        },
                        credentials: 'same-origin'
                    }
                );

                const contentType = response.headers.get('content-type') || '';
                let requestSucceeded = false;

                if (response.ok && contentType.includes('application/json')) {
                    const result = await response.json();
                    requestSucceeded = result.success === true || result.status === 'success';
                } else if (response.ok && response.redirected) {
                    const finalUrl = new URL(response.url, window.location.href);
                    requestSucceeded = finalUrl.pathname.toLowerCase().includes('keranjang');
                }

                if (!requestSucceeded) {
                    throw new Error('Pesanan belum berhasil ditambahkan.');
                }

                button.classList.remove('is-loading');
                button.classList.add('is-added');
                button.innerHTML = '<span>✓ Ditambahkan</span>';

                showCartPopup(itemName);

                setTimeout(function () {

                    button.classList.remove('is-added');
                    button.innerHTML = originalHTML;

                }, 1800);

            } catch (error) {

                button.classList.remove('is-loading');
                button.innerHTML = originalHTML;

                window.alert(
                    'Pesanan belum berhasil ditambahkan. Silakan coba lagi.'
                );

                console.error(
                    'Add to cart error:',
                    error
                );

            }

        });

    });

});
</script>

@endsection
