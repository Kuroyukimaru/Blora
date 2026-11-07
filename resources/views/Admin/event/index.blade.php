<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kelola Event — Noyo Gimbal</title>


    {{-- GOOGLE FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap"
        rel="stylesheet"
    >


    {{-- FONT AWESOME --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    {{-- VITE --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>

    {{-- SIDEBAR --}}
    @include('Admin.partials.sidebar')


    
    <button
        type="button"
        class="admin-mobile-menu-button"
        id="openAdminSidebar"
        aria-controls="adminSidebar"
        aria-expanded="false"
        aria-label="Buka menu navigasi"
        title="Buka menu"
    >
        <span></span>
        <span></span>
        <span></span>
    </button>

<main class="admin-main">

        {{-- =========================================================
            MOBILE TOPBAR
        ========================================================== --}}
</div>


        {{-- =========================================================
            HEADER
        ========================================================== --}}

        <section class="top-section">

            <div class="header-text-wrapper">
<h1 class="dashboard-title">
                    Kelola Event
                </h1>

                <p class="dashboard-desc">
                    Kelola event yang akan datang dan informasi kegiatan Noyo Gimbal
                    Noyo Gimbal secara terpusat.
                </p>

            </div>


            <a
                href="{{ route('admin.event.create') }}"
                class="btn-add-event"
            >

                <span class="btn-add-icon">
                    <i class="fas fa-plus"></i>
                </span>

                <span>
                    Tambah Event
                </span>

            </a>

        </section>


        {{-- =========================================================
            ALERT SUCCESS
        ========================================================== --}}

        @if(session('success'))

            <div class="custom-alert alert-success">

                <div class="alert-icon">
                    <i class="fas fa-circle-check"></i>
                </div>

                <div class="alert-content">

                    <strong>
                        Berhasil
                    </strong>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove()"
                    aria-label="Tutup"
                >
                    <i class="fas fa-xmark"></i>
                </button>

            </div>

        @endif


        {{-- =========================================================
            ALERT ERROR
        ========================================================== --}}

        @if(session('error'))

            <div class="custom-alert alert-error">

                <div class="alert-icon">
                    <i class="fas fa-circle-exclamation"></i>
                </div>

                <div class="alert-content">

                    <strong>
                        Terjadi Kesalahan
                    </strong>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove()"
                    aria-label="Tutup"
                >
                    <i class="fas fa-xmark"></i>
                </button>

            </div>

        @endif


        {{-- =========================================================
            VALIDATION ERROR
        ========================================================== --}}

        @if($errors->any())

            <div class="custom-alert alert-error">

                <div class="alert-icon">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>

                <div class="alert-content">

                    <strong>
                        Periksa kembali data
                    </strong>

                    <div class="validation-list">

                        @foreach($errors->all() as $error)

                            <span>
                                {{ $error }}
                            </span>

                        @endforeach

                    </div>

                </div>

                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove()"
                    aria-label="Tutup"
                >
                    <i class="fas fa-xmark"></i>
                </button>

            </div>

        @endif


        {{-- =========================================================
            STATISTICS
        ========================================================== --}}

        @php

            $totalEvents = $events->count();

            $todayEvents = $events->filter(function ($event) {
                return $event->tanggal &&
                       $event->tanggal->isToday();
            })->count();

            $upcomingEvents = $events->filter(function ($event) {
                return $event->tanggal &&
                       $event->tanggal->isAfter(now()->startOfDay());
            })->count();

            $pastEvents = $events->filter(function ($event) {
                return $event->tanggal &&
                       $event->tanggal->isBefore(now()->startOfDay());
            })->count();

        @endphp


        <section class="statistics-grid">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="fas fa-calendar-days"></i>
                </div>

                <div class="stat-info">

                    <span class="stat-label">
                        Total Event
                    </span>

                    <strong class="stat-number">
                        {{ $totalEvents }}
                    </strong>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon today">
                    <i class="fas fa-calendar-day"></i>
                </div>

                <div class="stat-info">

                    <span class="stat-label">
                        Hari Ini
                    </span>

                    <strong class="stat-number">
                        {{ $todayEvents }}
                    </strong>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon upcoming">
                    <i class="fas fa-forward"></i>
                </div>

                <div class="stat-info">

                    <span class="stat-label">
                        Akan Datang
                    </span>

                    <strong class="stat-number">
                        {{ $upcomingEvents }}
                    </strong>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon past">
                    <i class="fas fa-clock-rotate-left"></i>
                </div>

                <div class="stat-info">

                    <span class="stat-label">
                        Selesai
                    </span>

                    <strong class="stat-number">
                        {{ $pastEvents }}
                    </strong>

                </div>

            </div>

        </section>


        {{-- =========================================================
            FILTER
        ========================================================== --}}

        <section class="filter-wrapper">

            <div class="search-wrapper">

                <i class="fas fa-magnifying-glass"></i>

                <input
                    type="search"
                    id="searchEvent"
                    placeholder="Cari judul event..."
                    autocomplete="off"
                >

                <button
                    type="button"
                    id="clearSearch"
                    class="clear-search"
                    aria-label="Hapus pencarian"
                >
                    <i class="fas fa-xmark"></i>
                </button>

            </div>


            <div class="filter-select-wrapper">

                <i class="fas fa-filter"></i>

                <select id="filterTanggal">

                    <option value="all">
                        Semua Event
                    </option>

                    <option value="upcoming">
                        Akan Datang
                    </option>

                    <option value="today">
                        Hari Ini
                    </option>

                    <option value="past">
                        Sudah Berlalu
                    </option>

                </select>

            </div>

<div class="per-page-control">
                <span class="per-page-label">Tampilkan</span>

                <select
                    id="perPage"
                    aria-label="Jumlah event yang ditampilkan"
                >
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                </select>

                <span class="per-page-label">data</span>
            </div>

        </section>


        {{-- =========================================================
            EVENT CONTAINER
        ========================================================== --}}

        <section class="event-container">


            {{-- =====================================================
                DESKTOP / TABLET TABLE
            ====================================================== --}}

            <div class="table-box">

                <div class="table-responsive">

                    <table class="event-table">

                        <thead>

                            <tr>

                                <th class="index-column">
                                    #
                                </th>

                                <th class="visual-column">
                                    Visual
                                </th>

                                <th>
                                    Event
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Deskripsi
                                </th>

                                <th class="action-column">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody id="eventTableBody">

                            @forelse($events as $key => $event)

                                @php

                                    $eventDate = $event->tanggal
                                        ? $event->tanggal->startOfDay()
                                        : null;

                                    if (!$eventDate) {
                                        $eventStatus = 'unknown';
                                    } elseif ($eventDate->isToday()) {
                                        $eventStatus = 'today';
                                    } elseif ($eventDate->isAfter(now()->startOfDay())) {
                                        $eventStatus = 'upcoming';
                                    } else {
                                        $eventStatus = 'past';
                                    }

                                @endphp


                                <tr
                                    class="event-row"
                                    data-id="{{ $event->id_event }}"
                                    data-title="{{ strtolower($event->judul) }}"
                                    data-status="{{ $eventStatus }}"
                                >

                                    {{-- INDEX --}}

                                    <td class="index-column">

                                        <span class="row-number">
                                            {{ sprintf('%02d', $key + 1) }}
                                        </span>

                                    </td>


                                    {{-- GAMBAR --}}

                                    <td class="visual-column">

                                        @if($event->hasGambar())

                                            <div class="event-image-wrapper">

                                                <img
                                                    src="{{ $event->gambar_url }}"
                                                    alt="{{ $event->judul }}"
                                                    class="event-image"
                                                    loading="lazy"
                                                >

                                            </div>

                                        @else

                                            <div class="event-image-placeholder">

                                                <i class="fas fa-calendar-star"></i>

                                            </div>

                                        @endif

                                    </td>


                                    {{-- EVENT --}}

                                    <td>

                                        <div class="event-information">

                                            <strong class="event-title">
                                                {{ $event->judul }}
                                            </strong>

                                            @if($eventStatus === 'today')

                                                <span class="event-status status-today">
                                                    <span></span>
                                                    Hari Ini
                                                </span>

                                            @elseif($eventStatus === 'upcoming')

                                                <span class="event-status status-upcoming">
                                                    <span></span>
                                                    Akan Datang
                                                </span>

                                            @elseif($eventStatus === 'past')

                                                <span class="event-status status-past">
                                                    <span></span>
                                                    Sudah Berlalu
                                                </span>

                                            @endif

                                        </div>

                                    </td>


                                    {{-- TANGGAL --}}

                                    <td>

                                        <div class="date-wrapper">

                                            <div class="date-icon">
                                                <i class="far fa-calendar"></i>
                                            </div>

                                            <div class="date-content">

                                                <strong>
                                                    {{ $event->tanggal?->format('d M Y') ?? '-' }}
                                                </strong>

                                                <span>
                                                    {{ $event->tanggal?->translatedFormat('l') ?? '-' }}
                                                </span>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- DESKRIPSI --}}

                                    <td>

                                        <div class="description-cell">

                                            {{ Str::limit(
                                                $event->deskripsi ?? 'Tidak ada deskripsi.',
                                                100
                                            ) }}

                                        </div>

                                    </td>


                                    {{-- ACTION --}}

                                    <td class="action-column">

                                        <div class="action-buttons">

                                            <a
                                                href="{{ route('admin.event.edit', $event->id_event) }}"
                                                class="action-button edit"
                                                title="Edit Event"
                                            >

                                                <i class="fas fa-pen"></i>

                                            </a>


                                            <button
                                                type="button"
                                                class="action-button delete"
                                                title="Hapus Event"
                                                onclick="openDeleteModal(
                                                    {{ $event->id_event }},
                                                    @js($event->judul)
                                                )"
                                            >

                                                <i class="fas fa-trash-can"></i>

                                            </button>

                                        </div>


                                        {{-- DELETE FORM --}}

                                        <form
                                            id="delete-form-{{ $event->id_event }}"
                                            action="{{ route('admin.event.destroy', $event->id_event) }}"
                                            method="POST"
                                            class="hidden-delete-form"
                                        >

                                            @csrf

                                            @method('DELETE')

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6">

                                        <div class="empty-state">

                                            <div class="empty-icon">
                                                <i class="fas fa-calendar-xmark"></i>
                                            </div>

                                            <h3>
                                                Belum Ada Event
                                            </h3>

                                            <p>
                                                Belum ada event atau berita
                                                yang tersimpan di dalam sistem.
                                            </p>

                                            <a
                                                href="{{ route('admin.event.create') }}"
                                                class="empty-button"
                                            >
                                                <i class="fas fa-plus"></i>
                                                Tambah Event
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- =====================================================
                MOBILE CARDS
            ====================================================== --}}

            <div
                class="mobile-event-list"
                id="mobileEventList"
            >

                @forelse($events as $key => $event)

                    @php

                        $eventDate = $event->tanggal
                            ? $event->tanggal->startOfDay()
                            : null;

                        if (!$eventDate) {
                            $mobileStatus = 'unknown';
                        } elseif ($eventDate->isToday()) {
                            $mobileStatus = 'today';
                        } elseif ($eventDate->isAfter(now()->startOfDay())) {
                            $mobileStatus = 'upcoming';
                        } else {
                            $mobileStatus = 'past';
                        }

                    @endphp


                    <article
                        class="event-card"
                        data-id="{{ $event->id_event }}"
                        data-title="{{ strtolower($event->judul) }}"
                        data-status="{{ $mobileStatus }}"
                    >

                        {{-- IMAGE --}}

                        <div class="mobile-card-image">

                            @if($event->hasGambar())

                                <img
                                    src="{{ $event->gambar_url }}"
                                    alt="{{ $event->judul }}"
                                    loading="lazy"
                                >

                            @else

                                <div class="mobile-image-placeholder">
                                    <i class="fas fa-calendar-star"></i>
                                </div>

                            @endif


                            {{-- STATUS --}}

                            @if($mobileStatus === 'today')

                                <span class="mobile-status today">
                                    Hari Ini
                                </span>

                            @elseif($mobileStatus === 'upcoming')

                                <span class="mobile-status upcoming">
                                    Akan Datang
                                </span>

                            @elseif($mobileStatus === 'past')

                                <span class="mobile-status past">
                                    Sudah Berlalu
                                </span>

                            @endif

                        </div>


                        {{-- CONTENT --}}

                        <div class="mobile-card-content">

                            <span class="mobile-card-number">
                                EVENT #{{ sprintf('%02d', $key + 1) }}
                            </span>

                            <h3>
                                {{ $event->judul }}
                            </h3>


                            <div class="mobile-date">

                                <i class="far fa-calendar"></i>

                                <span>
                                    {{ $event->tanggal?->format('d M Y') ?? '-' }}
                                </span>

                            </div>


                            <p>
                                {{ Str::limit(
                                    $event->deskripsi ?? 'Tidak ada deskripsi.',
                                    120
                                ) }}
                            </p>


                            {{-- ACTION --}}

                            <div class="mobile-card-actions">

                                <a
                                    href="{{ route('admin.event.edit', $event->id_event) }}"
                                    class="mobile-action edit"
                                >
                                    <i class="fas fa-pen"></i>
                                    Edit
                                </a>


                                <button
                                    type="button"
                                    class="mobile-action delete"
                                    onclick="openDeleteModal(
                                        {{ $event->id_event }},
                                        @js($event->judul)
                                    )"
                                >
                                    <i class="fas fa-trash-can"></i>
                                    Hapus
                                </button>

                            </div>

                        </div>


                        <form
                            id="mobile-delete-form-{{ $event->id_event }}"
                            action="{{ route('admin.event.destroy', $event->id_event) }}"
                            method="POST"
                            class="hidden-delete-form"
                        >

                            @csrf

                            @method('DELETE')

                        </form>

                    </article>

                @empty

                    <div class="mobile-empty-state">

                        <div class="empty-icon">
                            <i class="fas fa-calendar-xmark"></i>
                        </div>

                        <h3>
                            Belum Ada Event
                        </h3>

                        <p>
                            Belum ada event atau berita yang tersimpan.
                        </p>

                        <a
                            href="{{ route('admin.event.create') }}"
                            class="empty-button"
                        >
                            <i class="fas fa-plus"></i>
                            Tambah Event
                        </a>

                    </div>

                @endforelse

            </div>



            <div class="data-summary-bottom">
                <span id="resultCount">
                    {{ $totalEvents }} event
                </span>
            </div>


            {{-- =====================================================
                NO SEARCH RESULT
            ====================================================== --}}

            <div
                id="noSearchResult"
                class="no-search-result"
            >

                <div class="empty-icon">
                    <i class="fas fa-magnifying-glass"></i>
                </div>

                <h3>
                    Event Tidak Ditemukan
                </h3>

                <p>
                    Tidak ada event yang sesuai dengan pencarian atau filter.
                </p>

            </div>


        </section>


        {{-- =========================================================
            PAGINATION
        ========================================================== --}}

        <div
            class="pagination-wrapper"
            id="paginationWrapper"
        >

            <button
                type="button"
                id="prevPage"
                class="pagination-arrow"
                disabled
            >
                <i class="fas fa-chevron-left"></i>
            </button>


            <div
                id="paginationNumbers"
                class="pagination-numbers"
            ></div>


            <button
                type="button"
                id="nextPage"
                class="pagination-arrow"
            >
                <i class="fas fa-chevron-right"></i>
            </button>

        </div>

    </main>


    {{-- =============================================================
        DELETE MODAL
    ============================================================= --}}

    <div
        class="modal-overlay"
        id="deleteModal"
    >

        <div class="delete-modal">

            <button
                type="button"
                class="modal-close"
                onclick="closeDeleteModal()"
            >
                <i class="fas fa-xmark"></i>
            </button>


            <div class="delete-icon">

                <i class="fas fa-trash-can"></i>

            </div>


            <span class="modal-label">
                KONFIRMASI
            </span>


            <h3>
                Hapus Event?
            </h3>


            <p>
                Kamu akan menghapus event
                <strong id="deleteEventName"></strong>.
                Data yang sudah dihapus tidak dapat dikembalikan.
            </p>


            <div class="modal-actions">

                <button
                    type="button"
                    class="modal-cancel"
                    onclick="closeDeleteModal()"
                >
                    Batal
                </button>


                <button
                    type="button"
                    class="modal-confirm"
                    id="confirmDeleteButton"
                >
                    <i class="fas fa-trash-can"></i>
                    Ya, Hapus
                </button>

            </div>

        </div>

    </div>


    {{-- =============================================================
        STYLE
    ============================================================= --}}

    
