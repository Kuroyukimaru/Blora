@extends('public.layouts.app')

@section('title', 'Event')

@section('content')

{{-- ============================================================
     EVENT PAGE
     NOYO GIMBAL
     STYLE DISESUAIKAN DENGAN MENU
     ============================================================ --}}

<section class="event-hero">
    <div class="public-container">
        <div class="event-hero-inner">

            <div class="event-breadcrumb">
                <a href="{{ route('public.home') }}" class="event-breadcrumb-link">Home</a>
                <span class="event-breadcrumb-separator">/</span>
                <span class="event-breadcrumb-current">Event</span>
            </div>

            <div class="event-heading">
                <span class="event-eyebrow">AGENDA & KEGIATAN</span>

                <h1 class="event-title">
                    Temukan
                    <span>Event Noyo Gimbal</span>
                </h1>

                <p class="event-description">
                    Temukan berbagai event dan kegiatan menarik yang akan
                    berlangsung di Noyo Gimbal.
                </p>
            </div>

        </div>
    </div>
</section>


{{-- ============================================================
     FILTER
     SEARCH OTOMATIS + FILTER OTOMATIS
     ============================================================ --}}

<section class="event-filter-section">
    <div class="public-container">

        <div class="event-filter-box">
            <form
                id="eventFilterForm"
                action="{{ route('public.event.index') }}"
                method="GET"
                class="event-filter-form"
            >

                {{-- SEARCH --}}
                <div class="event-search-wrapper">
                    <label for="eventSearch" class="event-filter-label">
                        Cari event
                    </label>

                    <div class="event-search">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="event-search-icon"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                            />
                        </svg>

                        <input
                            type="text"
                            id="eventSearch"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama event..."
                            class="event-form-input event-search-input"
                            autocomplete="off"
                        >

                        <button
                            type="button"
                            id="eventClearSearch"
                            class="event-clear-search {{ request('search') ? 'is-visible' : '' }}"
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


                {{-- TAMPILKAN --}}
                <div class="event-filter-field">
                    <label for="eventFilter" class="event-filter-label">
                        Tampilkan
                    </label>

                    <div class="event-select-wrapper">
                        <select
                            name="filter"
                            id="eventFilter"
                            class="event-form-input event-auto-submit"
                        >
                            <option
                                value="semua"
                                @selected(request('filter', 'semua') === 'semua')
                            >
                                Semua Event
                            </option>

                            <option
                                value="hari_ini"
                                @selected(request('filter') === 'hari_ini')
                            >
                                Hari Ini
                            </option>

                            <option
                                value="mendatang"
                                @selected(request('filter') === 'mendatang')
                            >
                                Event Mendatang
                            </option>
                        </select>
                    </div>
                </div>


                {{-- URUTKAN --}}
                <div class="event-filter-field">
                    <label for="eventSort" class="event-filter-label">
                        Urutkan
                    </label>

                    <div class="event-select-wrapper">
                        <select
                            name="sort"
                            id="eventSort"
                            class="event-form-input event-auto-submit"
                        >
                            <option
                                value="tanggal_asc"
                                @selected(request('sort', 'tanggal_asc') === 'tanggal_asc')
                            >
                                Terdekat
                            </option>

                            <option
                                value="tanggal_desc"
                                @selected(request('sort') === 'tanggal_desc')
                            >
                                Terjauh
                            </option>

                            <option
                                value="terbaru"
                                @selected(request('sort') === 'terbaru')
                            >
                                Terbaru Ditambahkan
                            </option>
                        </select>
                    </div>
                </div>

            </form>
        </div>

    </div>
</section>


{{-- ============================================================
     RESULT
     ============================================================ --}}

