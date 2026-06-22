<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Modern Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

    @include('admin.partials.sidebar')

    <main class="admin-content">

        <div class="admin-header">
            <div>
                <span class="admin-subtitle">ADMIN PANEL</span>
                <h1 class="admin-title">Edit Menu</h1>
                <p class="admin-description">
                    Update minuman, sambal, paket, dan menu lainnya dengan mudah dalam satu panel terpusat.
                </p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert-custom">
                <div class="alert-icon">
                    <i class="fas fa-circle-exclamation"></i>
                </div>
                <div>
                    @foreach ($errors->all() as $error)
                        <div class="alert-text">{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="admin-card">
            <form action="/admin/menu/update/{{ $menu->id }}" method="POST" enctype="multipart/form-data" id="menuForm">
                @csrf
                @method('PUT')

                <div class="admin-grid">

                    <div class="form-column">

                        <div class="form-group-custom">
                            <label class="form-label-custom">Nama Menu</label>
                            <div class="input-custom">
                                <i class="fas fa-utensils"></i>
                                <input type="text" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" placeholder="Masukkan nama menu" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Deskripsi Menu</label>
                            <textarea name="deskripsi" class="textarea-custom" rows="6" placeholder="Tuliskan komposisi atau keunikan dari menu ini...">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                        </div>

                        @if($menu->gambar)
                            <div class="form-group-custom">
                                <label class="form-label-custom">Gambar Saat Ini</label>
                                <div class="preview-wrapper">
                                    <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="preview-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    
                                    <div class="image-error" style="display:none;">
                                        <i class="fas fa-image"></i>
                                        <span>Gambar tidak ditemukan</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-column">

                        <div class="form-group-custom">
                            <label class="form-label-custom">Kategori</label>
                            <select name="kategori" class="select-custom" required>
                                <option value="Minuman" {{ old('kategori', $menu->kategori) == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="Sambal" {{ old('kategori', $menu->kategori) == 'Sambal' ? 'selected' : '' }}>Sambal</option>
                                <option value="Lainnya" {{ old('kategori', $menu->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                <option value="Paket" {{ old('kategori', $menu->kategori) == 'Paket' ? 'selected' : '' }}>Paket</option>
                            </select>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Harga</label>
                            <div class="input-custom">
                                <i class="fas fa-wallet"></i>
                                <input type="text" id="harga" name="harga" value="{{ old('harga', number_format($menu->harga, 0, ',', '.')) }}" placeholder="Contoh: 25.000" autocomplete="off" inputmode="numeric" maxlength="9" required>
                            </div>
                            <small class="input-helper">
                                <i class="fas fa-info-circle"></i> Rentang harga yang diizinkan: Rp 3.000 - Rp 1.000.000
                            </small>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Status Ketersediaan</label>
                            <select name="status" class="select-custom">
                                <option value="Tersedia" {{ old('status', $menu->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Habis" {{ old('status', $menu->status) == 'Habis' ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Upload Gambar Baru</label>
                            <div class="upload-custom">
                                <img id="newPreview" class="new-preview-image" style="display:none;">
                                <div id="uploadContent">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-arrow-up"></i>
                                    </div>
                                    <h4>Pilih atau Tarik Gambar</h4>
                                    <p>JPG, PNG, JPEG &bull; Maksimal 2MB</p>
                                    <span id="fileName">Belum ada gambar dipilih</span>
                                </div>
                                <input type="file" name="gambar" id="gambarInput" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>

                        <button type="submit" class="btn-submit-modern">
                            <i class="fas fa-floppy-disk"></i>
                            Simpan Perubahan Menu
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </main>

    <div class="custom-modal" id="customModal">
        <div class="modal-box">
            <div class="modal-icon">
                <i class="fas fa-circle-exclamation"></i>
            </div>
            <h3 id="modalTitle">Peringatan</h3>
            <p id="modalMessage">Pesan modal</p>
            <button type="button" class="modal-button" onclick="closeModal()">Mengerti</button>
        </div>
    </div>

<script>
/* FORMAT HARGA */
const hargaInput = document.getElementById('harga');
hargaInput.addEventListener('input', function(e){
    let value = e.target.value.replace(/\D/g, '');
    if(parseInt(value) > 1000000){
        value = '1000000';
    }
    if(value){
        value = new Intl.NumberFormat('id-ID').format(value);
    }
    e.target.value = value;
});

/* CUSTOM MODAL */
function showModal(title, message){
    document.getElementById('modalTitle').innerText = title;
    document.getElementById('modalMessage').innerText = message;
    document.getElementById('customModal').classList.add('active');
}

function closeModal(){
    document.getElementById('customModal').classList.remove('active');
}

/* VALIDASI FORM */
document.getElementById('menuForm').addEventListener('submit', function(e){
    let rawValue = hargaInput.value.replace(/\./g, '');
    if(!rawValue || parseInt(rawValue) < 3000 || parseInt(rawValue) > 1000000){
        e.preventDefault();
        showModal('Harga Tidak Valid', 'Harga menu harus di antara Rp 3.000 sampai Rp 1.000.000');
        return;
    }
    hargaInput.value = rawValue;
});

/* PREVIEW IMAGE */
const gambarInput = document.getElementById('gambarInput');
const newPreview = document.getElementById('newPreview');
const fileName = document.getElementById('fileName');
const uploadContent = document.getElementById('uploadContent');

gambarInput.addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const allowed = ['image/jpeg', 'image/jpg', 'image/png'];
        if(!allowed.includes(file.type)){
            gambarInput.value = '';
            showModal('Format Tidak Didukung', 'Format gambar harus JPG, JPEG, atau PNG');
            return;
        }
        if(file.size > 2 * 1024 * 1024){
            gambarInput.value = '';
            showModal('Ukuran Terlalu Besar', 'Ukuran gambar maksimal 2MB');
            return;
        }
        fileName.innerText = file.name;
        const reader = new FileReader();
        reader.onload = function(event){
            newPreview.src = event.target.result;
            newPreview.style.display = 'block';
            uploadContent.style.display = 'none';
        }
        reader.readAsDataURL(file);
    }
});

/* AUTO HIDE ALERT */
setTimeout(() => {
    const alert = document.querySelector('.alert-custom');
    if(alert){
        alert.style.opacity = '0';
        setTimeout(() => { alert.remove(); }, 400);
    }
}, 4000);
</script>

<style>
/* GENERAL STYLES */
body {
    background: var(--bg-primary);
    color: var(--text-primary);
    font-family: 'Inter', sans-serif;
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
}

.admin-content {
    margin-left: 300px;
    min-height: 100vh;
    padding: 60px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* HEADER STYLE */
.admin-header {
    margin-bottom: 45px;
}

.admin-subtitle {
    color: var(--accent);
    font-size: 11px;
    letter-spacing: 5px;
    font-weight: 800;
    text-transform: uppercase;
    opacity: 0.8;
}

.admin-title {
    font-size: 52px;
    font-weight: 900;
    letter-spacing: -1.5px;
    margin: 10px 0 16px 0;
    line-height: 1.1;
}

.admin-description {
    color: var(--text-secondary);
    max-width: 600px;
    font-size: 16px;
    line-height: 1.7;
    font-weight: 400;
}

/* CARD GLASSMORPHISM DESIGN */
.admin-card {
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid var(--border-gold);
    border-radius: 32px;
    padding: 48px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

.admin-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 48px;
}

.form-column {
    display: flex;
    flex-direction: column;
}

.form-group-custom {
    margin-bottom: 30px;
}

.form-label-custom {
    display: block;
    margin-bottom: 12px;
    font-weight: 600;
    font-size: 14px;
    letter-spacing: 0.3px;
    color: var(--text-primary);
}

/* INPUTS & TEXTAREA UTILITIES */
.input-custom {
    position: relative;
}

.input-custom i {
    position: absolute;
    top: 50%;
    left: 22px;
    transform: translateY(-50%);
    color: var(--accent);
    font-size: 16px;
    pointer-events: none;
    transition: transform 0.3s ease;
}

.input-custom input {
    width: 100%;
    height: 58px;
    padding: 0 22px 0 58px;
    border-radius: 16px;
    border: 1px solid var(--border-soft);
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 15px;
    outline: none;
    box-sizing: border-box;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.input-custom input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.15);
}

.input-custom input:focus + i {
    transform: translateY(-50%) scale(1.1);
}

.input-custom input::placeholder,
.textarea-custom::placeholder {
    color: var(--text-muted);
    opacity: 0.6;
}

.textarea-custom {
    width: 100%;
    padding: 20px;
    border-radius: 18px;
    border: 1px solid var(--border-soft);
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 15px;
    resize: none;
    outline: none;
    box-sizing: border-box;
    line-height: 1.6;
    transition: all 0.3s ease;
}

.textarea-custom:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.15);
}

/* SELECT CUSTOM */
.select-custom {
    width: 100%;
    height: 58px;
    padding: 0 55px 0 22px;
    border-radius: 16px;
    border: 1px solid var(--border-soft);
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 15px;
    outline: none;
    appearance: none;
    box-sizing: border-box;
    cursor: pointer;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg width='20' height='20' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10L12 15L17 10' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 20px center;
    background-size: 16px;
    transition: all 0.3s ease;
}

.select-custom:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.15);
}

.select-custom option {
    background: var(--bg-secondary);
    color: var(--text-primary);
    padding: 12px;
}

.input-helper {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
    font-size: 12px;
    color: var(--text-muted);
}

/* IMAGE PREVIEW ARCHITECTURE */
.preview-wrapper {
    width: 100%;
    height: 240px;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid var(--border-gold);
    background: rgba(255, 255, 255, 0.01);
    box-shadow: inset 0 2px 8px rgba(0,0,0,0.4);
}

.preview-image,
.new-preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.preview-wrapper:hover .preview-image {
    transform: scale(1.04);
}

.image-error {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content:center;
    gap: 12px;
    color: var(--text-muted);
    font-size: 14px;
}

.image-error i {
    font-size: 28px;
}

/* MODERN BLURRED UPLOAD BOX */
.upload-custom {
    position: relative;
    min-height: 240px;
    border-radius: 20px;
    border: 2px dashed var(--border-gold);
    background: rgba(255, 255, 255, 0.01);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.upload-custom:hover {
    background: rgba(226, 201, 151, 0.02);
    border-color: var(--accent-hover);
}

.upload-custom input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 2;
}

#uploadContent {
    text-align: center;
    padding: 24px;
    pointer-events: none;
    transition: opacity 0.3s ease;
}

.upload-icon {
    width: 74px;
    height: 74px;
    margin: 0 auto 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(226, 201, 151, 0.06);
    color: var(--accent);
    font-size: 26px;
    transition: all 0.3s ease;
}

.upload-custom:hover .upload-icon {
    transform: translateY(-4px);
    background: rgba(226, 201, 151, 0.1);
}

#uploadContent h4 {
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 6px 0;
}

