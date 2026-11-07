@extends('public.layouts.app')

@section('title', 'Home')

@section('content')

@php
    $tiketWahanas = collect($tiketWahanas ?? [])->sortByDesc('harga')->take(4)->values();
    $paketBundlings = collect($paketBundlings ?? [])->sortByDesc('harga')->take(4)->values();
    $olehOleh = collect($olehOleh ?? [])->sortByDesc('harga')->take(4)->values();
    $events = collect($events ?? []);
@endphp

<section class="home-hero">

    <div class="hero-background">
        <video
            class="hero-video"
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
            aria-hidden="true"
        >
            <source src="{{ asset('video/noyo.mp4') }}" type="video/mp4">
        </video>
    </div>

    <div class="hero-overlay"></div>

    <div class="hero-content public-container">

        <span class="hero-eyebrow">
            WISATA • KULINER • PENGALAMAN
        </span>

        <h1>
            Nikmati Serunya
            <span>Noyo Gimbal</span>
        </h1>

        <p>
            Jelajahi paket wisata, wahana, oleh-oleh,
            dan event menarik dalam satu tempat.
        </p>

        <div class="hero-actions">
            <a href="{{ route('public.paketbundling.index') }}" class="hero-button hero-button-primary">
                Jelajahi Paket
                <span>→</span>
            </a>
            <a href="#wahana" class="hero-button hero-button-secondary">
                Lihat Wahana
                <span>→</span>
            </a>
        </div>

    </div>

</section>

<section class="home-intro public-container">

    <div class="intro-heading">

        <span class="section-eyebrow">
            NOYO GIMBAL
        </span>

        <h2>
            Satu tempat untuk
            <span>berbagai pengalaman.</span>
        </h2>

    </div>

    <div class="intro-description">

        <p>
            Temukan berbagai pengalaman menarik di Noyo Gimbal,
            mulai dari paket bundling, wahana, oleh-oleh,
            hingga event yang dapat melengkapi perjalananmu.
        </p>

        <a
            href="{{ route('public.paketbundling.index') }}"
            class="text-link"
        >
            <span>Jelajahi Paket</span>
            <span>→</span>
        </a>

    </div>

</section>