<section class="event-result-section">
    <div class="public-container">

        <div class="event-result-header">
            <p class="event-result-text">
                Menampilkan
                <span class="event-result-count">
                    {{ method_exists($events, 'total') ? $events->total() : $events->count() }}
                </span>
                event

                @if(request()->filled('search'))
                    <span class="event-result-context">
                        untuk "<strong>{{ request('search') }}</strong>"
                    </span>
                @elseif(request('filter') === 'hari_ini')
                    <span class="event-result-context">
                        untuk hari ini
                    </span>
                @elseif(request('filter') === 'mendatang')
                    <span class="event-result-context">
                        mendatang
                    </span>
                @endif
            </p>

            @if(
                request()->filled('search') ||
                request('filter', 'semua') !== 'semua' ||
                request('sort', 'tanggal_asc') !== 'tanggal_asc'
            )
                <a
                    href="{{ route('public.event.index') }}"
                    class="event-reset-button"
                >
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
                            d="M6 18 18 6M6 6l12 12"
                        />
                    </svg>
                    Reset filter
                </a>
            @endif
        </div>

    </div>
</section>


{{-- ============================================================
     EVENT LIST
     ============================================================ --}}

<section class="event-list-section">
    <div class="public-container">

        @if($events->isNotEmpty())

            <div class="event-grid">

                @foreach($events as $event)

                    @php
                        $eventDate = \Carbon\Carbon::parse($event->tanggal);
                        $isToday = $eventDate->isToday();
                    @endphp

                    <article class="event-card">

                        <a
                            href="{{ route('public.event.show', $event->id_event) }}"
                            class="event-image-link"
                            aria-label="Lihat {{ $event->judul }}"
                        >
                            <div class="event-image-wrapper">

                                <img
                                    src="{{ $event->gambar_url }}"
                                    alt="{{ $event->judul }}"
                                    class="event-image"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                                >

                                <div class="event-image-overlay"></div>

                                <div class="event-date-badge">
                                    <span class="event-date-day">
                                        {{ $eventDate->format('d') }}
                                    </span>

                                    <span class="event-date-month">
                                        {{ strtoupper($eventDate->translatedFormat('M')) }}
                                    </span>
                                </div>

                                @if($isToday)
                                    <span class="event-today-badge">
                                        HARI INI
                                    </span>
                                @endif

                                <div class="event-image-view">
                                    <span>Lihat detail</span>

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


                        <div class="event-card-content">

                            <div class="event-card-category">
                                EVENT
                            </div>

                            <h2 class="event-card-name">
                                <a href="{{ route('public.event.show', $event->id_event) }}">
                                    {{ $event->judul }}
                                </a>
                            </h2>

                            <div class="event-card-date">
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
                                        d="M6.75 3v3m10.5-3v3M3.75 9.25h16.5M5.25 5.25h13.5a1.5 1.5 0 0 1 1.5 1.5v12a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5v-12a1.5 1.5 0 0 1 1.5-1.5Z"
                                    />
                                </svg>

                                <span>
                                    {{ $eventDate->translatedFormat('l') }},
                                    {{ $eventDate->format('d M Y') }}
                                </span>
                            </div>

                            @if($event->deskripsi)
                                <p class="event-card-description">
                                    {{ \Illuminate\Support\Str::limit($event->deskripsi, 95) }}
                                </p>
                            @else
                                <p class="event-card-description event-card-description-empty">
                                    Tidak ada deskripsi.
                                </p>
                            @endif


                            <div class="event-card-bottom">

                                <div class="event-card-info">
                                    <span class="event-info-label">Tanggal</span>
                                    <span class="event-info-value">
                                        {{ $eventDate->format('d M Y') }}
                                    </span>
                                </div>

                                <a
                                    href="{{ route('public.event.show', $event->id_event) }}"
                                    class="event-detail-button"
                                    aria-label="Lihat {{ $event->judul }}"
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

                    </article>

                @endforeach

            </div>

            @if(method_exists($events, 'hasPages') && $events->hasPages())
                <div class="event-pagination">
                    {{ $events->appends(request()->query())->links() }}
                </div>
            @endif

        @else

            <div class="event-empty-state">

                <div class="event-empty-icon">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <rect x="3" y="4" width="18" height="17" rx="2"/>
                        <path d="M16 2v4"/>
                        <path d="M8 2v4"/>
                        <path d="M3 10h18"/>
                        <path d="M8 14h.01"/>
                        <path d="M12 14h.01"/>
                        <path d="M16 14h.01"/>
                        <path d="M8 18h.01"/>
                        <path d="M12 18h.01"/>
                    </svg>
                </div>

                <h2>Event tidak ditemukan</h2>

                @if(request('search'))
                    <p>
                        Tidak ditemukan event yang sesuai dengan pencarian
                        "{{ request('search') }}".
                    </p>
                @else
                    <p>
                        Saat ini belum ada event yang dapat ditampilkan.
                        Silakan cek kembali nanti.
                    </p>
                @endif

                <a
                    href="{{ route('public.event.index') }}"
                    class="event-empty-button"
                >
                    Tampilkan Semua Event
                </a>

            </div>

        @endif

    </div>
