<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu — Admin Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">

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
                <span class="dashboard-subtitle">ADMIN PANEL / CREATION</span>
                <h1 class="dashboard-title text-gradient">Tambah Menu Baru</h1>
                <p class="dashboard-desc">Arsipkan varian kuliner kuliner khas, paket hidangan baru, racikan sambal, atau minuman segar ke dalam sistem data resto.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="custom-alert error glass-effect">
                <div class="alert-icon-wrapper">
                    <i class="fas fa-circle-exclamation"></i>
                </div>
                <div class="alert-content">
                    <span class="alert-title">Gagal Memproses Data</span>
                    @foreach ($errors->all() as $error)
                        <span class="alert-desc">• {{ $error }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="table-box glass-effect">
            <form action="/admin/menu/store" method="POST" enctype="multipart/form-data" id="menuForm">
                @csrf

                <div class="admin-grid">
                    
                    <div class="form-column">
                        
                        <div class="form-group-custom">
                            <label class="form-label-custom">Nama Hidangan / Menu</label>
                            <div class="search-box">
                                <i class="fas fa-utensils search-icon"></i>
                                <input type="text" name="nama_menu" value="{{ old('nama_menu') }}" placeholder="Contoh: Ayam Bakar Madu Spesial" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Deskripsi Hidangan</label>
                            <textarea name="deskripsi" class="textarea-custom" rows="6" placeholder="Tuliskan racikan komposisi, keunikan rasa, atau detail porsi menu secara naratif... Required.">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Visual Asset Menu</label>
                            <div class="upload-custom" id="uploadBox">
                                <img id="previewImage" src="" alt="Preview" class="preview-image">

                                <div id="uploadContent">
                                    <div class="upload-icon-circle">
                                        <i class="fas fa-cloud-arrow-up"></i>
                                    </div>
                                    <h4>Pilih File Gambar Menu</h4>
                                    <p>Mendukung format JPG, PNG, atau JPEG (Maks. 2MB)</p>
                                    <span id="fileName">Belum ada file media yang dipilih</span>
                                </div>

                                <input type="file" name="gambar" id="gambarInput" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>

                    </div>

                    <div class="form-column flex-column-space">
                        
                        <div class="upper-fields">
                            <div class="form-group-custom">
                                <label class="form-label-custom">Kategori Menu</label>
                                <div class="filter-category">
                                    <select name="kategori" required>
                                        <option value="">-- Pilih Klasifikasi Kategori --</option>
                                        <option value="Paket" {{ old('kategori') == 'Paket' ? 'selected' : '' }}>Paket Hidangan</option>
                                        <option value="Minuman" {{ old('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman Segar</option>
                                        <option value="Sambal" {{ old('kategori') == 'Sambal' ? 'selected' : '' }}>Varian Sambal</option>
                                        <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Menu Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">Harga Satuan (IDR)</label>
                                <div class="search-box">
                                    <i class="fas fa-wallet search-icon"></i>
                                    <input type="text" id="harga" name="harga" value="{{ old('harga') }}" placeholder="Contoh: 35.000" autocomplete="off" maxlength="12" required>
                                </div>
                                <small class="input-helper">Sistem menggunakan format mata uang otomatis Rupiah.</small>
                            </div>

                            <div class="form-group-custom">
                                <label class="form-label-custom">Status Ketersediaan Awal</label>
                                <div class="filter-category">
                                    <select name="status">
                                        <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia (Aktif di List Menu)</option>
                                        <option value="Habis" {{ old('status') == 'Habis' ? 'selected' : '' }}>Habis (Sembunyikan / Kosong)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions-wrapper">
                            <button type="submit" class="btn-submit-modern">
                                <div class="btn-submit-glow"></div>
                                <i class="fas fa-floppy-disk"></i>
                                <span>Simpan & Publikasikan Menu</span>
                            </button>
                        </div>

                    </div>

                </div>

            </form>
        </div>

    </main>

<script>
/* ==========================================================================
   INTERACTIVE DATA FORMATTING & PREVIEWS
   ========================================================================== */

// Auto-Currency Formatter IDR
const hargaInput = document.getElementById('harga');
hargaInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if(value) {
        value = new Intl.NumberFormat('id-ID').format(value);
    }
    e.target.value = value;
});

// Dynamic File Drag/Upload Live Preview
const gambarInput = document.getElementById('gambarInput');
const previewImage = document.getElementById('previewImage');
const fileName = document.getElementById('fileName');
const uploadContent = document.getElementById('uploadContent');

gambarInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if(file) {
        fileName.innerText = file.name;
        const reader = new FileReader();
        reader.onload = function(event) {
            previewImage.src = event.target.result;
            previewImage.style.display = 'block';
            uploadContent.style.display = 'none';
        }
        reader.readAsDataURL(file);
    }
});
</script>

<style>
/* ==========================================================================
   ADVANCED MODERN DASHBOARD THEME (THE LUXURY MINIMALIST EDIT)
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
    background: radial-gradient(circle at 80% 15%, rgba(226, 201, 151, 0.04) 0%, transparent 60%);
}

/* Header Content Elements */
.top-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 40px;
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
    margin: 0 0 10px 0;
    line-height: 1.1;
}

.dashboard-desc {
    color: var(--text-muted);
    font-size: 15px;
    max-width: 700px;
    line-height: 1.6;
}

/* Premium Glassmorphic Card Engine */
.glass-effect {
    background: rgba(18, 18, 18, 0.4);
    border: 1px solid var(--border-soft);
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}

.table-box {
    border-radius: 24px;
    padding: 45px;
}

/* Intelligent Form Grid Structure */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 45px;
}