<style>
/* =========================================================
   NOYO GIMBAL — EVENT MANAGEMENT
   MODERN • ELEGANT • RESPONSIVE • READABLE
   Design system: charcoal + warm champagne gold
========================================================= */

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

    --success:#9bc9a7;
    --danger:#e29a9a;
    --white:#fff;
    --black:#000;

    --shadow-soft:0 20px 60px rgba(0,0,0,.40);
    --shadow-hover:0 25px 70px rgba(0,0,0,.50);

    --radius-lg:28px;
    --radius-md:16px;
    --radius-sm:14px;
    --radius-full:999px;

    --transition:.25s cubic-bezier(.4,0,.2,1);

    --sidebar-width:270px;
    --content-max:1500px;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    min-height:100vh;
    background:
        radial-gradient(
            circle at 86% 0%,
            rgba(226,201,151,.055),
            transparent 28%
        ),
        radial-gradient(
            circle at 4% 95%,
            rgba(226,201,151,.02),
            transparent 24%
        ),
        var(--bg-primary);

    color:var(--text-primary);
    font-family:'Inter',sans-serif;
    font-size:15px;
    line-height:1.65;
    overflow-x:hidden;
}

body,
button,
input,
select,
textarea{
    font-family:'Inter',sans-serif;
}

button,
input,
select,
textarea{
    font-size:inherit;
}