</section>


@push('styles')
<style>
/* ============================================================
   EVENT DESIGN — MENYAMAKAN MENU
   ============================================================ */

.event-hero,
.event-filter-section,
.event-result-section,
.event-list-section {

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


/* ============================================================
   HERO
   ============================================================ */

.event-hero {
    position: relative;
    overflow: hidden;
    background:
        radial-gradient(
            circle at 15% 25%,
            rgba(226,201,151,.055),
            transparent 32%
        );
}

.event-hero::after {
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

.event-hero-inner {
    padding: 64px 0 70px;
}

.event-breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 28px;
    font-size: 12px;
}

.event-breadcrumb-link {
    color: var(--text-muted);
    text-decoration: none;
    transition: color var(--transition);
}

.event-breadcrumb-link:hover {
    color: var(--accent);
}

.event-breadcrumb-separator {
    color: var(--text-dim);
}

.event-breadcrumb-current {
    color: var(--text-secondary);
}

.event-heading {
    max-width: 760px;
}

.event-eyebrow {
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

.event-eyebrow::before {
    content: "";
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: var(--accent);
    box-shadow: 0 0 10px rgba(226,201,151,.5);
}

.event-title {
    margin: 0;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(42px, 6vw, 72px);
    line-height: 1.04;
    font-weight: 700;
    letter-spacing: -.035em;
}

.event-title span {
    display: block;
    color: var(--accent);
    font-style: italic;
}

.event-description {
    max-width: 650px;
    margin-top: 22px;
    color: var(--text-muted);
    font-size: 15px;
    line-height: 1.9;
}


/* ============================================================
   FILTER — TANPA BUTTON TERAPKAN
   ============================================================ */

.event-filter-section {
    padding: 0 0 28px;
}

.event-filter-box {
    padding: 18px;
    border: 1px solid var(--border-gold);
    border-radius: 20px;
    background: rgba(255,255,255,.025);
    box-shadow: var(--shadow-soft);
}

.event-filter-form {
    display: grid;
    grid-template-columns:
        minmax(0, 1.7fr)
        minmax(180px, 1fr)
        minmax(180px, 1fr);
    gap: 12px;
    align-items: end;
}

.event-filter-label {
    display: block;
    margin-bottom: 7px;
    color: var(--text-secondary);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .02em;
}

.event-search-wrapper {
    min-width: 0;
}

.event-search {
    position: relative;
}

.event-form-input {
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
    box-sizing: border-box;
}

.event-form-input::placeholder {
    color: var(--text-dim);
}

.event-form-input:hover {
    background: rgba(226,201,151,.045);
    border-color: var(--border-gold);
}

.event-form-input:focus {
    background: rgba(226,201,151,.055);
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(226,201,151,.07);
}

.event-form-input option {
    background: var(--bg-card);
    color: var(--text-primary);
}

.event-search-input {
    padding-left: 44px;
    padding-right: 42px;
}

.event-search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    width: 18px;
    height: 18px;
    transform: translateY(-50%);
    color: var(--text-dim);
    pointer-events: none;
}

.event-clear-search {
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

.event-clear-search.is-visible {
    opacity: 1;
    visibility: visible;
}

.event-clear-search:hover {
    background: rgba(226,201,151,.08);
    color: var(--accent);
}

.event-clear-search svg {
    width: 15px;
    height: 15px;
}

.event-select-wrapper {
    position: relative;
}

.event-select-wrapper::after {
    content: "";
    position: absolute;
    top: 50%;
    right: 15px;
    width: 7px;
    height: 7px;
    border-right: 1.5px solid var(--accent);
    border-bottom: 1.5px solid var(--accent);
    transform: translateY(-65%) rotate(45deg);
    pointer-events: none;
}

.event-select-wrapper select {
    appearance: none;
    -webkit-appearance: none;
    padding-right: 40px;
    cursor: pointer;
}


/* ============================================================
   RESULT
   ============================================================ */

.event-result-section {
    padding: 0 0 28px;
}

.event-result-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.event-result-text {
    margin: 0;
    color: var(--text-muted);
    font-size: 13px;
}

.event-result-count {
    margin: 0 4px;
    color: var(--accent);
    font-weight: 700;
}

.event-result-context {
    color: var(--text-dim);
}

.event-result-context strong {
    color: var(--text-secondary);
    font-weight: 600;
}

.event-reset-button {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--text-muted);
    font-size: 12px;
    text-decoration: none;
    transition: color var(--transition);
}

.event-reset-button:hover {
    color: var(--accent);
}

.event-reset-button svg {
    width: 15px;
    height: 15px;
}


/* ============================================================
   GRID — SAMA SEPERTI MENU
   ============================================================ */

.event-list-section {
    padding: 0 0 110px;
}

.event-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
}