@php
    $resolveHomeImage = function ($path) {
        if (!is_string($path) || trim($path) === '') {
            return null;
        }

        $path = trim($path);

        if (preg_match('/^https?:\/\//i', $path)) {
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

    $homeImageFallback = asset('images/no-image.png');
@endphp

@if ($paketBundlings->isNotEmpty())
    <section class="bundling-section">
        <div class="public-container">
            <div class="section-header">
                <div>
                    <span class="section-eyebrow">PAKET PILIHAN</span>
                    <h2>Paket Bundling</h2>
                </div>
            </div>

            <div class="bundling-grid">
                @foreach ($paketBundlings as $paket)
                    <a href="{{ route('public.paketbundling.show', $paket->id_paket_bundling) }}" class="bundling-card">
                        <div class="bundling-image">
                            <img
                                src="{{ $resolveHomeImage($paket->gambar) ?: $homeImageFallback }}"
                                alt="{{ $paket->nama_paket }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ $homeImageFallback }}';"
                            >
                            @if ($paket->untuk)
                                <span class="bundling-badge">{{ $paket->untuk }}</span>
                            @endif
                        </div>

                        <div class="bundling-content">
                            <span class="small-label">PAKET BUNDLING</span>
                            <h3>{{ $paket->nama_paket }}</h3>

                            @if ($paket->deskripsi)
                                <p>{{ \Illuminate\Support\Str::limit($paket->deskripsi, 100) }}</p>
                            @endif

                            @php
                                $paketMenus = collect($paket->menus ?? []);
                                $paketWahanas = collect($paket->wahanas ?? []);
                            @endphp

                            @if ($paketMenus->isNotEmpty() || $paketWahanas->isNotEmpty())
                                <div class="bundling-items">
                                    @foreach ($paketMenus->take(2) as $menu)
                                        <span>{{ $menu->nama_menu }}</span>
                                    @endforeach
                                    @foreach ($paketWahanas->take(2) as $wahana)
                                        <span>{{ $wahana->nama_wahana }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="card-bottom">
                                <span class="card-price">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                <span class="card-arrow">→</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="section-more">
                <a href="{{ route('public.paketbundling.index') }}" class="section-more-link">
                    <span>Paket Bundling Lainnya</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>
@endif

@if ($tiketWahanas->isNotEmpty())
    @php
        $latestWahanas = $tiketWahanas->take(4);
    @endphp

    <section class="home-section public-container" id="wahana">
        <div class="section-header">
            <div>
                <span class="section-eyebrow">PENGALAMAN</span>
                <h2>Jelajahi Wahana</h2>
            </div>
        </div>

        <div class="wahana-home-grid">
            @foreach ($latestWahanas as $wahana)
                <a href="{{ route('public.tiket-wahana.show', $wahana->id_tiket_wahana) }}" class="wahana-home-card">
                    <div class="wahana-home-image">
                        <img
                            src="{{ $resolveHomeImage($wahana->gambar) ?: $homeImageFallback }}"
                            alt="{{ $wahana->nama_wahana }}"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ $homeImageFallback }}';"
                        >
                        <div class="wahana-overlay"></div>
                        <div class="wahana-price">Rp {{ number_format($wahana->harga, 0, ',', '.') }}</div>
                    </div>

                    <div class="wahana-home-content">
                        <span class="small-label">TIKET WAHANA</span>
                        <h3>{{ $wahana->nama_wahana }}</h3>
                        @if ($wahana->ketentuan)
                            <p>{{ \Illuminate\Support\Str::limit($wahana->ketentuan, 85) }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="section-more">
            <a href="{{ route('public.tiket-wahana.index') }}" class="section-more-link">
                <span>Wahana Lainnya</span>
                <span>→</span>
            </a>
        </div>
    </section>
@endif

@if ($olehOleh->isNotEmpty())

    @php
        $latestOlehOleh = $olehOleh->take(4);
    @endphp

    <section class="home-section public-container">

        <div class="section-header">

            <div>

                <span class="section-eyebrow">
                    BUAH TANGAN
                </span>

                <h2>
                    Oleh-Oleh
                </h2>

            </div>

        </div>

        <div class="oleh-home-grid">

            @foreach ($latestOlehOleh as $item)

                <a
                    href="{{ route('public.oleholeh.show', $item->id_oleh_oleh) }}"
                    class="oleh-home-card"
                >

                    <div class="oleh-home-image">

                        <img
                            src="{{ $resolveHomeImage($item->gambar) ?: $homeImageFallback }}"
                            alt="{{ $item->nama }}"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ $homeImageFallback }}';"
                        >

                        @if ($item->jenis)

                            <span class="card-badge">
                                {{ $item->jenis }}
                            </span>

                        @endif

                    </div>

                    <div class="oleh-home-content">

                        <h3>
                            {{ $item->nama }}
                        </h3>

                        @if ($item->deskripsi)

                            <p>
                                {{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}
                            </p>

                        @endif

                        <div class="card-bottom">

                            <span class="card-price">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </span>

                            <span class="card-arrow">
                                →
                            </span>

                        </div>

                    </div>

                </a>

            @endforeach

        </div>

        <div class="section-more">
            <a href="{{ route('public.oleholeh.index') }}" class="section-more-link">
                <span>Oleh-Oleh Lainnya</span>
                <span>→</span>
            </a>
        </div>

    </section>

@endif

@php
    $latestEvents = $events
        ->filter(function ($event) {
            if (empty($event->tanggal)) {
                return false;
            }

            try {
                $eventDate = \Illuminate\Support\Carbon::parse($event->tanggal);

                return $eventDate->isToday() || $eventDate->isFuture();
            } catch (\Throwable $exception) {
                return false;
            }
        })
        ->sortBy(function ($event) {
            return \Illuminate\Support\Carbon::parse($event->tanggal)->timestamp;
        })
        ->take(3);
@endphp

@if ($latestEvents->isNotEmpty())

    <section class="event-home-section">

        <div class="public-container">

            <div class="section-header">

                <div>

                    <span class="section-eyebrow">
                        AGENDA
                    </span>

                    <h2>
                        Event Mendatang
                    </h2>

                </div>

            </div>

            <div class="home-event-list">

                @foreach ($latestEvents as $event)

                    @php
                        $eventDate = \Illuminate\Support\Carbon::parse($event->tanggal);
                        $isToday = $eventDate->isToday();
                    @endphp

                    <a
                        href="{{ route('public.event.show', $event->id_event) }}"
                        class="home-event-card"
                    >

                        <div class="home-event-image">

                            <img
                                src="{{ $event->gambar_url ?: $homeImageFallback }}"
                                alt="{{ $event->judul }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ $homeImageFallback }}';"
                            >

                        </div>

                        <div class="home-event-date">

                            <strong>
                                {{ $eventDate->format('d') }}
                            </strong>

                            <span>
                                {{ strtoupper($eventDate->copy()->locale('id')->translatedFormat('M')) }}
                            </span>

                        </div>

                        <div class="home-event-content">

                            <div class="home-event-meta">

                                @if ($isToday)

                                    <span class="today-label">
                                        HARI INI
                                    </span>

                                @endif

                                <span>
                                    {{ $eventDate->locale('id')->translatedFormat('l') }}
                                </span>

                            </div>

                            <h3>
                                {{ $event->judul }}
                            </h3>

                            @if ($event->deskripsi)

                                <p>
                                    {{ \Illuminate\Support\Str::limit($event->deskripsi, 110) }}
                                </p>

                            @endif

                            <span class="event-detail-link">
                                Lihat Detail →
                            </span>

                        </div>

                    </a>

                @endforeach

            </div>

            <div class="section-more">
                <a href="{{ route('public.event.index') }}" class="section-more-link">
                    <span>Event Lainnya</span>
                    <span>→</span>
                </a>
            </div>

        </div>

    </section>

@endif

<section class="home-location" id="lokasi">

    <div class="public-container">

        <div class="location-header">

            <div>

                <span class="section-eyebrow">
                    LOKASI
                </span>

                <h2>
                    Temukan Noyo Gimbal
                </h2>

                <p>
                    Kunjungi Noyo Gimbal dan nikmati berbagai pilihan
                    paket wisata, wahana, oleh-oleh,
                    serta event menarik dalam satu tempat.
                </p>

            </div>

            <a
                href="https://maps.app.goo.gl/MyEAWS8TJSwAfjkq7"
                target="_blank"
                rel="noopener noreferrer"
                class="location-button"
            >
                <span>Buka Google Maps</span>
                <span>↗</span>
            </a>

        </div>

        <div class="location-map">

            <iframe
                src="https://maps.google.com/maps?q=2F42%2BXM6%2C%20Bangsri%2C%20Jepon%2C%20Kabupaten%20Blora%2C%20Jawa%20Tengah&z=15&output=embed"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Lokasi Noyo Gimbal"
            ></iframe>

        </div>

    </div>

</section>

@endsection

@push('styles')

<style>

:root {
    --bg-primary: #0a0a0a;
    --bg-secondary: #151515;
    --bg-soft: #1a1a1a;
    --bg-card: #121212;

    --text-primary: #f8f4ed;
    --text-secondary: #d4c9b5;
    --text-muted: #a89988;
    --text-dim: #8c7f70;

    --accent: #e2c997;
    --accent-hover: #d4b384;
    --accent-dark: #b89a6e;

    --border-soft: rgba(255,255,255,.08);
    --border-gold: rgba(226,201,151,.18);
    --border-gold-strong: rgba(226,201,151,.32);

    --white: #ffffff;
    --black: #000000;

    --shadow-soft: 0 20px 60px rgba(0,0,0,.42);
    --shadow-hover: 0 28px 80px rgba(0,0,0,.54);

    --radius-lg: 28px;
    --radius-md: 18px;
    --radius-sm: 14px;
    --radius-full: 999px;

    --transition: .28s cubic-bezier(.4,0,.2,1);

    --body-size: 16px;
    --small-size: 14px;
    --label-size: 12px;
}

.home-hero,
.home-intro,
.home-section,
.bundling-section,
.event-home-section,
.home-location {
    width: 100%;
}

.home-hero *,
.home-intro *,
.home-section *,
.bundling-section *,
.event-home-section *,
.home-location * {
    box-sizing: border-box;
}

.home-hero a,
.home-intro a,
.home-section a,
.bundling-section a,
.event-home-section a,
.home-location a {
    -webkit-tap-highlight-color: transparent;
}

.public-container {
    width: min(1400px, calc(100% - 64px));
    margin-inline: auto;
}

.home-hero {
    position: relative;
    min-height: min(650px, 76vh);
    display: flex;
    align-items: center;
    overflow: hidden;
    isolation: isolate;
    background:
        radial-gradient(circle at 78% 18%, rgba(226,201,151,.13), transparent 27%),
        radial-gradient(circle at 15% 80%, rgba(226,201,151,.055), transparent 30%),
        var(--bg-primary);
}

.home-hero::after {
    content: "";
    position: absolute;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    background:
        linear-gradient(90deg, rgba(0,0,0,.84) 0%, rgba(0,0,0,.48) 42%, rgba(0,0,0,.12) 100%),
        linear-gradient(180deg, rgba(0,0,0,.04) 0%, rgba(10,10,10,.1) 55%, rgba(10,10,10,.92) 100%);
}

.hero-background {
    position: absolute;
    inset: 0;
    z-index: -1;
    overflow: hidden;
    background: var(--bg-primary);
}

.hero-video {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center center;
    opacity: .72;
    filter: saturate(.86) contrast(1.04);
}

.hero-background::after {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background:
        radial-gradient(circle at 78% 22%, rgba(226,201,151,.10), transparent 28%),
        radial-gradient(circle at 20% 80%, rgba(226,201,151,.045), transparent 34%);
}

.hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
    background: linear-gradient(180deg, transparent 55%, rgba(10,10,10,.88) 100%);
}

.hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
    padding: clamp(90px, 11vw, 125px) 0 clamp(70px, 8vw, 95px);
}

.hero-eyebrow,
.section-eyebrow,
.small-label {
    text-transform: uppercase;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 24px;
    padding: 10px 15px;
    border: 1px solid var(--border-gold);
    border-radius: var(--radius-full);
    background: rgba(226,201,151,.06);
    color: var(--accent);
    font-size: clamp(11px, .8vw, 13px);
    font-weight: 800;
    line-height: 1;
    letter-spacing: .13em;
    backdrop-filter: blur(14px);
}

.hero-content h1 {
    max-width: 980px;
    margin: 0;
    color: var(--text-primary);
    font-family: "Playfair Display", Georgia, serif;
    font-size: clamp(52px, 7.6vw, 102px);
    font-weight: 500;
    line-height: .98;
    letter-spacing: -.045em;
    text-wrap: balance;
}

.hero-content h1 span {
    display: block;
    color: var(--accent);
    font-style: italic;
}

.hero-content p {
    max-width: 650px;
    margin: 30px 0 0;
    color: var(--text-secondary);
    font-size: clamp(16px, 1.15vw, 19px);
    line-height: 1.85;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 13px;
    margin-top: 30px;
}

.hero-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 13px;
    min-height: 52px;
    padding: 0 22px;
    border: 1px solid var(--border-gold);
    border-radius: var(--radius-full);
    color: var(--text-primary);
    text-decoration: none;
    font-size: 14px;
    font-weight: 800;
    transition: transform var(--transition), background var(--transition), border-color var(--transition), color var(--transition);
}