button,
a,
input,
select,
textarea{
    -webkit-tap-highlight-color:transparent;
}

a{
    color:inherit;
    text-decoration:none;
}

::selection{
    background:rgba(226,201,151,.23);
    color:var(--text-primary);
}

/* =========================================================
   MAIN LAYOUT
========================================================= */

.admin-main{
    width:calc(100% - var(--sidebar-width));
    min-height:100vh;
    margin-left:var(--sidebar-width);
    padding:52px 48px 72px;
}

.top-section{
    width:100%;
    max-width:var(--content-max);
    margin:0 auto 34px;

    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:28px;
}

.header-text-wrapper{
    min-width:0;
    max-width:850px;
}

.dashboard-title{
    margin:0;

    font-family:'Playfair Display',Georgia,serif;
    font-size:clamp(40px,4.2vw,60px);
    line-height:1.06;
    font-weight:700;
    letter-spacing:-1.4px;

    background:
        linear-gradient(
            135deg,
            var(--accent) 0%,
            var(--text-primary) 47%,
            var(--accent-dark) 100%
        );

    -webkit-background-clip:text;
    background-clip:text;
    -webkit-text-fill-color:transparent;
}

.dashboard-desc{
    max-width:760px;
    margin-top:12px;

    color:var(--text-muted);
    font-size:16px;
    line-height:1.75;
}

/* =========================================================
   ADD EVENT BUTTON
========================================================= */

.btn-add-event{
    flex:0 0 auto;

    min-height:56px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;

    padding:0 24px;

    border:1px solid rgba(226,201,151,.62);
    border-radius:var(--radius-full);

    background:
        linear-gradient(
            135deg,
            var(--accent) 0%,
            var(--accent-hover) 100%
        );

    color:var(--bg-primary);
    font-size:15px;
    font-weight:800;

    box-shadow:0 12px 34px rgba(0,0,0,.25);

    transition:
        transform var(--transition),
        box-shadow var(--transition),
        filter var(--transition);
}

.btn-add-event:hover{
    transform:translateY(-3px);
    box-shadow:var(--shadow-hover);
    filter:brightness(1.03);
}

.btn-add-icon{
    width:32px;
    height:32px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid rgba(10,10,10,.10);
    border-radius:50%;

    background:rgba(10,10,10,.08);
}

/* =========================================================
   ALERTS
========================================================= */

.custom-alert{
    width:100%;
    max-width:var(--content-max);
    margin:0 auto 22px;

    display:flex;
    align-items:flex-start;
    gap:13px;

    padding:16px 18px;

    border:1px solid var(--border-soft);
    border-radius:var(--radius-md);

    background:rgba(255,255,255,.028);

    box-shadow:0 12px 35px rgba(0,0,0,.18);

    animation:alertIn .3s ease;
}

@keyframes alertIn{
    from{
        opacity:0;
        transform:translateY(-8px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.alert-success{
    border-color:rgba(155,201,167,.18);
    background:rgba(155,201,167,.055);
}

.alert-error{
    border-color:rgba(226,154,154,.18);
    background:rgba(226,154,154,.055);
}

.alert-icon{
    width:38px;
    height:38px;
    flex:0 0 38px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid rgba(255,255,255,.05);
    border-radius:12px;

    background:rgba(255,255,255,.035);
}

.alert-success .alert-icon{
    color:var(--success);
}

.alert-error .alert-icon{
    color:var(--danger);
}

.alert-content{
    min-width:0;
    flex:1;

    display:flex;
    flex-direction:column;
    gap:2px;
}

.alert-content strong{
    font-size:14px;
    font-weight:800;
}

.alert-content span,
.validation-list span{
    color:var(--text-secondary);
    font-size:14px;
    line-height:1.6;
}

.validation-list{
    display:flex;
    flex-direction:column;
    gap:2px;
}

.alert-close{
    width:38px;
    height:38px;
    flex:0 0 38px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid transparent;
    border-radius:11px;

    background:transparent;
    color:var(--text-muted);
    cursor:pointer;

    transition:all var(--transition);
}

.alert-close:hover{
    border-color:var(--border-soft);
    background:rgba(255,255,255,.04);
    color:var(--text-primary);
}

/* =========================================================
   STATISTICS
========================================================= */

.statistics-grid{
    width:100%;
    max-width:var(--content-max);
    margin:0 auto 26px;

    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:15px;
}

.stat-card{
    position:relative;
    overflow:hidden;

    min-height:112px;

    display:flex;
    align-items:center;
    gap:15px;

    padding:20px;

    border:1px solid var(--border-soft);
    border-radius:var(--radius-md);

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.035),
            rgba(255,255,255,.012)
        ),
        var(--bg-card);

    box-shadow:0 10px 32px rgba(0,0,0,.12);

    transition:
        transform var(--transition),
        border-color var(--transition),
        box-shadow var(--transition);
}

.stat-card::after{
    content:"";

    position:absolute;
    width:130px;
    height:130px;

    right:-72px;
    bottom:-72px;

    border:1px solid rgba(226,201,151,.06);
    border-radius:50%;
}

.stat-card:hover{
    transform:translateY(-4px);
    border-color:var(--border-gold);
    box-shadow:var(--shadow-soft);
}

.stat-icon{
    width:50px;
    height:50px;
    flex:0 0 50px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid rgba(226,201,151,.12);
    border-radius:14px;

    background:rgba(226,201,151,.08);
    color:var(--accent);
    font-size:17px;
}

.stat-icon.today{
    color:#a9cfff;
    background:rgba(96,165,250,.08);
    border-color:rgba(96,165,250,.12);
}

.stat-icon.upcoming{
    color:var(--success);
    background:rgba(155,201,167,.08);
    border-color:rgba(155,201,167,.12);
}

.stat-icon.past{
    color:#c4c0ba;
    background:rgba(161,161,170,.07);
    border-color:rgba(161,161,170,.10);
}

.stat-info{
    min-width:0;

    display:flex;
    flex-direction:column;
    gap:3px;
}

.stat-label{
    color:var(--text-muted);
    font-size:13px;
    font-weight:700;
}

.stat-number{
    color:var(--text-primary);
    font-size:30px;
    line-height:1;
    font-weight:800;
    letter-spacing:-.6px;
}

/* =========================================================
   FILTER
========================================================= */

.filter-wrapper{
    width:100%;
    max-width:var(--content-max);
    margin:0 auto 18px;

    display:grid;
    grid-template-columns:minmax(0,1fr) 235px auto;
    gap:12px;
    align-items:center;
}

.search-wrapper,
.filter-select-wrapper{
    position:relative;

    height:56px;

    border:1px solid var(--border-soft);
    border-radius:var(--radius-md);

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.035),
            rgba(255,255,255,.012)
        );

    transition:
        border-color var(--transition),
        background var(--transition),
        box-shadow var(--transition);
}

.search-wrapper:focus-within,
.filter-select-wrapper:focus-within{
    border-color:rgba(226,201,151,.55);
    background:rgba(226,201,151,.035);
    box-shadow:0 0 0 3px rgba(226,201,151,.055);
}

.search-wrapper > i,
.filter-select-wrapper > i{
    position:absolute;
    top:50%;
    transform:translateY(-50%);

    color:var(--text-dim);
    font-size:15px;
    pointer-events:none;
}

.search-wrapper > i{
    left:18px;
}

.search-wrapper input{
    width:100%;
    height:100%;

    padding:0 50px;

    border:0;
    outline:0;

    background:transparent;
    color:var(--text-primary);

    font-size:16px;
}

.search-wrapper input::placeholder{
    color:var(--text-dim);
}

.clear-search{
    position:absolute;
    top:50%;
    right:10px;
    transform:translateY(-50%);

    width:36px;
    height:36px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid transparent;
    border-radius:10px;

    background:transparent;
    color:var(--text-muted);

    cursor:pointer;

    opacity:0;
    pointer-events:none;

    transition:all var(--transition);
}

.clear-search.show{
    opacity:1;
    pointer-events:auto;
}

.clear-search:hover{
    border-color:var(--border-soft);
    background:rgba(255,255,255,.045);
    color:var(--accent);
}

.filter-select-wrapper > i{
    left:18px;
}