#uploadContent p {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0 0 12px 0;
}

#fileName {
    font-size: 12px;
    color: var(--accent);
    font-weight: 500;
    background: rgba(226, 201, 151, 0.08);
    padding: 4px 12px;
    border-radius: 20px;
}

/* INTERACTIVE BUTTONS */
.btn-submit-modern {
    width: 100%;
    height: 58px;
    border: none;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--accent), var(--accent-hover));
    color: var(--bg-primary);
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    box-shadow: 0 10px 25px -5px rgba(226, 201, 151, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-submit-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px -5px rgba(226, 201, 151, 0.45);
}

.btn-submit-modern:active {
    transform: translateY(1px);
}

/* ALERTS & NOTIFICATIONS */
.alert-custom {
    display: flex;
    gap: 16px;
    padding: 20px 24px;
    margin-bottom: 35px;
    border-radius: 18px;
    background: rgba(220, 53, 69, 0.06);
    border: 1px solid rgba(220, 53, 69, 0.2);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.alert-icon {
    color: #ff6b6b;
    font-size: 18px;
    margin-top: 2px;
}

.alert-text {
    color: #ffb3b3;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.5;
}

/* OVERSAMPLED HIGH-CLASS MODAL */
.custom-modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 9999;
}

.custom-modal.active {
    opacity: 1;
    visibility: visible;
}