.hero-button-primary {
    background: var(--accent);
    border-color: var(--accent);
    color: #17130d;
}

.hero-button-primary:hover,
.hero-button-primary:focus-visible {
    transform: translateY(-3px);
    background: var(--accent-hover);
}

.hero-button-secondary {
    background: rgba(10,10,10,.42);
    backdrop-filter: blur(10px);
}

.hero-button-secondary:hover,
.hero-button-secondary:focus-visible {
    transform: translateY(-3px);
    border-color: var(--accent);
    color: var(--accent);
}

.home-intro {
    display: grid;
    grid-template-columns: minmax(0,1.05fr) minmax(320px,.8fr);
    gap: clamp(48px, 7vw, 100px);
    padding-top: clamp(48px, 5vw, 72px);
    padding-bottom: clamp(58px, 6vw, 82px);
}

.section-eyebrow {
    display: block;
    margin-bottom: 11px;
    color: var(--accent-dark);
    font-size: var(--label-size);
    font-weight: 800;
    line-height: 1.3;
    letter-spacing: .15em;
}

.intro-heading h2,
.section-header h2,
.location-header h2 {
    margin: 0;
    color: var(--text-primary);
    font-family: "Playfair Display", Georgia, serif;
    font-weight: 500;
    line-height: 1.08;
    letter-spacing: -.03em;
    text-wrap: balance;
}

.intro-heading h2 {
    max-width: 760px;
    font-size: clamp(40px, 5vw, 68px);
}

.intro-heading h2 span {
    display: block;
    color: var(--accent);
    font-style: italic;
}

.intro-description {
    align-self: end;
    max-width: 620px;
}

.intro-description p {
    margin: 0;
    color: var(--text-muted);
    font-size: clamp(16px, 1.05vw, 18px);
    line-height: 1.9;
}

.text-link,
.section-link {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 14px;
    font-weight: 800;
    line-height: 1.3;
    transition: color var(--transition), transform var(--transition);
}

.text-link {
    margin-top: 24px;
}

.text-link:hover,
.text-link:focus-visible,
.section-link:hover,
.section-link:focus-visible {
    color: var(--accent);
}

.text-link span:last-child,
.section-link span:last-child {
    transition: transform var(--transition);
}

.text-link:hover span:last-child,
.text-link:focus-visible span:last-child,
.section-link:hover span:last-child,
.section-link:focus-visible span:last-child {
    transform: translateX(4px);
}

.home-section {
    padding-bottom: clamp(58px, 6vw, 78px);
}

.section-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 28px;
    margin-bottom: 24px;
}

.section-header h2 {
    margin-top: 7px;
    font-size: clamp(36px, 4vw, 54px);
}

.section-more {
    display: flex;
    justify-content: center;
    margin-top: 24px;
}

.section-more-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    min-height: 50px;
    padding: 0 20px;
    border: 1px solid var(--border-gold);
    border-radius: var(--radius-full);
    background: rgba(226,201,151,.06);
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 14px;
    font-weight: 800;
    line-height: 1.2;
    transition: transform var(--transition), border-color var(--transition), background var(--transition), color var(--transition), box-shadow var(--transition);
}

.section-more-link:hover,
.section-more-link:focus-visible {
    transform: translateY(-2px);
    border-color: var(--accent);
    background: rgba(226,201,151,.12);
    color: var(--accent);
    box-shadow: 0 14px 35px rgba(0,0,0,.28);
    outline: none;
}

.section-more-link span:last-child {
    transition: transform var(--transition);
}

.section-more-link:hover span:last-child,
.section-more-link:focus-visible span:last-child {
    transform: translateX(4px);
}

.card-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-top: auto;
    padding-top: 20px;
}

.card-price {
    color: var(--accent);
    font-size: 16px;
    font-weight: 800;
    line-height: 1.35;
}

.card-arrow {
    color: var(--text-dim);
    font-size: 22px;
    line-height: 1;
    transition: color var(--transition), transform var(--transition);
}

.card-badge,
.bundling-badge,
.today-label {
    font-size: 11px;
    font-weight: 800;
    line-height: 1;
    letter-spacing: .04em;
}