.filter-select-wrapper select{
    width:100%;
    height:100%;

    appearance:none;

    padding:0 44px;

    border:0;
    outline:0;

    background:transparent;
    color:var(--text-secondary);

    font-size:15px;
    font-weight:700;

    cursor:pointer;
}

.filter-select-wrapper select option{
    background:#161616;
    color:var(--text-primary);
}
/* =========================================================
   EVENT CONTAINER / TABLE
========================================================= */

.event-container{
    width:100%;
    max-width:var(--content-max);
    margin:0 auto;
}

.table-box{
    width:100%;

    overflow:hidden;

    border:1px solid var(--border-soft);
    border-radius:var(--radius-lg);

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.028),
            rgba(255,255,255,.008)
        ),
        var(--bg-card);

    box-shadow:var(--shadow-soft);
}

.table-responsive{
    width:100%;
    overflow-x:auto;
    scrollbar-color:rgba(226,201,151,.22) transparent;
    scrollbar-width:thin;
}

.table-responsive::-webkit-scrollbar{
    height:7px;
}

.table-responsive::-webkit-scrollbar-track{
    background:transparent;
}

.table-responsive::-webkit-scrollbar-thumb{
    background:rgba(226,201,151,.22);
    border-radius:999px;
}

.event-table{
    width:100%;
    min-width:1040px;
    border-collapse:collapse;
}

.event-table th{
    padding:18px 20px;

    border-bottom:1px solid rgba(226,201,151,.14);

    background:rgba(0,0,0,.12);

    color:var(--text-dim);
    font-size:11px;
    font-weight:800;
    letter-spacing:1.3px;

    text-align:left;
    text-transform:uppercase;
    white-space:nowrap;
}

.event-table td{
    padding:19px 20px;

    border-bottom:1px solid var(--border-soft);

    vertical-align:middle;
}

.event-table tbody tr{
    transition:background var(--transition);
}

.event-table tbody tr:hover{
    background:rgba(226,201,151,.025);
}

.event-table tbody tr:last-child td{
    border-bottom:0;
}

.index-column{
    width:58px;
    text-align:center !important;
}

.visual-column{
    width:116px;
}

.action-column{
    width:122px;
    text-align:center !important;
}

.row-number{
    color:var(--text-dim);
    font-family:ui-monospace,SFMono-Regular,Menlo,monospace;
    font-size:13px;
}

.event-image-wrapper,
.event-image-placeholder{
    width:92px;
    height:66px;

    overflow:hidden;

    border:1px solid var(--border-soft);
    border-radius:12px;

    background:var(--bg-soft);
}

.event-image-wrapper{
    transition:transform var(--transition);
}

.event-table tr:hover .event-image-wrapper{
    transform:scale(1.025);
}

.event-image{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.event-image-placeholder{
    display:flex;
    align-items:center;
    justify-content:center;

    color:var(--accent);
    font-size:20px;
}

.event-information{
    min-width:170px;

    display:flex;
    flex-direction:column;
    align-items:flex-start;
    gap:7px;
}

.event-title{
    max-width:270px;

    color:var(--text-primary);
    font-size:15px;
    font-weight:800;
    line-height:1.45;

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.event-status{
    display:inline-flex;
    align-items:center;
    gap:7px;

    font-size:11px;
    font-weight:700;
}

.event-status > span{
    width:7px;
    height:7px;
    flex:0 0 7px;

    border-radius:50%;
}

.status-today{
    color:#a9cfff;
}

.status-today > span{
    background:#76adff;
}

.status-upcoming{
    color:var(--success);
}

.status-upcoming > span{
    background:#81cf98;
}

.status-past{
    color:var(--text-dim);
}

.status-past > span{
    background:var(--text-dim);
}

.date-wrapper{
    display:flex;
    align-items:center;
    gap:10px;
}

.date-icon{
    width:36px;
    height:36px;
    flex:0 0 36px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid rgba(226,201,151,.08);
    border-radius:10px;

    background:rgba(226,201,151,.06);
    color:var(--accent);
}

.date-content{
    display:flex;
    flex-direction:column;
    gap:2px;
}

.date-content strong{
    color:var(--text-secondary);
    font-size:14px;
    white-space:nowrap;
}

.date-content span{
    color:var(--text-dim);
    font-size:12px;
}

.description-cell{
    max-width:340px;

    color:var(--text-muted);
    font-size:13px;
    line-height:1.65;

    display:-webkit-box;
    -webkit-line-clamp:3;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.action-buttons{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
}

.action-button{
    width:42px;
    height:42px;

    display:inline-flex;
    align-items:center;
    justify-content:center;

    border:1px solid var(--border-soft);
    border-radius:12px;

    background:rgba(255,255,255,.025);

    cursor:pointer;

    transition:all var(--transition);
}

.action-button:hover{
    transform:translateY(-2px);
}

.action-button.edit{
    color:var(--text-secondary);
}

.action-button.edit:hover{
    border-color:rgba(226,201,151,.35);
    background:rgba(226,201,151,.07);
    color:var(--accent);
}

.action-button.delete{
    color:#e8aaaa;
}

.action-button.delete:hover{
    border-color:rgba(226,120,120,.30);
    background:rgba(226,120,120,.06);
    color:#ef8c8c;
}

.hidden-delete-form{
    display:none;
}

/* =========================================================
   MOBILE EVENT CARDS
========================================================= */

.mobile-event-list{
    display:none;
}

.event-card{
    overflow:hidden;

    border:1px solid var(--border-soft);
    border-radius:var(--radius-md);

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.035),
            rgba(255,255,255,.012)
        ),
        var(--bg-card);

    box-shadow:0 15px 45px rgba(0,0,0,.18);
}

.mobile-card-image{
    position:relative;

    width:100%;
    height:220px;

    overflow:hidden;

    background:var(--bg-soft);
}

.mobile-card-image img{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.mobile-image-placeholder{
    width:100%;
    height:100%;

    display:flex;
    align-items:center;
    justify-content:center;

    color:var(--accent);
    font-size:36px;

    background:
        radial-gradient(
            circle at 50% 40%,
            rgba(226,201,151,.09),
            transparent 52%
        ),
        var(--bg-soft);
}

.mobile-status{
    position:absolute;
    top:14px;
    right:14px;

    padding:7px 11px;

    border:1px solid rgba(255,255,255,.08);
    border-radius:var(--radius-full);

    background:rgba(10,10,10,.72);
    color:var(--text-primary);

    backdrop-filter:blur(10px);

    font-size:12px;
    font-weight:800;
}

.mobile-status.today{
    color:#a9cfff;
}

.mobile-status.upcoming{
    color:var(--success);
}

.mobile-status.past{
    color:var(--text-muted);
}

.mobile-card-content{
    padding:19px;
}

.mobile-card-number{
    display:block;
    margin-bottom:7px;

    color:var(--accent);
    font-size:11px;
    font-weight:800;
    letter-spacing:1.1px;
}

.mobile-card-content h3{
    margin:0;

    color:var(--text-primary);
    font-family:'Playfair Display',Georgia,serif;
    font-size:24px;
    line-height:1.25;
}

.mobile-date{
    display:flex;
    align-items:center;
    gap:8px;

    margin-top:13px;

    color:var(--text-secondary);
    font-size:14px;
    font-weight:700;
}

.mobile-date i{
    color:var(--accent);
}

.mobile-card-content > p{
    margin-top:12px;

    color:var(--text-muted);
    font-size:14px;
    line-height:1.7;

    display:-webkit-box;
    -webkit-line-clamp:4;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.mobile-card-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:9px;

    margin-top:17px;
}

.mobile-action{
    min-height:52px;

    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    border:1px solid var(--border-soft);
    border-radius:13px;

    background:rgba(255,255,255,.025);

    font-size:14px;
    font-weight:800;

    cursor:pointer;

    transition:all var(--transition);
}

.mobile-action.edit{
    color:var(--accent);
}

.mobile-action.delete{
    color:#e8aaaa;
}

.mobile-action:hover{
    transform:translateY(-2px);
}

.mobile-action.edit:hover{
    border-color:rgba(226,201,151,.34);
    background:rgba(226,201,151,.06);
}

.mobile-action.delete:hover{
    border-color:rgba(226,120,120,.28);
    background:rgba(226,120,120,.055);
}

/* =========================================================
   EMPTY STATES
========================================================= */

.empty-state,
.mobile-empty-state{
    padding:78px 24px;
    text-align:center;
}

.empty-icon{
    width:68px;
    height:68px;

    margin:0 auto 18px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid var(--border-gold);
    border-radius:20px;

    background:rgba(226,201,151,.055);
    color:var(--accent);

    font-size:24px;
}

.empty-state h3,
.mobile-empty-state h3{
    margin:0 0 8px;

    color:var(--text-primary);
    font-family:'Playfair Display',Georgia,serif;
    font-size:27px;
    line-height:1.25;
}

.empty-state p,
.mobile-empty-state p{
    max-width:470px;

    margin:0 auto 22px;

    color:var(--text-muted);
    font-size:15px;
    line-height:1.75;
}

.empty-button{
    min-height:50px;

    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    padding:0 18px;

    border:1px solid rgba(226,201,151,.30);
    border-radius:13px;

    background:rgba(226,201,151,.055);
    color:var(--accent);

    font-size:14px;
    font-weight:800;
}

/* Search no result */
.no-search-result{
    display:none;

    margin-top:16px;
    padding:65px 20px;

    text-align:center;

    border:1px solid var(--border-soft);
    border-radius:var(--radius-lg);

    background:rgba(255,255,255,.015);
}

.no-search-result.show{
    display:block;
}

.no-search-result h3{
    margin:0 0 8px;

    color:var(--text-primary);
    font-family:'Playfair Display',Georgia,serif;
    font-size:25px;
}

.no-search-result p{
    margin:0;

    color:var(--text-muted);
    font-size:14px;
}

/* =========================================================
   PAGINATION
========================================================= */

.pagination-wrapper{
    width:100%;
    max-width:var(--content-max);

    display:none;
    align-items:center;
    justify-content:center;
    gap:7px;

    margin:20px auto 0;
}

.pagination-numbers{
    display:flex;
    align-items:center;
    gap:6px;
}

.pagination-arrow,
.pagination-number{
    width:42px;
    height:42px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid var(--border-soft);
    border-radius:12px;

    background:rgba(255,255,255,.025);
    color:var(--text-muted);

    cursor:pointer;

    font-size:14px;
    font-weight:800;

    transition:all var(--transition);
}

.pagination-arrow:hover:not(:disabled),
.pagination-number:hover{
    border-color:rgba(226,201,151,.32);
    color:var(--accent);
    background:rgba(226,201,151,.045);
    transform:translateY(-1px);
}

.pagination-number.active{
    border-color:rgba(226,201,151,.50);
    background:rgba(226,201,151,.10);
    color:var(--accent);
}

.pagination-arrow:disabled{
    opacity:.35;
    cursor:not-allowed;
}

/* =========================================================
   DELETE MODAL
========================================================= */

.modal-overlay{
    position:fixed;
    inset:0;
    z-index:9999;

    display:none;
    align-items:center;
    justify-content:center;

    padding:20px;

    background:rgba(0,0,0,.76);
    backdrop-filter:blur(9px);
}

.modal-overlay.active{
    display:flex;
    animation:modalFade .2s ease;
}

@keyframes modalFade{
    from{opacity:0;}
    to{opacity:1;}
}

.delete-modal{
    position:relative;

    width:min(500px,100%);

    padding:34px;

    border:1px solid rgba(226,201,151,.16);
    border-radius:24px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.04),
            rgba(255,255,255,.012)
        ),
        #101010;

    box-shadow:0 30px 100px rgba(0,0,0,.58);

    text-align:center;
    animation:modalUp .25s ease;
}