/* ============================================================
   CARD
   ============================================================ */

.event-card {
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-width: 0;
    border: 1px solid var(--border-soft);
    border-radius: 28px;
    background: var(--bg-card);
    transition:
        transform var(--transition),
        border-color var(--transition),
        box-shadow var(--transition),
        background var(--transition);
}

.event-card:hover {
    transform: translateY(-7px);
    border-color: var(--border-gold-strong);
    background: #151515;
    box-shadow: var(--shadow-hover);
}

.event-image-link {
    display: block;
    text-decoration: none;
}

.event-image-wrapper {
    position: relative;
    width: 100%;
    height: 245px;
    overflow: hidden;
    background: var(--bg-soft);
}

.event-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition:
        transform .55s cubic-bezier(.2,.7,.2,1),
        filter .4s ease;
}

.event-card:hover .event-image {
    transform: scale(1.055);
    filter: saturate(1.04);
}

.event-image-overlay {
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

.event-date-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    width: 58px;
    height: 62px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(226,201,151,.28);
    border-radius: 13px;
    background: rgba(10,10,10,.76);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.event-date-day {
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 21px;
    line-height: 1;
    font-weight: 700;
}

.event-date-month {
    margin-top: 5px;
    color: var(--accent);
    font-size: 8px;
    font-weight: 700;
    letter-spacing: .10em;
}

.event-today-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    padding: 7px 10px;
    border: 1px solid rgba(226,201,151,.28);
    border-radius: 999px;
    background: rgba(10,10,10,.76);
    color: var(--accent);
    font-size: 8px;
    font-weight: 700;
    letter-spacing: .10em;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.event-image-view {
    position: absolute;
    left: 50%;
    bottom: 14px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 11px;
    border: 1px solid rgba(226,201,151,.28);
    border-radius: 999px;
    background: rgba(10,10,10,.72);
    color: var(--accent);
    font-size: 9px;
    font-weight: 600;
    letter-spacing: .04em;
    opacity: 0;
    transform: translate(-50%, 6px);
    transition:
        opacity var(--transition),
        transform var(--transition);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.event-image-view svg {
    width: 13px;
    height: 13px;
}

.event-card:hover .event-image-view {
    opacity: 1;
    transform: translate(-50%, 0);
}


/* ============================================================
   CARD CONTENT — POLA MENU
   ============================================================ */

.event-card-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 17px;
}

.event-card-category {
    margin-bottom: 5px;
    color: var(--accent);
    font-size: 9px;
    font-weight: 600;
    letter-spacing: .12em;
    text-transform: uppercase;
}

.event-card-name {
    margin: 0;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 20px;
    line-height: 1.25;
    font-weight: 700;
}

.event-card-name a {
    color: inherit;
    text-decoration: none;
}

.event-card-date {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 9px;
    color: var(--text-dim);
    font-size: 10px;
    line-height: 1.5;
}

.event-card-date svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    color: var(--accent);
}