.card-badge {
    position: absolute;
    top: 14px;
    left: 14px;
    padding: 8px 11px;
    border: 1px solid rgba(226,201,151,.28);
    border-radius: var(--radius-full);
    background: rgba(10,10,10,.80);
    color: var(--accent);
    backdrop-filter: blur(12px);
}

.menu-home-grid,
.wahana-home-grid,
.bundling-grid,
.oleh-home-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0,1fr));
    gap: 22px;
}

.menu-home-card,
.wahana-home-card,
.bundling-card,
.oleh-home-card {
    overflow: hidden;
    border: 1px solid var(--border-soft);
    border-radius: 24px;
    background: var(--bg-card);
    text-decoration: none;
    box-shadow: 0 10px 28px rgba(0,0,0,.16);
    transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition), background var(--transition);
}

.menu-home-card:hover,
.menu-home-card:focus-visible,
.wahana-home-card:hover,
.wahana-home-card:focus-visible,
.bundling-card:hover,
.bundling-card:focus-visible,
.oleh-home-card:hover,
.oleh-home-card:focus-visible {
    transform: translateY(-7px);
    border-color: var(--border-gold-strong);
    box-shadow: var(--shadow-hover);
    outline: none;
}

.menu-home-image,
.wahana-home-image,
.bundling-image,
.oleh-home-image {
    position: relative;
    overflow: hidden;
    background: var(--bg-soft);
}

.menu-home-image {
    aspect-ratio: 4 / 3;
}

.wahana-home-image {
    aspect-ratio: 4 / 4.1;
}

.bundling-image {
    aspect-ratio: 16 / 10;
}

.oleh-home-image {
    aspect-ratio: 1 / 1;
}

.menu-home-image img,
.wahana-home-image img,
.bundling-image img,
.oleh-home-image img,
.home-event-image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .55s ease;
}

.menu-home-card:hover .menu-home-image img,
.menu-home-card:focus-visible .menu-home-image img,
.wahana-home-card:hover .wahana-home-image img,
.wahana-home-card:focus-visible .wahana-home-image img,
.bundling-card:hover .bundling-image img,
.bundling-card:focus-visible .bundling-image img,
.oleh-home-card:hover .oleh-home-image img,
.oleh-home-card:focus-visible .oleh-home-image img,
.home-event-card:hover .home-event-image img,
.home-event-card:focus-visible .home-event-image img {
    transform: scale(1.045);
}

.menu-home-content,
.oleh-home-content,
.bundling-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 22px;
}

.menu-home-card,
.oleh-home-card,
.bundling-card {
    display: flex;
    flex-direction: column;
}

.menu-home-content h3,
.oleh-home-content h3,
.wahana-home-content h3,
.bundling-content h3,
.home-event-content h3 {
    color: var(--text-primary);
    font-weight: 750;
}

.menu-home-content h3,
.oleh-home-content h3,
.wahana-home-content h3 {
    font-size: clamp(18px, 1.35vw, 21px);
    line-height: 1.42;
}

.menu-home-content h3,
.oleh-home-content h3 {
    margin: 0;
}

.menu-home-content p,
.oleh-home-content p,
.wahana-home-content p,
.bundling-content p,
.home-event-content p {
    color: var(--text-dim);
    font-size: var(--small-size);
    line-height: 1.75;
}

.menu-home-content p,
.oleh-home-content p,
.wahana-home-content p,
.bundling-content p,
.home-event-content p {
    margin-top: 10px;
}

.wahana-home-card {
    display: flex;
    flex-direction: column;
}

.wahana-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.78), rgba(0,0,0,.03) 58%);
}

.wahana-price {
    position: absolute;
    left: 19px;
    bottom: 18px;
    color: var(--accent);
    font-size: 17px;
    font-weight: 800;
    line-height: 1.3;
}

.wahana-home-content {
    padding: 21px;
}

.small-label {
    color: var(--accent-dark);
    font-size: 12px;
    font-weight: 800;
    line-height: 1.3;
    letter-spacing: .10em;
}

.wahana-home-content h3 {
    margin: 9px 0 0;
}

.detail-link {
    display: inline-flex;
    align-items: center;
    margin-top: 17px;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 800;
    line-height: 1.35;
    transition: color var(--transition);
}

.wahana-home-card:hover .detail-link,
.wahana-home-card:focus-visible .detail-link {
    color: var(--accent);
}

.bundling-section {
    padding: clamp(58px, 6vw, 78px) 0;
    background: var(--bg-primary);
}

.bundling-content h3 {
    margin: 9px 0 0;
    font-size: clamp(19px, 1.5vw, 23px);
    line-height: 1.4;
}

.bundling-items {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 16px;
}

.bundling-items span {
    padding: 7px 10px;
    border: 1px solid var(--border-soft);
    border-radius: 9px;
    color: var(--text-secondary);
    background: rgba(255,255,255,.025);
    font-size: 12px;
    line-height: 1.25;
}

.oleh-home-card .card-price {
    font-size: 16px;
}

.event-home-section {
    padding: clamp(58px, 6vw, 78px) 0;
}