@keyframes modalUp{
    from{
        opacity:0;
        transform:translateY(14px) scale(.985);
    }
    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }
}

.modal-close{
    position:absolute;
    top:15px;
    right:15px;

    width:40px;
    height:40px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid var(--border-soft);
    border-radius:11px;

    background:rgba(255,255,255,.035);
    color:var(--text-muted);

    cursor:pointer;

    transition:all var(--transition);
}

.modal-close:hover{
    border-color:var(--border-gold);
    background:rgba(226,201,151,.06);
    color:var(--accent);
}

.delete-icon{
    width:68px;
    height:68px;

    margin:0 auto 18px;

    display:flex;
    align-items:center;
    justify-content:center;

    border:1px solid rgba(226,154,154,.16);
    border-radius:20px;

    background:rgba(226,120,120,.065);
    color:#e78e8e;

    font-size:24px;
}

.modal-label{
    color:#e78e8e;
    font-size:11px;
    font-weight:800;
    letter-spacing:2px;
}

.delete-modal h3{
    margin:9px 0 11px;

    color:var(--text-primary);
    font-family:'Playfair Display',Georgia,serif;
    font-size:30px;
    line-height:1.2;
}

.delete-modal p{
    max-width:390px;

    margin:0 auto;

    color:var(--text-muted);
    font-size:15px;
    line-height:1.75;
}

.delete-modal p strong{
    color:var(--text-secondary);
}

.modal-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;

    margin-top:26px;
}

.modal-cancel,
.modal-confirm{
    min-height:52px;

    border-radius:13px;

    font-size:14px;
    font-weight:800;

    cursor:pointer;

    transition:all var(--transition);
}

.modal-cancel{
    border:1px solid var(--border-soft);
    background:rgba(255,255,255,.035);
    color:var(--text-secondary);
}

.modal-cancel:hover{
    border-color:var(--border-gold);
    background:rgba(226,201,151,.055);
    color:var(--accent);
}

.modal-confirm{
    border:1px solid rgba(226,120,120,.26);
    background:rgba(226,120,120,.10);
    color:#ef9a9a;
}

.modal-confirm:hover{
    background:rgba(226,120,120,.17);
    transform:translateY(-1px);
}

/* =========================================================
   MOBILE SIDEBAR — SAMA DENGAN REFERENSI
========================================================= */

