<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Event — Admin Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

@include('admin.partials.sidebar')

<main class="admin-main">

    <div class="top-section">
        <div class="header-text-wrapper">
            <span class="dashboard-subtitle">DESIGN SYSTEM / ADMIN PANEL</span>
            <h1 class="dashboard-title text-gradient">Kelola Event</h1>
            <p class="dashboard-desc">Arsip digital, kurasi pameran, dan pembaruan agenda utama yang terintegrasi secara langsung.</p>
        </div>

        <a href="{{ route('event.create') }}" class="btn-primary-travel btn-add-custom">
            <i class="fas fa-plus icon-btn"></i>
            Tambah Event Baru
        </a>
    </div>

    @if(session('success'))
        <div class="custom-alert glass-effect">
            <div class="alert-icon-wrapper">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-content">
                <span class="alert-title">Berhasil</span>
                <p class="alert-message">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="table-box glass-effect">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="70" class="text-center">INDEX</th>
                        <th width="140">VISUAL</th>
                        <th>IDENTITAS EVENT</th>
                        <th width="180">TANGGAL PELAKSANAAN</th>
                        <th>DESKRIPSI RINGKAS</th>
                        <th width="150" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $key => $event)
                    <tr>
                        <td class="text-center">
                            <span class="row-index">#{{ sprintf('%02d', $key + 1) }}</span>
                        </td>

                        <td>
                            @if($event->gambar)
                                <div class="image-frame">
                                    <img src="{{ asset('uploads/event/'.$event->gambar) }}" 
                                         class="event-image" 
                                         alt="{{ $event->judul }}">
                                </div>
                            @else
                                <div class="no-image">
                                    <i class="fas fa-compass"></i>
                                    <span>Seni</span>
                                </div>
                            @endif
                        </td>

                        <td>
                            <div class="event-title-cell">
                                <span class="event-title-main">{{ $event->judul }}</span>
                                <span class="event-tag">Kategori Publik</span>
                            </div>
                        </td>

                        <td>
                            <div class="date-badge">
                                <i class="far fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($event->tanggal)->format('d M, Y') }}</span>
                            </div>
                        </td>

                        <td>
                            <div class="event-desc-cell">
                                {{ Str::limit($event->deskripsi, 85) }}
                            </div>
                        </td>

                        <td>
                            <div class="action-group justify-content-center">
                                <a href="{{ route('event.edit', $event->id) }}" 
                                   class="btn-action edit-btn-minimal" 
                                   title="Edit Event">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form action="{{ route('event.destroy', $event->id) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-action delete-btn-minimal" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus arsip event ini?')" 
                                            title="Hapus Event">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon-pulse">
                                    <i class="fas fa-feather"></i>
                                </div>
                                <h3>Ruang Belum Terisi</h3>
                                <p>Belum ada rekaman agenda atau pameran seni yang didaftarkan ke sistem.</p>
                                <a href="{{ route('event.create') }}" class="btn-secondary-travel" style="padding: 12px 30px; font-size: 14px; margin-top: 15px;">
                                    Mulai Input Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<style>
/* ==========================================================================
   ADVANCED MODERN STYLING (THE PERFECT MATCH)
   ========================================================================== */

body {
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Inter', sans-serif;
    overflow-x: hidden;
}

.admin-main {
    margin-left: 300px;
    min-height: 100vh;
    padding: 60px;
    background: radial-gradient(circle at 80% 20%, rgba(226, 201, 151, 0.03) 0%, transparent 50%);
}

/* Header UI */
.top-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 40px;
    margin-bottom: 50px;
}

.header-text-wrapper {
    max-width: 700px;
}

.dashboard-subtitle {
    color: var(--accent-dark);
    letter-spacing: 3px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    display: block;
    margin-bottom: 6px;
}

.dashboard-title {
    font-family: 'Playfair Display', serif;
    font-size: 48px;
    font-weight: 700;
    margin: 0 0 12px 0;
    line-height: 1.1;
}

.dashboard-desc {
    color: var(--text-muted);
    font-size: 15px;
    font-weight: 400;
    line-height: 1.6;
}

/* Button Refinement */
.btn-add-custom {
    padding: 15px 32px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    box-shadow: 0 10px 30px rgba(226, 201, 151, 0.15);
}

.icon-btn {
    font-size: 12px;
    margin-right: 8px;
}