.home-event-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.home-event-card {
    display: grid;
    grid-template-columns: 210px 100px minmax(0,1fr);
    align-items: stretch;
    min-height: 170px;
    overflow: hidden;
    border: 1px solid var(--border-soft);
    border-radius: 22px;
    background: var(--bg-card);
    text-decoration: none;
    box-shadow: 0 10px 28px rgba(0,0,0,.14);
    transition: transform var(--transition), border-color var(--transition), background var(--transition), box-shadow var(--transition);
}

.home-event-card:hover,
.home-event-card:focus-visible {
    transform: translateX(5px);
    border-color: var(--border-gold-strong);
    background: var(--bg-secondary);
    box-shadow: var(--shadow-soft);
    outline: none;
}

.home-event-image {
    min-height: 170px;
    overflow: hidden;
    background: var(--bg-soft);
}

.home-event-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100%;
    padding: 16px 10px;
    border-left: 1px solid var(--border-soft);
    border-right: 1px solid var(--border-soft);
    text-align: center;
}

.home-event-date strong {
    color: var(--accent);
    font-family: "Playfair Display", Georgia, serif;
    font-size: clamp(38px, 3vw, 50px);
    font-weight: 500;
    line-height: 1;
}

.home-event-date span {
    margin-top: 8px;
    color: var(--text-secondary);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .08em;
}

.home-event-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-width: 0;
    padding: 26px 30px;
}

.home-event-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    color: var(--text-dim);
    font-size: 13px;
    line-height: 1.4;
}

.today-label {
    padding: 6px 9px;
    border: 1px solid rgba(226,201,151,.22);
    border-radius: 7px;
    background: rgba(226,201,151,.08);
    color: var(--accent);
}

.home-event-content h3 {
    margin: 9px 0 0;
    font-size: clamp(19px, 1.65vw, 24px);
    line-height: 1.4;
}

.home-event-content p {
    max-width: 760px;
}

.event-detail-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    width: fit-content;
    margin-top: 16px;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 800;
    line-height: 1.35;
}

.home-event-card:hover .event-detail-link,
.home-event-card:focus-visible .event-detail-link {
    color: var(--accent);
}

.home-location {
    padding-top: 0;
    padding-bottom: clamp(70px, 8vw, 100px);
}

.location-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 35px;
    margin-bottom: 30px;
}

.location-header h2 {
    font-size: clamp(38px, 4.5vw, 60px);
}

.location-header p {
    max-width: 700px;
    margin: 16px 0 0;
    color: var(--text-muted);
    font-size: clamp(16px, 1.05vw, 18px);
    line-height: 1.85;
}

.location-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-shrink: 0;
    min-height: 54px;
    padding: 0 23px;
    border: 1px solid var(--border-gold);
    border-radius: var(--radius-full);
    background: rgba(226,201,151,.07);
    color: var(--text-primary);
    font-size: 14px;
    font-weight: 800;
    line-height: 1;
    text-decoration: none;
    transition: transform var(--transition), border-color var(--transition), background var(--transition), color var(--transition), box-shadow var(--transition);
}

.location-button:hover,
.location-button:focus-visible {
    transform: translateY(-3px);
    border-color: var(--accent);
    background: rgba(226,201,151,.14);
    color: var(--accent);
    box-shadow: var(--shadow-soft);
    outline: none;
}

.location-map {
    position: relative;
    overflow: hidden;
    min-height: 480px;
    border: 1px solid var(--border-gold);
    border-radius: 28px;
    background: var(--bg-secondary);
    box-shadow: var(--shadow-soft);
}

.location-map iframe {
    display: block;
    width: 100%;
    height: 480px;
    border: 0;
    filter: grayscale(.08) contrast(.98) saturate(.92);
}

.text-link:focus-visible,
.section-link:focus-visible,
.location-button:focus-visible,
.menu-home-card:focus-visible,
.wahana-home-card:focus-visible,
.bundling-card:focus-visible,
.oleh-home-card:focus-visible,
.home-event-card:focus-visible {
    outline: 3px solid rgba(226,201,151,.55);
    outline-offset: 3px;
}

@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        scroll-behavior: auto !important;
        transition-duration: .01ms !important;
        animation-duration: .01ms !important;
        animation-iteration-count: 1 !important;
    }
}

@media (min-width: 1600px) {
    .public-container {
        width: min(1480px, calc(100% - 96px));
    }

    .hero-content p {
        max-width: 700px;
    }
}

@media (max-width: 1200px) {
    .public-container {
        width: min(1120px, calc(100% - 56px));
    }

    .home-intro {
        grid-template-columns: 1fr 1fr;
        gap: 52px;
    }

    .menu-home-grid,
    .wahana-home-grid,
    .bundling-grid,
    .oleh-home-grid {
        gap: 18px;
    }

    .home-event-card {
        grid-template-columns: 190px 90px minmax(0,1fr);
    }
}

@media (min-width: 993px) {
    .bundling-grid > :nth-child(n+4),
    .wahana-home-grid > :nth-child(n+4),
    .oleh-home-grid > :nth-child(n+4) {
        display: none;
    }
}