.event-card-description {
    display: -webkit-box;
    overflow: hidden;
    min-height: 42px;
    margin: 9px 0 0;
    color: var(--text-muted);
    font-size: 11px;
    line-height: 1.65;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.event-card-description-empty {
    color: var(--text-dim);
}

.event-card-bottom {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 10px;
    margin-top: auto;
    padding-top: 14px;
}

.event-card-info {
    min-width: 0;
}

.event-info-label {
    display: block;
    color: var(--text-dim);
    font-size: 9px;
}

.event-info-value {
    display: block;
    margin-top: 3px;
    color: var(--text-secondary);
    font-size: 11px;
    font-weight: 600;
}

.event-detail-button {
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border-gold);
    border-radius: 12px;
    background: rgba(226,201,151,.045);
    color: var(--accent);
    text-decoration: none;
    transition: all var(--transition);
}

.event-detail-button svg {
    width: 17px;
    height: 17px;
}

.event-detail-button:hover,
.event-card:hover .event-detail-button {
    background: var(--accent);
    border-color: var(--accent);
    color: var(--bg-primary);
}


/* ============================================================
   PAGINATION
   ============================================================ */

.event-pagination {
    margin-top: 35px;
}

.event-pagination nav {
    display: flex;
    justify-content: center;
}


/* ============================================================
   EMPTY
   ============================================================ */

.event-empty-state {
    padding: 70px 25px;
    border: 1px dashed var(--border-gold);
    border-radius: 24px;
    text-align: center;
    background: rgba(255,255,255,.015);
}

.event-empty-icon {
    width: 68px;
    height: 68px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    border: 1px solid var(--border-gold);
    border-radius: 20px;
    background: rgba(226,201,151,.045);
    color: var(--accent);
}

.event-empty-icon svg {
    width: 35px;
    height: 35px;
}

.event-empty-state h2 {
    margin: 0;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 28px;
    line-height: 1.2;
    font-weight: 700;
}

.event-empty-state p {
    max-width: 500px;
    margin: 10px auto 0;
    color: var(--text-muted);
    font-size: 13px;
    line-height: 1.8;
}

.event-empty-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    margin-top: 22px;
    padding: 0 18px;
    border: 1px solid var(--accent);
    border-radius: 999px;
    background: rgba(226,201,151,.055);
    color: var(--accent);
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    transition: all var(--transition);
}

.event-empty-button:hover {
    background: var(--accent);
    color: var(--bg-primary);
    transform: translateY(-2px);
}


/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 1200px) {

    .event-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .event-filter-form {
        grid-template-columns:
            minmax(0, 1.5fr)
            minmax(160px, 1fr)
            minmax(160px, 1fr);
    }
}