@media (max-width:900px){

    .admin-sidebar{
        position:fixed !important;

        top:14px !important;
        left:18px !important;
        right:auto !important;
        bottom:14px !important;

        width:min(320px,calc(100vw - 36px)) !important;
        height:calc(100dvh - 28px) !important;
        max-height:calc(100dvh - 28px) !important;
        min-height:0 !important;

        border:1px solid rgba(226,201,151,.16) !important;
        border-radius:20px !important;

        background:
            linear-gradient(
                180deg,
                rgba(19,19,19,.94) 0%,
                rgba(9,9,9,.90) 100%
            ) !important;

        backdrop-filter:blur(24px) saturate(120%) !important;
        -webkit-backdrop-filter:blur(24px) saturate(120%) !important;

        box-shadow:
            24px 0 70px rgba(0,0,0,.42),
            0 18px 48px rgba(0,0,0,.28),
            inset 0 1px 0 rgba(255,255,255,.025) !important;

        overflow:hidden !important;
        isolation:isolate !important;

        transform:translate3d(calc(-100% - 30px),0,0) !important;
        transition:transform .30s cubic-bezier(.4,0,.2,1) !important;

        z-index:2100 !important;
    }

    .admin-sidebar.open{
        transform:translate3d(0,0,0) !important;
    }

    .admin-sidebar-brand{
        position:relative !important;
        min-height:80px !important;
        padding:17px 12px 13px !important;

        border-bottom:1px solid rgba(255,255,255,.055) !important;
        background:rgba(0,0,0,.07) !important;
    }

    .admin-brand-link{
        display:flex !important;
        align-items:center !important;
        gap:11px !important;
        width:100% !important;
        min-width:0 !important;
        padding-right:52px !important;
    }

    .admin-brand-logo{
        width:45px !important;
        height:45px !important;
        flex:0 0 45px !important;
        border-radius:12px !important;
    }

    .admin-brand-text{
        min-width:0 !important;
    }

    .admin-brand-text strong{
        display:block !important;
        color:#f8f4ed !important;
        font-family:'Playfair Display',Georgia,serif !important;
        font-size:18px !important;
        font-weight:700 !important;
        line-height:1.15 !important;
        white-space:nowrap !important;
        overflow:hidden !important;
        text-overflow:ellipsis !important;
    }

    .admin-brand-text span{
        display:block !important;
        margin-top:4px !important;
        color:#e2c997 !important;
        font-size:8.5px !important;
        font-weight:800 !important;
        line-height:1 !important;
        letter-spacing:1.35px !important;
    }

    .admin-sidebar-close-button{
        display:flex !important;
        position:absolute !important;
        top:14px !important;
        right:12px !important;
        width:40px !important;
        height:40px !important;

        align-items:center !important;
        justify-content:center !important;

        border:1px solid rgba(226,201,151,.14) !important;
        border-radius:11px !important;
        background:rgba(255,255,255,.035) !important;
        color:#e2c997 !important;

        cursor:pointer !important;
        z-index:5 !important;
    }

    .admin-sidebar-user{
        margin:11px 12px 10px !important;
        padding:10px !important;

        border:1px solid rgba(226,201,151,.10) !important;
        border-radius:14px !important;

        background:rgba(255,255,255,.028) !important;
    }

    .admin-user-avatar{
        width:40px !important;
        height:40px !important;
        flex:0 0 40px !important;
        border-radius:12px !important;
    }

    .admin-user-info{
        min-width:0 !important;
    }

    .admin-user-info strong{
        font-size:14px !important;
    }

    .admin-user-info span{
        font-size:12px !important;
    }

    .admin-sidebar-nav{
        min-height:0 !important;
        padding:0 9px 8px !important;

        overflow-x:hidden !important;
        overflow-y:auto !important;

        scrollbar-width:thin !important;
        scrollbar-color:rgba(226,201,151,.20) transparent !important;
    }

    .admin-sidebar-nav::-webkit-scrollbar{
        width:4px !important;
    }

    .admin-sidebar-nav::-webkit-scrollbar-thumb{
        background:rgba(226,201,151,.20) !important;
        border-radius:999px !important;
    }

    .admin-nav-title{
        margin:14px 9px 6px !important;

        color:#8f8578 !important;
        font-size:10px !important;
        font-weight:800 !important;
        letter-spacing:1.35px !important;
    }

    .admin-nav-link{
        min-height:50px !important;
        margin:2px 0 !important;
        padding:0 8px !important;
        border-radius:11px !important;
    }

    .admin-nav-icon{
        width:36px !important;
        height:36px !important;
        flex:0 0 36px !important;
        border-radius:11px !important;
        font-size:13px !important;
    }

    .admin-nav-text{
        font-size:14.5px !important;
    }

    .admin-sidebar-footer{
        padding:
            9px
            11px
            max(11px,env(safe-area-inset-bottom))
            !important;

        border-top:1px solid rgba(255,255,255,.055) !important;
        background:
            linear-gradient(
                180deg,
                rgba(0,0,0,.12),
                rgba(0,0,0,.28)
            ) !important;
    }

    .admin-system-status{
        min-height:39px !important;
        padding:0 10px !important;
        margin:0 0 6px !important;
        border-radius:10px !important;
        font-size:11px !important;
    }

    .admin-logout-button{
        min-height:43px !important;
        padding:0 9px !important;
        font-size:13.5px !important;
    }

    .admin-sidebar-copyright{
        margin-top:5px !important;
        padding:8px 2px 0 !important;
        border-top:1px solid rgba(255,255,255,.045) !important;
        font-size:9px !important;
    }

    .admin-sidebar-copyright small{
        font-size:9px !important;
    }

    .admin-sidebar-overlay{
        position:fixed !important;
        inset:0 !important;

        z-index:2050 !important;

        background:rgba(0,0,0,.42) !important;
        backdrop-filter:blur(3px) !important;
        -webkit-backdrop-filter:blur(3px) !important;

        opacity:0 !important;
        pointer-events:none !important;

        transition:opacity .25s ease !important;
    }

    .admin-sidebar-overlay.show{
        opacity:1 !important;
        pointer-events:auto !important;
    }

    body.admin-sidebar-open{
        overflow:hidden !important;
    }

    /* Hamburger referensi */
    .admin-mobile-menu-button{
        position:fixed !important;

        top:14px !important;
        left:14px !important;
        right:auto !important;

        width:46px !important;
        height:46px !important;

        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        flex-direction:column !important;
        gap:5px !important;

        padding:0 !important;

        z-index:2000 !important;

        border:1px solid rgba(226,201,151,.20) !important;
        border-radius:13px !important;

        background:
            linear-gradient(
                145deg,
                rgba(226,201,151,.10),
                rgba(255,255,255,.025)
            ),
            rgba(12,12,12,.94) !important;

        color:#e2c997 !important;

        box-shadow:
            0 12px 35px rgba(0,0,0,.34),
            inset 0 1px 0 rgba(255,255,255,.045) !important;

        backdrop-filter:blur(17px) !important;
        -webkit-backdrop-filter:blur(17px) !important;

        cursor:pointer !important;
    }

    .admin-mobile-menu-button span{
        display:block !important;
        width:19px !important;
        height:2px !important;
        border-radius:999px !important;
        background:currentColor !important;
    }

    body.admin-sidebar-open .admin-mobile-menu-button{
        opacity:0 !important;
        pointer-events:none !important;
    }

    /* =====================================================
       EVENT PAGE — TABLET / MOBILE
    ===================================================== */

    .admin-main{
        width:100%;
        margin-left:0;
        padding:88px 24px 48px;
    }

    .top-section{
        align-items:flex-start;
        flex-direction:column;
        gap:18px;
        margin-bottom:28px;
    }

    .btn-add-event{
        width:100%;
        min-height:56px;
    }

    .statistics-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:12px;
    }

    .filter-wrapper{
        grid-template-columns:minmax(0,1fr) 220px;
    }
/* Tablet: gunakan card agar lebih mudah dibaca dan disentuh */
    .table-box{
        display:none;
    }

    .mobile-event-list{
        display:flex;
        flex-direction:column;
        gap:14px;
    }

    .pagination-wrapper{
        display:none;
    }
}

@media (max-width:640px){

    .admin-main{
        padding:84px 15px 36px;
    }

    .dashboard-title{
        font-size:38px;
        letter-spacing:-.9px;
    }

    .dashboard-desc{
        font-size:15px;
        line-height:1.75;
    }

    .custom-alert{
        padding:14px;
        gap:10px;
    }

    .alert-icon{
        width:36px;
        height:36px;
        flex-basis:36px;
    }

    .alert-content strong{
        font-size:13px;
    }

    .alert-content span,
    .validation-list span{
        font-size:13px;
    }

    .statistics-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:10px;
    }

    .stat-card{
        min-height:96px;
        padding:15px;
        gap:10px;
    }

    .stat-icon{
        width:42px;
        height:42px;
        flex-basis:42px;
        border-radius:12px;
        font-size:15px;
    }

    .stat-label{
        font-size:12px;
    }

    .stat-number{
        font-size:24px;
    }

    .filter-wrapper{
        grid-template-columns:1fr;
        gap:9px;
    }

    .search-wrapper,
    .filter-select-wrapper{
        height:56px;
    }

    .search-wrapper input{
        font-size:15px;
    }

    .filter-select-wrapper select{
        font-size:15px;
    }
.mobile-card-image{
        height:210px;
    }

    .mobile-card-content{
        padding:18px;
    }

    .mobile-card-content h3{
        font-size:23px;
    }

    .mobile-card-content > p{
        font-size:14px;
    }

    .empty-state,
    .mobile-empty-state{
        padding:62px 18px;
    }

    .empty-state h3,
    .mobile-empty-state h3{
        font-size:24px;
    }

    .delete-modal{
        padding:30px 20px;
    }

    .delete-modal h3{
        font-size:27px;
    }
}

@media (max-width:420px){

    .admin-main{
        padding-left:12px;
        padding-right:12px;
    }

    .dashboard-title{
        font-size:35px;
    }

    .statistics-grid{
        grid-template-columns:1fr;
    }

    .stat-card{
        min-height:90px;
    }

    .mobile-card-image{
        height:190px;
    }

    .mobile-card-content h3{
        font-size:22px;
    }

    .mobile-card-actions{
        grid-template-columns:1fr;
    }

    .modal-actions{
        grid-template-columns:1fr;
    }
}

/* =========================================================
   DESKTOP / LAPTOP / MONITOR
========================================================= */

@media (min-width:901px) and (max-width:1199px){

    .admin-main{
        width:calc(100% - 260px);
        margin-left:260px;
        padding:44px 28px 58px;
    }

    .statistics-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .filter-wrapper{
        grid-template-columns:minmax(0,1fr) 210px auto;
    }

    .dashboard-title{
        font-size:44px;
    }
}

@media (min-width:1200px) and (max-width:1399px){

    .admin-main{
        width:calc(100% - 280px);
        margin-left:280px;
        padding:48px 40px 64px;
    }

    .dashboard-title{
        font-size:50px;
    }
}

@media (min-width:1400px){

    .admin-main{
        width:calc(100% - 290px);
        margin-left:290px;
        padding:56px 58px 76px;
    }

    .dashboard-title{
        font-size:60px;
    }
}

/* =========================================================
   REDUCED MOTION / FOCUS
========================================================= */

:focus-visible{
    outline:2px solid rgba(226,201,151,.78);
    outline-offset:3px;
}

@media (prefers-reduced-motion:reduce){

    html{
        scroll-behavior:auto;
    }

    *,
    *::before,
    *::after{
        animation:none !important;
        transition:none !important;
    }
}


/* =========================================================
   PER PAGE — TAMPILKAN 5 / 10 DATA
========================================================= */

.per-page-control{
    min-height:56px;

    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    padding:0 12px;

    border:1px solid var(--border-soft);
    border-radius:var(--radius-md);

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.035),
            rgba(255,255,255,.012)
        );

    white-space:nowrap;
}

.per-page-label{
    color:var(--text-muted);
    font-size:14px;
    font-weight:700;
}

