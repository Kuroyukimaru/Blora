@extends('public.layouts.app')

@section('title', $event->judul)

@section('content')




<section class="event-detail-breadcrumb">
    <div class="public-container">
        <div class="event-detail-breadcrumb-inner">
            <a href="{{ route('public.home') }}" class="event-detail-breadcrumb-link">Home</a>
            <span class="event-detail-breadcrumb-separator">/</span>
            <a href="{{ route('public.event.index') }}" class="event-detail-breadcrumb-link">Event</a>
            <span class="event-detail-breadcrumb-separator">/</span>
            <span class="event-detail-breadcrumb-current">{{ $event->judul }}</span>
        </div>
    </div>
</section>


<section class="event-detail-section">
    <div class="public-container">
        <div class="event-detail-grid">

            
            <div class="event-detail-image-column">
                <div class="event-detail-image-wrapper">
                    <img
                        src="{{ $event->gambar_url }}"
                        alt="{{ $event->judul }}"
                        class="event-detail-image"
                        loading="eager"
                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                    >

                    <div class="event-detail-image-overlay"></div>

                    <div class="event-detail-image-date">
                        @php
                            $eventDate = \Carbon\Carbon::parse($event->tanggal);
                        @endphp
                        <span class="event-detail-date-day">{{ $eventDate->format('d') }}</span>
                        <span class="event-detail-date-month">{{ strtoupper($eventDate->translatedFormat('M')) }}</span>
                    </div>

                    @if($eventDate->isToday())
                        <span class="event-detail-today">HARI INI</span>
                    @endif
                </div>
            </div>

            
            <div class="event-detail-information">

                <div class="event-detail-category">
                    EVENT
                </div>

                <h1 class="event-detail-title">
                    {{ $event->judul }}
                </h1>

                
                <div class="event-detail-date-wrapper">
                    <div class="event-detail-date-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                    </div>

                    <div>
                        <p class="event-detail-date-label">Tanggal Event</p>
                        <p class="event-detail-date-value">
                            {{ $eventDate->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>

                <div class="event-detail-divider"></div>

                
                <div class="event-detail-description-section">
                    <h2 class="event-detail-description-title">Tentang Event</h2>

                    @if($event->deskripsi)
                        <p class="event-detail-description">{{ $event->deskripsi }}</p>
                    @else
                        <p class="event-detail-description event-detail-description-empty">
                            Belum ada deskripsi untuk event ini.
                        </p>
                    @endif
                </div>

                
                <div class="event-detail-info-grid">

                    <div class="event-detail-info-box">
                        <div class="event-detail-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                            </svg>
                        </div>

                        <div>
                            <p class="event-detail-info-label">Status</p>
                            <p class="event-detail-info-value">
                                {{ $eventDate->isToday() ? 'Berlangsung Hari Ini' : 'Event Mendatang' }}
                            </p>
                        </div>
                    </div>

                    <div class="event-detail-info-box">
                        <div class="event-detail-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                <path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                        </div>

                        <div>
                            <p class="event-detail-info-label">Hari</p>
                            <p class="event-detail-info-value">
                                {{ $eventDate->translatedFormat('l') }}
                            </p>
                        </div>
                    </div>

                    <div class="event-detail-info-box">
                        <div class="event-detail-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18"/>
                            </svg>
                        </div>

                        <div>
                            <p class="event-detail-info-label">Tanggal</p>
                            <p class="event-detail-info-value">
                                {{ $eventDate->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="event-detail-info-box">
                        <div class="event-detail-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 12h7M12 8.5v7"/>
                            </svg>
                        </div>

                        <div>
                            <p class="event-detail-info-label">Agenda</p>
                            <p class="event-detail-info-value">Noyo Gimbal</p>
                        </div>
                    </div>

                </div>

                
                <div class="event-detail-actions">
                    <a href="{{ route('public.event.index') }}" class="event-back-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                        </svg>
                        <span>Kembali ke Event</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>



@php
    $eventLainnya = \App\Models\Event::query()
        ->whereDate('tanggal', '>=', today())
        ->where('id_event', '!=', $event->id_event)
        ->orderBy('tanggal', 'asc')
        ->orderBy('id_event', 'asc')
        ->limit(4)
        ->get();
@endphp

@if($eventLainnya->count() > 0)
<section class="other-event-section">
    <div class="public-container">

        <div class="other-event-heading">
            <p class="other-event-eyebrow">EVENT LAINNYA</p>
            <h2 class="other-event-title">Event Noyo Gimbal Lainnya</h2>

            <div class="other-event-subheader">
                <p>Temukan event lainnya yang akan berlangsung di Noyo Gimbal.</p>

                <a href="{{ route('public.event.index') }}" class="other-event-view-all">
                    Lihat semua
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="other-event-grid">
            @foreach($eventLainnya as $otherEvent)
                @php
                    $otherDate = \Carbon\Carbon::parse($otherEvent->tanggal);
                    $otherIsToday = $otherDate->isToday();
                @endphp

                <a href="{{ route('public.event.show', $otherEvent->id_event) }}" class="other-event-card">

                    <div class="other-event-image">
                        <img
                            src="{{ $otherEvent->gambar_url }}"
                            alt="{{ $otherEvent->judul }}"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';"
                        >

                        <div class="other-event-image-overlay"></div>

                        <div class="other-event-date">
                            <span>{{ $otherDate->format('d') }}</span>
                            <small>{{ strtoupper($otherDate->translatedFormat('M')) }}</small>
                        </div>

                        @if($otherIsToday)
                            <span class="other-event-today">HARI INI</span>
                        @endif

                        <span class="other-event-hover">Lihat detail</span>
                    </div>

                    <div class="other-event-content">
                        <div class="other-event-meta">
                            {{ $otherDate->translatedFormat('l') }}
                            <span>•</span>
                            {{ $otherDate->format('d M Y') }}
                        </div>

                        <h3>{{ $otherEvent->judul }}</h3>

                        @if($otherEvent->deskripsi)
                            <p>{{ \Illuminate\Support\Str::limit($otherEvent->deskripsi, 100) }}</p>
                        @endif

                        <div class="other-event-bottom">
                            <span>Lihat Detail</span>

                            <span class="other-event-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                </a>
            @endforeach
        </div>

        <div class="other-event-mobile-action">
            <a href="{{ route('public.event.index') }}" class="other-event-mobile-button">
                Lihat Semua Event
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>
@endif

@endsection


@push('styles')
<style>


.event-detail-breadcrumb,
.event-detail-section,
.other-event-section {
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



.event-detail-breadcrumb {
    padding: 42px 0 0;
}

.event-detail-breadcrumb-inner {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    font-size: 12px;
}

.event-detail-breadcrumb-link {
    flex-shrink: 0;
    color: var(--text-muted);
    text-decoration: none;
    transition: color var(--transition);
}

.event-detail-breadcrumb-link:hover {
    color: var(--accent);
}

.event-detail-breadcrumb-separator {
    flex-shrink: 0;
    color: var(--text-dim);
}

.event-detail-breadcrumb-current {
    min-width: 0;
    overflow: hidden;
    color: var(--text-secondary);
    white-space: nowrap;
    text-overflow: ellipsis;
}



.event-detail-section {
    padding: 48px 0 120px;
}

.event-detail-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.05fr) minmax(0, .95fr);
    gap: 70px;
    align-items: center;
}



.event-detail-image-column {
    position: sticky;
    top: 110px;
}

.event-detail-image-wrapper {
    position: relative;
    width: 100%;
    min-height: 470px;
    overflow: hidden;
    border: 1px solid var(--border-gold);
    border-radius: 28px;
    background: var(--bg-soft);
    box-shadow: var(--shadow-soft);
}

.event-detail-image {
    display: block;
    width: 100%;
    height: 470px;
    object-fit: cover;
    transition: transform .6s cubic-bezier(.2,.7,.2,1);
}

.event-detail-image-wrapper:hover .event-detail-image {
    transform: scale(1.025);
}

.event-detail-image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        transparent 48%,
        rgba(10,10,10,.55) 100%
    );
    pointer-events: none;
}

.event-detail-image-date {
    position: absolute;
    left: 22px;
    bottom: 22px;
    z-index: 2;

    width: 66px;
    height: 70px;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(226,201,151,.30);
    border-radius: 15px;
    background: rgba(10,10,10,.76);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.event-detail-date-day {
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 25px;
    line-height: 1;
    font-weight: 700;
}

.event-detail-date-month {
    margin-top: 6px;
    color: var(--accent);
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .12em;
}

.event-detail-today {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 2;

    padding: 8px 11px;
    border: 1px solid rgba(226,201,151,.30);
    border-radius: 999px;
    background: rgba(10,10,10,.76);

    color: var(--accent);
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .10em;

    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}



.event-detail-information {
    padding: 18px 0;
}

.event-detail-category {
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
}

.event-detail-title {
    margin: 0;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(42px, 5vw, 64px);
    line-height: 1.04;
    font-weight: 700;
    letter-spacing: -.035em;
}

.event-detail-date-wrapper {
    display: flex;
    align-items: center;
    gap: 13px;

    margin-top: 28px;
    padding: 13px 15px;

    border: 1px solid var(--border-soft);
    border-radius: 15px;
    background: rgba(255,255,255,.025);
}

.event-detail-date-icon {
    width: 43px;
    height: 43px;
    flex: 0 0 43px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid var(--border-gold);
    border-radius: 12px;
    background: rgba(226,201,151,.06);
    color: var(--accent);
}

.event-detail-date-icon svg {
    width: 21px;
    height: 21px;
}

.event-detail-date-label {
    margin: 0 0 4px;
    color: var(--text-dim);
    font-size: 10px;
    font-weight: 500;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.event-detail-date-value {
    margin: 0;
    color: var(--text-primary);
    font-size: 13px;
    font-weight: 600;
}

.event-detail-divider {
    width: 100%;
    height: 1px;
    margin: 30px 0;

    background: linear-gradient(
        to right,
        var(--border-gold),
        transparent
    );
}



.event-detail-description-title {
    margin: 0 0 11px;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 20px;
    font-weight: 700;
}

.event-detail-description {
    max-width: 680px;
    margin: 0;
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.9;
    white-space: pre-line;
}

.event-detail-description-empty {
    color: var(--text-dim);
    font-style: italic;
}



.event-detail-info-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
    margin-top: 30px;
}

.event-detail-info-box {
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

.event-detail-info-box:hover {
    border-color: var(--border-gold);
    background: rgba(226,201,151,.035);
}

.event-detail-info-icon {
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

.event-detail-info-icon svg {
    width: 19px;
    height: 19px;
}

.event-detail-info-label {
    margin: 0;
    color: var(--text-dim);
    font-size: 10px;
    letter-spacing: .04em;
}

.event-detail-info-value {
    margin: 2px 0 0;
    color: var(--text-primary);
    font-size: 12px;
    font-weight: 600;
}



.event-detail-actions {
    margin-top: 30px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.event-back-button {
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
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;

    transition: all var(--transition);
}

.event-back-button svg {
    width: 17px;
    height: 17px;
}

.event-back-button:hover {
    border-color: var(--accent);
    background: rgba(226,201,151,.10);
    color: var(--accent);
    transform: translateX(-3px);
}




.other-event-section {
    padding: 0 0 120px;
}

.other-event-heading {
    margin-bottom: 24px;
}

.other-event-eyebrow {
    margin: 0;
    color: var(--accent);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: .20em;
    text-transform: uppercase;
}

.other-event-title {
    margin: 7px 0 0;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(30px, 4vw, 44px);
    line-height: 1.1;
    font-weight: 700;
}

.other-event-subheader {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-top: 10px;
}

.other-event-subheader p {
    margin: 0;
    color: var(--text-muted);
    font-size: 13px;
}

.other-event-view-all {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    flex-shrink: 0;

    color: var(--text-secondary);
    text-decoration: none;
    font-size: 12px;

    transition: color var(--transition);
}

.other-event-view-all:hover {
    color: var(--accent);
}

.other-event-view-all svg {
    width: 16px;
    height: 16px;
}

.other-event-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 20px;
}

.other-event-card {
    overflow: hidden;
    display: flex;
    flex-direction: column;

    border: 1px solid var(--border-soft);
    border-radius: 20px;
    background: var(--bg-card);

    text-decoration: none;

    transition:
        transform var(--transition),
        border-color var(--transition),
        background var(--transition),
        box-shadow var(--transition);
}

.other-event-card:hover {
    transform: translateY(-6px);
    border-color: var(--border-gold-strong);
    background: var(--bg-secondary);
    box-shadow: var(--shadow-hover);
}

.other-event-image {
    position: relative;
    width: 100%;
    height: 195px;
    overflow: hidden;
    background: var(--bg-soft);
}

.other-event-image img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    transition: transform .5s cubic-bezier(.2,.7,.2,1);
}

.other-event-card:hover .other-event-image img {
    transform: scale(1.06);
}

.other-event-image-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        transparent 40%,
        rgba(10,10,10,.48)
    );
    pointer-events: none;
}

.other-event-date {
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

.other-event-date span {
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 21px;
    line-height: 1;
    font-weight: 700;
}

.other-event-date small {
    margin-top: 5px;
    color: var(--accent);
    font-size: 8px;
    font-weight: 700;
    letter-spacing: .10em;
}

.other-event-today {
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

.other-event-hover {
    position: absolute;
    left: 50%;
    bottom: 14px;

    padding: 7px 11px;

    border: 1px solid rgba(226,201,151,.28);
    border-radius: 999px;
    background: rgba(10,10,10,.72);

    color: var(--accent);
    font-size: 9px;
    font-weight: 600;

    opacity: 0;
    transform: translate(-50%, 6px);
    transition: opacity var(--transition), transform var(--transition);

    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.other-event-card:hover .other-event-hover {
    opacity: 1;
    transform: translate(-50%, 0);
}

.other-event-content {
    padding: 17px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.other-event-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
    color: var(--text-dim);
    font-size: 10px;
}

.other-event-content h3 {
    margin: 8px 0 0;
    color: var(--text-primary);
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 18px;
    line-height: 1.3;
    font-weight: 700;
}

.other-event-content p {
    display: -webkit-box;
    overflow: hidden;

    margin: 9px 0 0;

    color: var(--text-muted);
    font-size: 11px;
    line-height: 1.7;

    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

.other-event-bottom {
    margin-top: auto;
    padding-top: 16px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;

    border-top: 1px solid var(--border-soft);

    color: var(--text-secondary);
    font-size: 11px;
    font-weight: 600;
}

.other-event-arrow {
    width: 34px;
    height: 34px;
    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid var(--border-gold);
    border-radius: 10px;
    background: rgba(226,201,151,.055);
    color: var(--accent);

    transition: all var(--transition);
}

.other-event-arrow svg {
    width: 16px;
    height: 16px;
}

.other-event-card:hover .other-event-arrow {
    background: var(--accent);
    border-color: var(--accent);
    color: var(--bg-primary);
    transform: translateX(2px);
}

.other-event-mobile-action {
    display: none;
    margin-top: 22px;
}

.other-event-mobile-button {
    width: 100%;
    min-height: 48px;

    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    border: 1px solid var(--accent);
    border-radius: 999px;

    background: linear-gradient(135deg, var(--accent), var(--accent-hover));
    color: var(--bg-primary);

    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
}

.other-event-mobile-button svg {
    width: 16px;
    height: 16px;
}




@media (max-width: 1200px) {
    .event-detail-grid {
        gap: 50px;
    }

    .event-detail-image-wrapper,
    .event-detail-image {
        height: auto;
        min-height: 0;
    }

    .other-event-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 992px) {
    .event-detail-section {
        padding: 40px 0 90px;
    }

    .event-detail-grid {
        grid-template-columns: 1fr;
        gap: 45px;
    }

    .event-detail-image-column {
        position: relative;
        top: auto;
    }

    .event-detail-image-wrapper,
    .event-detail-image {
        height: auto;
        min-height: 0;
    }

    .event-detail-information {
        padding: 0;
    }

    .other-event-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .event-detail-breadcrumb {
        padding-top: 30px;
    }

    .event-detail-section {
        padding-top: 35px;
    }

    .event-detail-title {
        font-size: 44px;
    }

    .event-detail-image-wrapper,
    .event-detail-image {
        height: auto;
        min-height: 0;
    }

    .event-detail-info-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .other-event-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .other-event-image {
        height: 180px;
    }
}

@media (max-width: 640px) {
    .event-detail-breadcrumb-inner {
        font-size: 11px;
    }

    .event-detail-grid {
        gap: 35px;
    }

    .event-detail-image-wrapper {
        min-height: 0;
        height: auto;
        border-radius: 20px;
    }

    .event-detail-image {
        min-height: 0;
        height: auto;
    }

    .event-detail-image-date {
        left: 16px;
        bottom: 16px;
    }

    .event-detail-today {
        top: 16px;
        right: 16px;
    }

    .event-detail-title {
        font-size: 38px;
    }

    .event-detail-info-grid {
        grid-template-columns: 1fr;
    }

    .other-event-subheader {
        align-items: flex-start;
        flex-direction: column;
        gap: 10px;
    }

    .other-event-view-all {
        display: none;
    }

    .other-event-grid {
        grid-template-columns: 1fr;
    }

    .other-event-image {
        height: 225px;
    }

    .other-event-mobile-action {
        display: block;
    }
}

@media (max-width: 480px) {
    .event-detail-date-wrapper {
        padding: 12px;
    }

    .event-detail-date-value {
        font-size: 12px;
    }

    .event-back-button {
        width: 100%;
    }
}

@media (max-width: 420px) {
    .event-detail-title {
        font-size: 34px;
    }

    .event-detail-description {
        font-size: 13px;
    }

    .event-detail-image-wrapper,
    .event-detail-image {
        min-height: 0;
        height: auto;
    }

    .other-event-content {
        padding: 15px;
    }
}

    .event-detail-grid {
        align-items: center;
    }

    .event-detail-image-column {
        position: relative;
        top: auto;
        align-self: center;
    }

    .event-detail-image-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: auto;
        min-height: 0;
        padding: 0;
        background: transparent;
    }

    .event-detail-image {
        display: block;
        width: 100%;
        max-width: 100%;
        height: auto !important;
        min-height: 0 !important;
        max-height: none;
        object-fit: contain;
        object-position: center center;
        margin: 0 auto;
    }

    .event-detail-image-overlay {
        position: absolute;
        inset: 0;
        pointer-events: none;
    }

    @media (max-width: 992px) {
        .event-detail-grid {
            align-items: start;
        }

        .event-detail-image-wrapper {
            width: 100%;
            height: auto;
            min-height: 0;
        }

        .event-detail-image {
            width: 100%;
            height: auto !important;
        }
    }

</style>
@endpush