.form-column {
    display: flex;
    flex-direction: column;
}

.flex-column-space {
    justify-content: space-between;
}

.form-group-custom {
    margin-bottom: 30px;
}

.form-group-custom:last-child {
    margin-bottom: 0;
}

.form-label-custom {
    display: block;
    margin-bottom: 12px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-secondary);
    letter-spacing: 0.3px;
}

/* Refined Premium Inputs & Frameworks */
.search-box {
    position: relative;
    width: 100%;
}

.search-icon {
    position: absolute;
    top: 50%;
    left: 22px;
    transform: translateY(-50%);
    color: var(--accent-dark);
    font-size: 15px;
}

.search-box input {
    width: 100%;
    height: 58px;
    padding: 0 24px 0 56px;
    border-radius: 14px;
    border: 1px solid var(--border-soft);
    background: rgba(255, 255, 255, 0.01);
    color: var(--text-primary);
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
    transition: all var(--transition);
}

.search-box input:focus, .textarea-custom:focus {
    border-color: var(--accent);
    background: rgba(226, 201, 151, 0.01);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.06);
}

/* Luxurious Textareas Architecture */
.textarea-custom {
    width: 100%;
    padding: 20px 22px;
    border-radius: 16px;
    border: 1px solid var(--border-soft);
    background: rgba(255, 255, 255, 0.01);
    color: var(--text-primary);
    font-size: 14px;
    font-family: inherit;
    line-height: 1.6;
    resize: none;
    outline: none;
    box-sizing: border-box;
    transition: all var(--transition);
}

/* Advanced Category Dropdown Custom Selector */
.filter-category {
    position: relative;
    width: 100%;
}

.filter-category select {
    width: 100%;
    height: 58px;
    padding: 0 50px 0 22px;
    border-radius: 14px;
    border: 1px solid var(--border-soft);
    background: rgba(255, 255, 255, 0.01) url("data:image/svg+xml;charset=UTF-8,%3Csvg width='20' height='20' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10L12 15L17 10' stroke='%23e2c997' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 20px center;
    background-size: 15px;
    color: var(--text-primary);
    outline: none;
    cursor: pointer;
    font-weight: 500;
    font-size: 14px;
    appearance: none;
    -webkit-appearance: none;
    box-sizing: border-box;
    transition: all var(--transition);
}

.filter-category select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.06);
}

.filter-category select option {
    background: #161616;
    color: var(--text-primary);
    padding: 14px;
}

.input-helper {
    display: block;
    margin-top: 8px;
    color: var(--text-muted);
    font-size: 12px;
}

/* Minimalist Upload Area Architecture */
.upload-custom {
    position: relative;
    width: 100%;
    min-height: 290px;
    border-radius: 20px;
    border: 1.5px dashed rgba(226, 201, 151, 0.3);
    background: rgba(255, 255, 255, 0.01);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    transition: all var(--transition);
}

.upload-custom:hover {
    border-color: var(--accent);
    background: rgba(226, 201, 151, 0.01);
}

.upload-custom input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 5;
}

#uploadContent {
    text-align: center;
    padding: 30px;
    pointer-events: none;
}

.upload-icon-circle {
    width: 70px;
    height: 70px;
    margin: 0 auto 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(226, 201, 151, 0.05);
    color: var(--accent);
    font-size: 26px;
    border: 1px solid rgba(226, 201, 151, 0.1);
    transition: all var(--transition);
}

.upload-custom:hover .upload-icon-circle {
    transform: scale(1.05);
    background: rgba(226, 201, 151, 0.08);
}

#uploadContent h4 {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 6px 0;
    color: var(--text-primary);
}

#uploadContent p {
    color: var(--text-muted);
    font-size: 13px;
    margin: 0 0 14px 0;
}

#fileName {
    display: inline-block;
    font-size: 12px;
    font-weight: 500;
    color: var(--accent);
    background: rgba(226, 201, 151, 0.06);
    padding: 5px 14px;
    border-radius: 30px;
    border: 1px solid rgba(226, 201, 151, 0.12);
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
    display: none;
    z-index: 2;
}

/* Modern High-End Glow Submission Button */
.form-actions-wrapper {
    margin-top: 40px;
}

.btn-submit-modern {
    position: relative;
    width: 100%;
    height: 60px;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--accent), var(--accent-hover));
    color: var(--bg-primary);
    font-weight: 700;
    font-size: 15px;
    letter-spacing: 0.5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    overflow: hidden;
    transition: all var(--transition);
}

.btn-submit-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(226, 201, 151, 0.2);
}

/* Premium Error Custom Alert Box */
.custom-alert.error {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    padding: 20px 24px;
    border-radius: 16px;
    margin-bottom: 40px;
    border-left: 3px solid #ef4444;
    background: linear-gradient(90deg, rgba(239, 68, 68, 0.02) 0%, rgba(18, 18, 18, 0.4) 100%);
}

.alert-icon-wrapper {
    color: #ff7b7b;
    font-size: 18px;
    margin-top: 2px;
}

.alert-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.alert-title {
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #ff7b7b;
}

.alert-desc {
    font-size: 14px;
    color: #fca5a5;
    line-height: 1.5;
}

/* Responsive Adaptive View Engine */
@media (max-width: 991px) {
    .admin-main { margin-left: 0; padding: 120px 24px 40px 24px; }
    .top-section { margin-bottom: 30px; }
    .dashboard-title { font-size: 38px; }
    .table-box { padding: 26px; }
    .admin-grid { grid-template-columns: 1fr; gap: 30px; }
    .form-actions-wrapper { margin-top: 20px; }
}
</style>

</body>
</html>