#perPage{
    width:68px;
    height:40px;

    padding:0 28px 0 12px;

    border:1px solid rgba(226,201,151,.20);
    border-radius:11px;

    outline:none;

    background:#171717;
    color:var(--text-primary);

    font-size:15px;
    font-weight:800;

    cursor:pointer;
}

#perPage:hover{
    border-color:rgba(226,201,151,.36);
}

#perPage:focus{
    border-color:rgba(226,201,151,.55);
    box-shadow:0 0 0 3px rgba(226,201,151,.055);
}

#perPage option{
    background:#171717;
    color:var(--text-primary);
}

/* Supaya hasil pencarian + kontrol tidak sesak */
@media (min-width:901px){
    .filter-wrapper{
        grid-template-columns:minmax(0,1fr) 235px 150px auto;
    }
}

@media (max-width:900px){
    .per-page-control{
        width:100%;
        justify-content:flex-start;
    }
}

@media (max-width:640px){
    .per-page-control{
        min-height:56px;
        width:100%;
        justify-content:flex-start;
    }

    #perPage{
        width:72px;
        height:42px;
        font-size:15px;
    }
}

/* Ringkasan pagination tetap mudah dibaca */
#resultCount{
    color:var(--text-muted);
    font-size:14px;
    font-weight:600;
}

@media (max-width:420px){
    #resultCount{
        font-size:13px;
    }
}



/* =========================================================
   PAGINATION RESPONSIVE
========================================================= */

@media (max-width:900px){

    .pagination-wrapper{
        width:100%;
        justify-content:center;
        margin-top:18px;
        margin-bottom:10px;
    }

    .pagination-arrow,
    .pagination-number{
        width:44px;
        height:44px;
    }
}

@media (max-width:480px){

    .pagination-wrapper{
        gap:5px;
    }

    .pagination-numbers{
        gap:5px;
    }

    .pagination-arrow,
    .pagination-number{
        width:42px;
        height:42px;
    }
}



/* =========================================================
   RINGKASAN DATA — DI BAWAH DATA, SEBELAH KIRI
========================================================= */

.data-summary-bottom{
    width:100%;

    display:flex;
    align-items:center;
    justify-content:flex-start;

    margin-top:10px;
    padding:0 4px;

    color:var(--text-muted);
    font-size:13px;
    font-weight:600;
    line-height:1.5;

    text-align:left;
}

.data-summary-bottom #resultCount{
    color:var(--text-muted);
    font-size:13px;
    font-weight:600;
}

@media (max-width:900px){

    .data-summary-bottom{
        margin-top:10px;
        padding:0 2px;
    }
}

@media (max-width:640px){

    .data-summary-bottom{
        margin-top:9px;
        padding:0;
    }

    .data-summary-bottom #resultCount{
        font-size:13px;
    }
}

/* =========================================================
   TOOLBAR
========================================================= */

@media (min-width:901px){

    .filter-wrapper{
        grid-template-columns:minmax(0,1fr) 235px 150px;
    }
}

@media (max-width:900px){

    .filter-wrapper{
        grid-template-columns:minmax(0,1fr) 220px 150px;
        align-items:stretch;
    }

    .per-page-control{
        width:100%;
    }
}

@media (max-width:640px){

    .filter-wrapper{
        grid-template-columns:1fr;
    }

    .per-page-control{
        width:100%;
    }
}



/* =========================================================
   FINAL FIX — KONTROL TAMPILKAN 5 / 10 DATA
   Tidak nabrak • tidak terpotong • responsive
========================================================= */

.per-page-control{
    width:206px !important;
    min-width:206px !important;
    max-width:206px !important;

    min-height:56px !important;
    height:56px !important;

    display:flex !important;
    align-items:center !important;
    justify-content:center !important;

    gap:8px !important;

    padding:0 10px !important;

    border:1px solid var(--border-soft) !important;
    border-radius:16px !important;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.035),
            rgba(255,255,255,.012)
        ) !important;

    white-space:nowrap !important;
    overflow:visible !important;

    flex-shrink:0 !important;
}

.per-page-label{
    display:inline-block !important;

    flex:0 0 auto !important;

    white-space:nowrap !important;

    color:var(--text-muted) !important;
    font-size:14px !important;
    font-weight:700 !important;
    line-height:1 !important;
}

#perPage{
    flex:0 0 68px !important;

    width:68px !important;
    min-width:68px !important;
    max-width:68px !important;

    height:42px !important;

    margin:0 !important;

    padding:0 26px 0 11px !important;

    border:1px solid rgba(226,201,151,.20) !important;
    border-radius:11px !important;

    outline:none !important;

    background:#171717 !important;
    color:var(--text-primary) !important;

    font-size:15px !important;
    font-weight:800 !important;
    line-height:42px !important;

    cursor:pointer !important;

    overflow:visible !important;
}

#perPage:hover{
    border-color:rgba(226,201,151,.38) !important;
}

#perPage:focus{
    border-color:rgba(226,201,151,.58) !important;
    box-shadow:0 0 0 3px rgba(226,201,151,.055) !important;
}

#perPage option{
    background:#171717 !important;
    color:var(--text-primary) !important;
}

/* =========================================================
   DESKTOP
========================================================= */

@media (min-width:1200px){

    .filter-wrapper{
        grid-template-columns:minmax(0,1fr) 235px 206px !important;
    }
}

/* Laptop kecil */
@media (min-width:901px) and (max-width:1199px){

    .filter-wrapper{
        grid-template-columns:minmax(0,1fr) 210px 206px !important;
        gap:10px !important;
    }

    .per-page-control{
        width:206px !important;
        min-width:206px !important;
    }
}

/* =========================================================
   TABLET
========================================================= */

@media (max-width:900px){

    .filter-wrapper{
        grid-template-columns:minmax(0,1fr) 220px !important;
        gap:10px !important;
    }

    .per-page-control{
        grid-column:1 / -1 !important;

        width:206px !important;
        min-width:206px !important;
        max-width:206px !important;

        justify-self:start !important;
    }
}

/* =========================================================
   HP
========================================================= */

@media (max-width:640px){

    .filter-wrapper{
        grid-template-columns:1fr !important;
        gap:9px !important;
    }

    .per-page-control{
        grid-column:auto !important;

        width:100% !important;
        min-width:0 !important;
        max-width:100% !important;

        justify-content:flex-start !important;

        padding-left:14px !important;
        padding-right:14px !important;
    }

    .per-page-label{
        font-size:14px !important;
    }

    #perPage{
        flex:0 0 70px !important;

        width:70px !important;
        min-width:70px !important;
        max-width:70px !important;

        height:42px !important;

        padding-left:12px !important;
        padding-right:27px !important;
    }
}

/* HP kecil */
@media (max-width:380px){

    .per-page-control{
        min-height:54px !important;
        height:54px !important;

        gap:7px !important;
        padding-left:11px !important;
        padding-right:11px !important;
    }

    .per-page-label{
        font-size:13px !important;
    }

    #perPage{
        flex-basis:68px !important;
        width:68px !important;
        min-width:68px !important;
        max-width:68px !important;
        height:40px !important;
        font-size:14px !important;
    }
}



/* =========================================================
   FINAL FIX — ANGKA 5 / 10 HARUS UTUH
========================================================= */

#perPage{
    width:82px !important;
    min-width:82px !important;
    max-width:82px !important;

    flex:0 0 82px !important;

    height:42px !important;

    padding:0 31px 0 11px !important;

    text-align:center !important;
    text-align-last:center !important;

    border:1px solid rgba(226,201,151,.20) !important;
    border-radius:11px !important;

    background:#171717 !important;
    color:var(--text-primary) !important;

    font-size:15px !important;
    font-weight:800 !important;
    line-height:42px !important;

    overflow:visible !important;
}

#perPage option{
    padding:8px 12px !important;
    background:#171717 !important;
    color:var(--text-primary) !important;
    font-size:15px !important;
    font-weight:700 !important;
}

/* Tablet dan HP tetap menyediakan ruang yang cukup */
@media (max-width:640px){

    #perPage{
        width:82px !important;
        min-width:82px !important;
        max-width:82px !important;
        flex-basis:82px !important;

        height:42px !important;

        padding-left:10px !important;
        padding-right:31px !important;

        text-align:center !important;
        text-align-last:center !important;
    }
}

@media (max-width:380px){

    #perPage{
        width:80px !important;
        min-width:80px !important;
        max-width:80px !important;
        flex-basis:80px !important;

        height:40px !important;

        padding-left:9px !important;
        padding-right:29px !important;

        font-size:14px !important;
    }
}