.modal-box {
    width: 90%;
    max-width: 400px;
    background: var(--bg-secondary);
    border: 1px solid var(--border-gold);
    border-radius: 28px;
    padding: 44px 36px;
    text-align: center;
    transform: scale(0.9) translateY(20px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 30px 70px rgba(0,0,0,0.8);
}

.custom-modal.active .modal-box {
    transform: scale(1) translateY(0);
}

.modal-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(220, 53, 69, 0.1);
    color: #ff6b6b;
    font-size: 32px;
}

.modal-box h3 {
    font-size: 24px;
    font-weight: 800;
    margin: 0 0 12px 0;
    letter-spacing: -0.5px;
}

.modal-box p {
    color: var(--text-secondary);
    font-size: 14px;
    line-height: 1.6;
    margin: 0 0 28px 0;
}

.modal-button {
    width: 100%;
    height: 52px;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--accent), var(--accent-hover));
    color: var(--bg-primary);
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(226, 201, 151, 0.25);
}

/* RESPONSIVE BREAKPOINTS */
@media (max-width: 1200px) {
    .admin-grid {
        gap: 32px;
    }
    .admin-card {
        padding: 36px;
    }
}

@media (max-width: 991px) {
    .admin-content {
        margin-left: 0;
        padding: 100px 24px 40px;
    }

    .admin-grid {
        grid-template-columns: 1fr;
        gap: 0;
    }
    
    .admin-title {
        font-size: 40px;
    }
}
</style>

</body>
</html>