<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Eksistensi Event — Admin Panel</title>

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
            <span class="dashboard-subtitle">DESIGN SYSTEM / MODIFIKASI</span>
            <h1 class="dashboard-title text-gradient">Edit Event</h1>
            <p class="dashboard-desc">Perbarui lembar kurasi, sesuaikan waktu pelaksanaan, atau ganti aset visual publikasi Anda.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="custom-alert danger glass-effect">
            <div class="alert-icon-wrapper">
                <i class="fas fa-circle-exclamation"></i>
            </div>
            <div class="alert-content">
                <span class="alert-title">Gagal Memperbarui</span>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="form-box glass-effect">
        <form action="{{ route('event.update', $event->id) }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row-grid">
                <div class="form-group mb-28">
                    <label for="judul">
                        <i class="fas fa-heading form-label-icon"></i> Judul Utama Event
                    </label>
                    <input type="text" 
                           id="judul"
                           name="judul" 
                           value="{{ old('judul', $event->judul) }}" 
                           required autocomplete="off">
                </div>

                <div class="form-group mb-28">
                    <label for="tanggal">
                        <i class="far fa-calendar-alt form-label-icon"></i> Tanggal Pelaksanaan
                    </label>
                    <input type="date" 
                           id="tanggal"
                           name="tanggal" 
                           value="{{ old('tanggal', $event->tanggal) }}" 
                           required>
                </div>
            </div>

            <div class="form-group mb-28">
                <label for="deskripsi">
                    <i class="fas fa-align-left form-label-icon"></i> Deskripsi Ringkas Event
                </label>
                <textarea id="deskripsi"
                          name="deskripsi" 
                          rows="6" 
                          required>{{ old('deskripsi', $event->deskripsi) }}</textarea>
            </div>

            <div class="visual-management-grid mb-40">
                
                <div class="form-group">
                    <label><i class="fas fa-eye form-label-icon"></i> Poster Saat Ini</label>
                    @if($event->gambar)
                        <div class="current-poster-frame">
                            <img src="{{ asset('uploads/event/'.$event->gambar) }}" class="preview-image" alt="Poster {{ $event->judul }}">
                        </div>
                    @else
                        <div class="no-poster-box">
                            <i class="fas fa-image-not-supported"></i>
                            <span>Belum ada poster terarsip</span>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label><i class="fas fa-cloud-upload-alt form-label-icon"></i> Unggah Poster Baru</label>
                    <div class="premium-file-upload">
                        <input type="file" 
                               id="gambar"
                               name="gambar" 
                               accept="image/*"
                               onchange="updateFileName(this)">
                        <div class="upload-placeholder-content">
                            <div class="upload-icon-circle">
                                <i class="fas fa-images"></i>
                            </div>
                            <p class="upload-primary-text" id="file-chosen-text">Pilih berkas untuk mengganti</p>
                            <p class="upload-secondary-text">Kosongkan jika tidak ingin mengubah citra poster.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="button-group">
                <button type="submit" class="btn-primary-travel btn-save-custom">
                    <i class="fas fa-arrow-up-from-bracket icon-btn"></i>
                    Perbarui Data Event
                </button>

                <a href="{{ route('event.index') }}" class="btn-secondary-travel btn-back-custom">
                    <i class="fas fa-chevron-left icon-btn"></i>
                    Batal & Kembali
                </a>
            </div>

        </form>
    </div>
</main>

<script>
    // Membatasi pilihan tanggal minimal hari ini secara dinamis
    document.addEventListener("DOMContentLoaded", function() {
        const dateInput = document.getElementById('tanggal');
        const today = new Date();
        
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const minDate = `${yyyy}-${mm}-${dd}`;
        
        // Membaca nilai tanggal yang sedang tersimpan saat ini
        const currentValue = dateInput.value;

        // Jika tanggal event sudah lewat (masa lalu), tetap izinkan tampil agar data tidak rusak.
        // Namun jika tanggal event adalah hari ini atau masa depan, batasi minimal ke hari ini.
        if (!currentValue || currentValue >= minDate) {
            dateInput.setAttribute('min', minDate);
        }
    });

    // Mendeteksi perubahan nama file saat di-upload
    function updateFileName(input) {
        const textLabel = document.getElementById('file-chosen-text');
        if (input.files && input.files.length > 0) {
            textLabel.innerText = "Terpilih: " + input.files[0].name;
            textLabel.style.color = "var(--accent)";
        } else {
            textLabel.innerText = "Pilih berkas untuk mengganti";
            textLabel.style.color = "var(--text-primary)";
        }
    }
</script>

<style>
/* ==========================================================================
   ADVANCED MODERN INPUT STYLING (THE EDIT HARMONY)
   ========================================================================== */

body {
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Inter', sans-serif;
}

.admin-main {
    margin-left: 300px;
    min-height: 100vh;
    padding: 60px;
    background: radial-gradient(circle at 80% 20%, rgba(226, 201, 151, 0.03) 0%, transparent 50%);
}