</style>



    {{-- =============================================================
        JAVASCRIPT
    ============================================================= --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | DELETE MODAL
        |--------------------------------------------------------------------------
        */

        let selectedDeleteId = null;

        const deleteModal =
            document.getElementById('deleteModal');

        const deleteEventName =
            document.getElementById('deleteEventName');

        const confirmDeleteButton =
            document.getElementById('confirmDeleteButton');


        function openDeleteModal(id, name)
        {
            selectedDeleteId = id;

            deleteEventName.textContent = name;

            deleteModal.classList.add('active');

            document.body.style.overflow = 'hidden';
        }


        function closeDeleteModal()
        {
            selectedDeleteId = null;

            deleteModal.classList.remove('active');

            document.body.style.overflow = '';
        }


        confirmDeleteButton.addEventListener(
            'click',
            function ()
            {
                if (!selectedDeleteId) {
                    return;
                }


                /*
                | Desktop form
                */

                const desktopForm =
                    document.getElementById(
                        'delete-form-' + selectedDeleteId
                    );


                /*
                | Mobile form
                */

                const mobileForm =
                    document.getElementById(
                        'mobile-delete-form-' + selectedDeleteId
                    );


                if (window.innerWidth <= 640) {

                    if (mobileForm) {
                        mobileForm.submit();
                    }

                    return;
                }


                if (desktopForm) {
                    desktopForm.submit();
                }
            }
        );


        deleteModal.addEventListener(
            'click',
            function (event)
            {
                if (event.target === deleteModal) {
                    closeDeleteModal();
                }
            }
        );


        document.addEventListener(
            'keydown',
            function (event)
            {
                if (event.key === 'Escape') {
                    closeDeleteModal();
                }
            }
        );


        /*
        |--------------------------------------------------------------------------
        | SEARCH + FILTER + PAGINATION
        |--------------------------------------------------------------------------
        */

        const searchInput =
            document.getElementById('searchEvent');

        const filterTanggal =
            document.getElementById('filterTanggal');

        const clearSearch =
            document.getElementById('clearSearch');

        const resultCount =
            document.getElementById('resultCount');

        const paginationWrapper =
            document.getElementById('paginationWrapper');

        const paginationNumbers =
            document.getElementById('paginationNumbers');

        const prevPage =
            document.getElementById('prevPage');

        const nextPage =
            document.getElementById('nextPage');

        const perPageSelect =
            document.getElementById('perPage');

        const noSearchResult =
            document.getElementById('noSearchResult');


        const desktopRows =
            Array.from(
                document.querySelectorAll('.event-row')
            );


        const mobileCards =
            Array.from(
                document.querySelectorAll('.event-card')
            );


        let itemsPerPage =
            perPageSelect
                ? parseInt(perPageSelect.value, 10) || 10
                : 10;


        let currentPage = 1;


        function getFilteredItems()
        {
            const keyword =
                searchInput.value
                    .trim()
                    .toLowerCase();


            const filter =
                filterTanggal.value;


            const desktopFiltered =
                desktopRows.filter(
                    function (row)
                    {
                        const title =
                            row.dataset.title || '';

                        const status =
                            row.dataset.status || '';


                        const matchTitle =
                            title.includes(keyword);


                        const matchStatus =
                            filter === 'all' ||
                            status === filter;


                        return matchTitle && matchStatus;
                    }
                );


            return desktopFiltered;
        }


        function renderPagination()
        {
            const filteredRows =
                getFilteredItems();


            const totalItems =
                filteredRows.length;


            const totalPages =
                Math.ceil(
                    totalItems / itemsPerPage
                );


            if (
                totalPages > 0 &&
                currentPage > totalPages
            ) {
                currentPage = totalPages;
            }


            if (totalPages === 0) {
                currentPage = 1;
            }


            /*
            | Hide all desktop rows
            */

            desktopRows.forEach(
                function (row)
                {
                    row.style.display = 'none';
                }
            );


            /*
            | Hide all mobile cards
            */

            mobileCards.forEach(
                function (card)
                {
                    card.style.display = 'none';
                }
            );


            /*
            | Show current desktop rows
            */

            const start =
                (currentPage - 1) *
                itemsPerPage;


            const end =
                start + itemsPerPage;


            filteredRows
                .slice(start, end)
                .forEach(
                    function (row)
                    {
                        row.style.display = '';
                    }
                );


            /*
            | Match mobile cards
            */

            const filteredIds =
                filteredRows.map(
                    function (row)
                    {
                        return row.dataset.id;
                    }
                );


            mobileCards
                .filter(
                    function (card)
                    {
                        return filteredIds.includes(
                            card.dataset.id
                        );
                    }
                )
                .slice(start, end)
                .forEach(
                    function (card)
                    {
                        card.style.display = '';
                    }
                );


            /*
            | Result counter
            */

            if (totalItems === 0) {

                resultCount.textContent =
                    'Tidak ada event';

            } else {

                const visibleStart =
                    start + 1;

                const visibleEnd =
                    Math.min(end, totalItems);

                resultCount.textContent =
                    `Menampilkan ${visibleStart}–${visibleEnd} dari ${totalItems} ` +
                    (totalItems === 1 ? 'event' : 'event');

            }


            /*
            | Empty search result
            */

            if (totalItems === 0) {

                noSearchResult.classList.add(
                    'show'
                );

                paginationWrapper.style.display =
                    'none';

            } else {

                noSearchResult.classList.remove(
                    'show'
                );

                paginationWrapper.style.display =
                    totalPages > 1
                        ? 'flex'
                        : 'none';
            }


            renderPaginationButtons(
                totalPages
            );
        }


        function renderPaginationButtons(
            totalPages
        )
        {
            paginationNumbers.innerHTML = '';


            if (totalPages <= 1) {

                prevPage.disabled = true;

                nextPage.disabled = true;

                return;
            }


            prevPage.disabled =
                currentPage === 1;


            nextPage.disabled =
                currentPage === totalPages;


            for (
                let page = 1;
                page <= totalPages;
                page++
            ) {

                const button =
                    document.createElement('button');


                button.type = 'button';

                button.className =
                    'pagination-number';


                if (page === currentPage) {
                    button.classList.add(
                        'active'
                    );
                }


                button.textContent = page;


                button.addEventListener(
                    'click',
                    function ()
                    {
                        currentPage = page;

                        renderPagination();
                    }
                );


                paginationNumbers.appendChild(
                    button
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | PREVIOUS
        |--------------------------------------------------------------------------
        */

        prevPage.addEventListener(
            'click',
            function ()
            {
                if (currentPage > 1) {

                    currentPage--;

                    renderPagination();
                }
            }
        );


        /*
        |--------------------------------------------------------------------------
        | NEXT
        |--------------------------------------------------------------------------
        */

        nextPage.addEventListener(
            'click',
            function ()
            {
                const totalPages =
                    Math.ceil(
                        getFilteredItems().length /
                        itemsPerPage
                    );


                if (
                    currentPage <
                    totalPages
                ) {

                    currentPage++;

                    renderPagination();
                }
            }
        );


        /*
        |--------------------------------------------------------------------------
        | JUMLAH DATA PER HALAMAN
        |--------------------------------------------------------------------------
        */

        if (perPageSelect) {

            perPageSelect.addEventListener(
                'change',
                function ()
                {
                    const selected =
                        parseInt(this.value, 10);

                    itemsPerPage =
                        selected === 5 ? 5 : 10;

                    currentPage = 1;

                    renderPagination();
                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        searchInput.addEventListener(
            'input',
            function ()
            {
                currentPage = 1;

                clearSearch.classList.toggle(
                    'show',
                    searchInput.value.length > 0
                );

                renderPagination();
            }
        );


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        filterTanggal.addEventListener(
            'change',
            function ()
            {
                currentPage = 1;

                renderPagination();
            }
        );


        /*
        |--------------------------------------------------------------------------
        | CLEAR SEARCH
        |--------------------------------------------------------------------------
        */

        clearSearch.addEventListener(
            'click',
            function ()
            {
                searchInput.value = '';

                clearSearch.classList.remove(
                    'show'
                );

                currentPage = 1;

                searchInput.focus();

                renderPagination();
            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIALIZE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'DOMContentLoaded',
            function ()
            {
                renderPagination();
            }
        );


        renderPagination();

    </script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const openButton = document.getElementById('openAdminSidebar');

    if (!openButton) {
        return;
    }

    openButton.addEventListener('click', function () {

        if (typeof window.openAdminSidebar === 'function') {
            window.openAdminSidebar();
            return;
        }

        const sidebar = document.getElementById('adminSidebar');
        const overlay =
            document.getElementById('sidebarOverlay') ||
            document.getElementById('adminSidebarOverlay');

        if (sidebar) {
            sidebar.classList.add('open');
        }

        if (overlay) {
            overlay.classList.add('show');
        }

        document.body.classList.add('admin-sidebar-open');
        openButton.setAttribute('aria-expanded', 'true');
    });
});
</script>

</body>

</html>