@media (max-width: 992px) {
    .public-container {
        width: min(900px, calc(100% - 48px));
    }

    .menu-home-grid,
    .wahana-home-grid,
    .bundling-grid,
    .oleh-home-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .menu-home-image,
    .wahana-home-image,
    .bundling-image,
    .oleh-home-image {
        aspect-ratio: 4 / 3;
    }

    .menu-home-content,
    .oleh-home-content,
    .bundling-content,
    .wahana-home-content {
        padding: 15px;
    }

    .menu-home-content h3,
    .oleh-home-content h3,
    .wahana-home-content h3 {
        font-size: 16px;
        line-height: 1.35;
    }

    .menu-home-content p,
    .oleh-home-content p,
    .wahana-home-content p,
    .bundling-content p {
        font-size: 12px;
        line-height: 1.6;
    }

    .small-label {
        font-size: 10px;
    }

    .card-price,
    .wahana-price,
    .oleh-home-card .card-price {
        font-size: 14px;
    }

    .home-hero {
        min-height: 540px;
    }

    .hero-content {
        padding-top: 95px;
        padding-bottom: 85px;
    }

    .home-intro {
        grid-template-columns: 1fr;
        gap: 28px;
    }

    .intro-description {
        max-width: 760px;
    }

    .menu-home-grid,
    .wahana-home-grid,
    .bundling-grid,
    .oleh-home-grid {
        grid-template-columns: repeat(2, minmax(0,1fr));
    }

    .location-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 22px;
    }

    .location-button {
        width: fit-content;
    }
}

@media (max-width: 768px) {
    .public-container {
        width: min(680px, calc(100% - 36px));
    }

    .home-hero {
        min-height: 630px;
    }

    .hero-content {
        padding-top: 105px;
        padding-bottom: 105px;
    }

    .hero-eyebrow {
        margin-bottom: 20px;
        padding: 10px 13px;
        font-size: 11px;
        letter-spacing: .09em;
    }

    .hero-content h1 {
        font-size: clamp(48px, 11vw, 72px);
    }

    .hero-content p {
        max-width: 620px;
        font-size: 16px;
        line-height: 1.8;
    }

    .home-intro {
        padding-top: 60px;
        padding-bottom: 68px;
    }

    .intro-heading h2,
    .section-header h2,
    .location-header h2 {
        font-size: clamp(36px, 8vw, 50px);
    }

    .intro-description p,
    .location-header p {
        font-size: 16px;
    }

    .section-header {
        align-items: flex-start;
        gap: 16px;
    }

    .section-link {
        font-size: 14px;
    }

    .home-section {
        padding-bottom: 64px;
    }

    .bundling-section,
    .event-home-section {
        padding-top: 64px;
        padding-bottom: 68px;
    }

    .menu-home-content,
    .oleh-home-content,
    .bundling-content {
        padding: 20px;
    }

    .home-event-card {
        grid-template-columns: 155px 82px minmax(0,1fr);
    }

    .home-event-content {
        padding: 22px;
    }

    .home-event-content p {
        font-size: 14px;
    }

    .location-map,
    .location-map iframe {
        min-height: 400px;
        height: 400px;
    }

}