/* Header UI */
.top-section {
    margin-bottom: 45px;
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
}

/* Glassmorphic Form Box */
.form-box {
    border-radius: var(--radius-md);
    background: rgba(18, 18, 18, 0.5);
    border: 1px solid var(--border-soft);
    box-shadow: var(--shadow-soft);
    padding: 50px;
}

/* Grid layout ganda */
.form-row-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

/* Row Khusus Manajemen File Poster */
.visual-management-grid {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 30px;
    align-items: flex-start;
}

.mb-28 { margin-bottom: 28px; }
.mb-40 { margin-bottom: 40px; }

/* Labels & Typography */
.form-group label {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-secondary);
}

.form-label-icon {
    font-size: 14px;
    margin-right: 8px;
    color: var(--accent-dark);
}

/* Input Fields & Textarea Premium Styling */
.form-group input[type="text"],
.form-group input[type="date"],
.form-group textarea {
    width: 100%;
    padding: 16px 20px;
    border-radius: 12px;
    border: 1px solid var(--border-soft);
    background: rgba(255, 255, 255, 0.02);
    color: var(--text-primary);
    font-size: 15px;
    font-family: 'Inter', sans-serif;
    outline: none;
    transition: all var(--transition);
}

/* Input Interactive States */
.form-group input[type="text"]:focus,
.form-group input[type="date"]:focus,
.form-group textarea:focus {
    background: rgba(226, 201, 151, 0.02);
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.08);
}

/* Date picker customization override */
::-webkit-calendar-picker-indicator {
    filter: invert(0.8) sepia(50%) saturate(400%) hue-rotate(330deg);
    cursor: pointer;
    border-radius: 4px;
    padding: 4px;
}

/* Current Poster Frame */
.current-poster-frame {
    width: 100%;
    height: 150px;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--border-gold);
    box-shadow: 0 8px 25px rgba(0,0,0,0.4);
    background: var(--bg-soft);
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-poster-box {
    width: 100%;
    height: 150px;
    border-radius: 14px;
    border: 1px dashed var(--border-soft);
    background: rgba(255,255,255,0.01);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--text-dim);
    gap: 8px;
    font-size: 13px;
}

.no-poster-box i {
    font-size: 22px;
}

/* Premium File Upload Box */
.premium-file-upload {
    position: relative;
    width: 100%;
    height: 150px;
    border: 2px dashed var(--border-soft);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.01);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    text-align: center;
    transition: all var(--transition);
    cursor: pointer;
}

.premium-file-upload:hover {
    background: rgba(226, 201, 151, 0.02);
    border-color: var(--accent);
}

.premium-file-upload input[type="file"] {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-icon-circle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.03);
    color: var(--text-secondary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    margin-bottom: 10px;
    transition: all var(--transition);
}

.premium-file-upload:hover .upload-icon-circle {
    color: var(--accent);
    background: rgba(226, 201, 151, 0.06);
    transform: translateY(-2px);
}

.upload-primary-text {
    font-size: 14px;
    font-weight: 500;
    color: var(--text-primary);
    margin: 0 0 2px 0;
}

.upload-secondary-text {
    font-size: 12px;
    color: var(--text-dim);
    margin: 0;
}

/* Action Button Footers */
.button-group {
    display: flex;
    align-items: center;
    gap: 16px;
}

.btn-save-custom {
    padding: 16px 36px;
    font-size: 14px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    box-shadow: 0 10px 30px rgba(226, 201, 151, 0.15);
}

.btn-back-custom {
    padding: 16px 36px;
    font-size: 14px;
    font-weight: 600;
    border-radius: var(--radius-full);
}

.icon-btn {
    font-size: 12px;
    margin-right: 8px;
}

/* Premium Error Alerts */
.custom-alert.danger {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 20px 24px;
    border-radius: var(--radius-md);
    margin-bottom: 35px;
    background: linear-gradient(90deg, rgba(239, 68, 68, 0.06) 0%, rgba(18, 18, 18, 0.4) 100%);
    border-left: 3px solid #ef4444;
}

.alert-icon-wrapper {
    color: #fca5a5;
    font-size: 18px;
    margin-top: 2px;
}

.alert-content {
    display: flex;
    flex-direction: column;
}

.alert-title {
    font-size: 13px;
    font-weight: 700;
    color: #ef4444;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.error-list {
    margin: 6px 0 0 0;
    padding-left: 18px;
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Responsiveness Adaptability */
@media (max-width: 1200px) {
    .admin-main { padding: 40px; }
    .form-box { padding: 35px; }
}

@media (max-width: 991px) {
    .admin-main {
        margin-left: 0;
        padding: 120px 24px 40px 24px;
    }

    .form-row-grid,
    .visual-management-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .current-poster-frame,
    .no-poster-box {
        height: 180px;
    }

    .button-group {
        flex-direction: column;
        width: 100%;
    }

    .btn-save-custom, 
    .btn-back-custom {
        width: 100%;
        justify-content: center;
    }
}
</style>

</body>
</html>