@media (max-width: 992px) {

    .event-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    /* TABLET:
       SEARCH FULL WIDTH
       TAMPILKAN + URUTKAN KANAN-KIRI */
    .event-filter-form {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .event-search-wrapper {
        grid-column: 1 / -1;
    }
}


@media (max-width: 768px) {

    .event-hero-inner {
        padding: 50px 0 55px;
    }

    .event-title {
        font-size: 44px;
    }

    .event-description {
        font-size: 13px;
    }

    .event-list-section {
        padding-bottom: 80px;
    }

    .event-image-wrapper {
        height: 225px;
    }
}


@media (max-width: 640px) {

    .event-filter-box {
        padding: 14px;
    }

    /* HP:
       SEARCH FULL
       TAMPILKAN + URUTKAN KANAN-KIRI */
    .event-filter-form {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .event-search-wrapper {
        grid-column: 1 / -1;
    }

    .event-filter-field {
        min-width: 0;
    }

    /* EVENT CARD TETAP 2 KANAN-KIRI SEPERTI MENU */
    .event-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .event-card {
        width: 100%;
        min-width: 0;
        border-radius: 18px;
    }

    .event-image-wrapper {
        height: 145px;
    }

    .event-card-content {
        padding: 16px;
    }

    .event-form-input {
        min-height: 46px;
        padding-left: 12px;
        padding-right: 12px;
        font-size: 12px;
    }

    .event-search-input {
        padding-left: 42px;
        padding-right: 38px;
    }

    .event-card-category {
        margin-bottom: 5px;
        font-size: 8px;
    }

    .event-card-name {
        font-size: 18px;
        line-height: 1.25;
    }

    .event-card-date {
        margin-top: 7px;
        font-size: 9px;
    }

    .event-card-description {
        min-height: 42px;
        margin-top: 8px;
        font-size: 10px;
        line-height: 1.55;
    }

    .event-card-bottom {
        padding-top: 13px;
        gap: 8px;
    }

    .event-info-label {
        font-size: 8px;
    }

    .event-info-value {
        font-size: 10px;
    }

    .event-detail-button {
        width: 40px;
        height: 40px;
        flex-basis: 40px;
        border-radius: 11px;
    }

    .event-detail-button svg {
        width: 17px;
        height: 17px;
    }

    .event-title {
        font-size: 39px;
    }

    .event-eyebrow {
        font-size: 9px;
    }

    .event-result-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .event-hero-inner {
        padding: 42px 0 48px;
    }
}


@media (max-width: 420px) {

    .event-title {
        font-size: 35px;
    }

    .event-grid {
        gap: 10px;
    }

    .event-card {
        border-radius: 17px;
    }

    .event-image-wrapper {
        height: 125px;
    }

    .event-card-content {
        padding: 12px;
    }

    .event-card-category {
        font-size: 7px;
        margin-bottom: 4px;
    }

    .event-card-name {
        font-size: 14px;
        line-height: 1.2;
    }

    .event-card-date {
        font-size: 8.5px;
    }

    .event-card-description {
        font-size: 9px;
        min-height: 29px;
        line-height: 1.5;
        margin-top: 6px;
    }

    .event-card-bottom {
        gap: 7px;
    }

    .event-info-label {
        font-size: 7px;
    }

    .event-info-value {
        font-size: 9px;
    }

    .event-detail-button {
        width: 39px;
        height: 39px;
        flex-basis: 39px;
    }

    .event-detail-button svg {
        width: 16px;
        height: 16px;
    }
}


@media (max-width: 350px) {

    .event-grid {
        gap: 8px;
    }

    .event-card {
        border-radius: 15px;
    }

    .event-image-wrapper {
        height: 108px;
    }

    .event-card-content {
        padding: 10px;
    }

    .event-card-category {
        font-size: 6.5px;
    }

    .event-card-name {
        font-size: 13px;
    }

    .event-card-description {
        font-size: 8.5px;
        min-height: 27px;
    }

    .event-card-bottom {
        gap: 6px;
    }

    .event-detail-button {
        width: 38px;
        height: 38px;
        flex-basis: 38px;
    }
}
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('eventFilterForm');
    const search = document.getElementById('eventSearch');
    const clearSearch = document.getElementById('eventClearSearch');
    const autoFields = document.querySelectorAll('.event-auto-submit');

    if (!form) return;

    let searchTimer = null;

    function submitEventFilter() {
        clearTimeout(searchTimer);
        form.submit();
    }

    /* Select langsung menjalankan filter */
    autoFields.forEach(function (field) {
        field.addEventListener('change', function () {
            submitEventFilter();
        });
    });

    /* Search otomatis setelah user berhenti mengetik */
    if (search) {

        search.addEventListener('input', function () {

            if (clearSearch) {
                clearSearch.classList.toggle(
                    'is-visible',
                    search.value.trim() !== ''
                );
            }

            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                form.submit();
            }, 450);
        });

        /* Enter tetap bisa langsung mencari */
        search.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                submitEventFilter();
            }
        });
    }

    /* Tombol X mengosongkan search lalu langsung filter */
    if (clearSearch && search) {
        clearSearch.addEventListener('click', function () {
            search.value = '';
            clearSearch.classList.remove('is-visible');
            submitEventFilter();
        });
    }

});
</script>
@endpush

@endsection