@media (max-width: 600px) {
    .hero-video {
        object-position: center center;
        opacity: .66;
    }

    .public-container {
        width: calc(100% - 28px);
    }

    .home-hero {
        min-height: 600px;
    }

    .hero-content {
        padding-top: 72px;
        padding-bottom: 65px;
    }

    .hero-eyebrow {
        font-size: 10px;
    }

    .hero-content h1 {
        font-size: clamp(43px, 13vw, 58px);
        line-height: 1.01;
    }

    .hero-content p {
        margin-top: 22px;
        font-size: 15.5px;
        line-height: 1.75;
    }

    .hero-actions {
        gap: 10px;
        margin-top: 24px;
    }

    .hero-button {
        min-height: 48px;
        padding: 0 16px;
        font-size: 12.5px;
    }

    .home-intro {
        padding-top: 48px;
        padding-bottom: 52px;
        gap: 22px;
    }

    .section-eyebrow {
        font-size: 11px;
        margin-bottom: 9px;
    }

    .intro-heading h2,
    .section-header h2,
    .location-header h2 {
        font-size: clamp(34px, 10vw, 44px);
    }

    .intro-description p,
    .location-header p {
        font-size: 15px;
        line-height: 1.8;
    }

    .text-link,
    .section-link,
    .detail-link,
    .event-detail-link {
        font-size: 14px;
    }

    .menu-home-grid,
    .wahana-home-grid,
    .bundling-grid,
    .oleh-home-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .menu-home-card,
    .wahana-home-card,
    .bundling-card,
    .oleh-home-card {
        border-radius: 17px;
    }

    .menu-home-image,
    .wahana-home-image,
    .bundling-image,
    .oleh-home-image {
        aspect-ratio: 4 / 3;
    }

    .menu-home-content,
    .oleh-home-content,
    .bundling-content,
    .wahana-home-content {
        padding: 11px;
    }

    .menu-home-content h3,
    .oleh-home-content h3,
    .wahana-home-content h3 {
        font-size: 14.5px;
        line-height: 1.3;
    }

    .menu-home-content p,
    .oleh-home-content p,
    .wahana-home-content p,
    .bundling-content p {
        margin-top: 7px;
        font-size: 11px;
        line-height: 1.55;
    }

    .small-label {
        font-size: 9px;
        letter-spacing: .07em;
    }

    .card-badge,
    .bundling-badge {
        top: 8px;
        left: 8px;
        padding: 6px 8px;
        font-size: 9px;
    }

    .card-bottom {
        gap: 8px;
        padding-top: 10px;
    }

    .card-price,
    .wahana-price,
    .oleh-home-card .card-price {
        font-size: 13.5px;
    }

    .card-arrow {
        font-size: 18px;
    }

    .wahana-price {
        left: 11px;
        bottom: 10px;
    }

    .detail-link {
        margin-top: 9px;
        font-size: 11.5px;
    }

    .bundling-items {
        gap: 5px;
        margin-top: 9px;
    }

    .bundling-items span {
        padding: 5px 7px;
        font-size: 9.5px;
    }

    .section-more {
        margin-top: 16px;
    }

    .section-more-link {
        min-height: 44px;
        padding: 0 16px;
        font-size: 12.5px;
    }

    .home-event-card {
        grid-template-columns: 110px 66px minmax(0,1fr);
        min-height: 142px;
        border-radius: 19px;
    }

    .home-event-image {
        min-height: 142px;
    }

    .home-event-date {
        padding: 12px 7px;
    }

    .home-event-date strong {
        font-size: 30px;
    }

    .home-event-date span {
        font-size: 10px;
        letter-spacing: .06em;
    }

    .home-event-content {
        padding: 17px 16px;
    }

    .home-event-meta {
        gap: 7px;
        font-size: 11px;
    }

    .today-label {
        padding: 5px 7px;
        font-size: 9px;
    }

    .home-event-content h3 {
        font-size: 16px;
        line-height: 1.35;
    }

    .home-event-content p {
        display: none;
    }

    .event-detail-link {
        margin-top: 11px;
        font-size: 12px;
    }

    .section-more {
        margin-top: 20px;
    }

    .section-more-link {
        width: 100%;
        min-height: 52px;
    }

    .location-button {
        width: 100%;
        min-height: 54px;
        font-size: 14px;
    }

    .location-map,
    .location-map iframe {
        min-height: 330px;
        height: 330px;
        border-radius: 21px;
    }

.map-pin {
        width: 42px;
        height: 42px;
        font-size: 13px;
    }

    .map-info {
        flex: 1 1 calc(100% - 52px);
        min-width: 130px;
    }

    .map-info strong {
        font-size: 14px;
    }

    .map-info span {
        font-size: 12px;
    }

}

@media (max-width: 420px) {
    .public-container {
        width: calc(100% - 24px);
    }

    .home-hero {
        min-height: 515px;
    }

    .hero-content h1 {
        font-size: clamp(40px, 13.5vw, 52px);
    }

    .hero-content p {
        font-size: 15px;
    }

    .home-event-card {
        grid-template-columns: 92px 58px minmax(0,1fr);
        min-height: 130px;
    }

    .home-event-image {
        min-height: 130px;
    }

    .home-event-date strong {
        font-size: 27px;
    }

    .home-event-content {
        padding: 14px 12px;
    }

    .home-event-content h3 {
        font-size: 15px;
    }

    .home-event-meta {
        font-size: 10px;
    }

    .event-detail-link {
        font-size: 11px;
    }

    .bundling-items span {
        font-size: 11px;
    }

    .location-map,
    .location-map iframe {
        min-height: 300px;
        height: 300px;
    }
}

@media (max-width: 340px) {
    .public-container {
        width: calc(100% - 16px);
    }

    .menu-home-grid,
    .wahana-home-grid,
    .bundling-grid,
    .oleh-home-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 9px;
    }

    .menu-home-content,
    .oleh-home-content,
    .bundling-content,
    .wahana-home-content {
        padding: 9px;
    }

    .menu-home-content h3,
    .oleh-home-content h3,
    .wahana-home-content h3 {
        font-size: 13px;
    }

    .menu-home-content p,
    .oleh-home-content p,
    .wahana-home-content p,
    .bundling-content p {
        font-size: 10.5px;
    }

    .card-price,
    .wahana-price,
    .oleh-home-card .card-price {
        font-size: 13px;
    }

    .hero-content h1 {
        font-size: 38px;
    }

    .hero-content p,
    .intro-description p,
    .location-header p {
        font-size: 14.5px;
    }

    .home-event-card {
        grid-template-columns: 78px 54px minmax(0,1fr);
    }

    .home-event-content {
        padding: 12px 10px;
    }

    .home-event-content h3 {
        font-size: 14px;
    }
}

</style>

@endpush