/* Glassmorphism Table Container */
.table-box {
    border-radius: var(--radius-md);
    background: rgba(18, 18, 18, 0.6);
    border: 1px solid var(--border-soft);
    box-shadow: var(--shadow-soft);
    margin-top: 20px;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

/* Table Header */
.custom-table th {
    padding: 22px 28px;
    color: var(--text-dim);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-bottom: 1px solid var(--border-gold);
    background: rgba(21, 21, 21, 0.5);
}

/* Table Rows */
.custom-table td {
    padding: 20px 28px;
    border-bottom: 1px solid var(--border-soft);
    vertical-align: middle;
}

.custom-table tbody tr {
    transition: all var(--transition);
}

.custom-table tbody tr:hover {
    background: rgba(226, 201, 151, 0.02);
}

/* Custom Row Elements */
.row-index {
    font-family: monospace;
    font-size: 14px;
    color: var(--text-dim);
}

/* Visual Framework (Poster) */
.image-frame {
    width: 96px;
    height: 64px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid var(--border-gold);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    background: var(--bg-soft);
    transition: transform var(--transition);
}

.custom-table tr:hover .image-frame {
    transform: scale(1.04);
}

.event-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 96px;
    height: 64px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: var(--bg-soft);
    border: 1px solid var(--border-soft);
    color: var(--text-dim);
    gap: 4px;
}

.no-image i {
    font-size: 14px;
}

.no-image span {
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Identitas Event Cell */
.event-title-cell {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.event-title-main {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    letter-spacing: -0.2px;
}

.event-tag {
    font-size: 11px;
    color: var(--accent-dark);
    font-weight: 500;
}

/* Date Cell */
.date-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    border-radius: var(--radius-full);
    background: rgba(226, 201, 151, 0.06);
    border: 1px solid var(--border-gold);
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
}

.date-badge i {
    color: var(--accent);
    font-size: 12px;
}

/* Description Cell */
.event-desc-cell {
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.6;
    max-width: 320px;
}

/* Minimalist Action Group */
.action-group {
    display: flex;
    gap: 8px;
    align-items: center;
}

.btn-action {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    border: none;
    font-size: 13px;
    transition: all var(--transition);
    cursor: pointer;
}

.edit-btn-minimal {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--border-soft);
    color: var(--text-secondary);
}

.edit-btn-minimal:hover {
    border-color: var(--accent);
    color: var(--accent);
    background: rgba(226, 201, 151, 0.08);
}

.delete-btn-minimal {
    background: rgba(239, 68, 68, 0.03);
    border: 1px solid rgba(239, 68, 68, 0.15);
    color: #fca5a5;
}

.delete-btn-minimal:hover {
    background: rgba(239, 68, 68, 0.15);
    border-color: #ef4444;
    color: #ef4444;
}

.inline-form {
    display: inline;
}

/* Premium Alert UI */
.custom-alert {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 24px;
    border-radius: var(--radius-md);
    margin-bottom: 35px;
    background: linear-gradient(90deg, rgba(34, 197, 94, 0.06) 0%, rgba(18, 18, 18, 0.4) 100%);
    border-left: 3px solid #4ade80;
}

.alert-icon-wrapper {
    color: #4ade80;
    font-size: 20px;
}

.alert-content {
    display: flex;
    flex-direction: column;
}

.alert-title {
    font-size: 13px;
    font-weight: 700;
    color: #4ade80;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.alert-message {
    margin: 2px 0 0 0;
    font-size: 14px;
    color: var(--text-secondary);
}

/* Empty State Styling */
.empty-state {
    text-align: center;
    padding: 80px 40px;
}

.empty-icon-pulse {
    font-size: 44px;
    color: var(--accent-dark);
    margin-bottom: 20px;
    opacity: 0.6;
}

.empty-state h3 {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    margin-bottom: 8px;
    color: var(--text-primary);
}

.empty-state p {
    color: var(--text-muted);
    font-size: 14px;
    max-width: 400px;
    margin: 0 auto 20px auto;
}

/* Responsiveness Harmony */
@media (max-width: 1200px) {
    .admin-main {
        padding: 40px;
    }
    .dashboard-title {
        font-size: 38px;
    }
}

@media (max-width: 991px) {
    .admin-main {
        margin-left: 0;
        padding: 120px 24px 40px 24px;
    }

    .top-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 24px;
    }

    .btn-add-custom {
        width: 100%;
        justify-content: center;
    }

    .custom-table {
        min-width: 950px;
    }
}
</style>

</body>
</html>