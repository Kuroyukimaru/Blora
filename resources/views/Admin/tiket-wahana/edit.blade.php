<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tiket Wahana — Admin Panel</title>

    <!-- FONTS Premium (Inter & Playfair Display) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

    <!-- SIDEBAR -->
    @include('admin.partials.sidebar')

    <!-- MAIN CONTENT -->
    <main class="admin-main">

        <!-- HEADER BANNER -->
        <div class="top-section">
            <div class="header-text-wrapper">
                <span class="dashboard-subtitle">ADMIN PANEL / MANAGEMENT</span>
                <h1 class="dashboard-title text-gradient">Edit Tiket Wahana</h1>
                <p class="dashboard-desc">Perbarui kredensial data, penyesuaian tarif berkala, atau regulasi operasional manifes wahana yang telah terdaftar pada sistem.</p>
            </div>
        </div>

        <!-- ERROR HANDLING BANNER -->
        @if ($errors->any())
            <div class="custom-alert error glass-effect">
                <div class="alert-icon-wrapper">
                    <i class="fas fa-circle-exclamation"></i>
                </div>
                <div class="alert-content">
                    <span class="alert-title">Gagal Memproses Data</span>
                    <ul class="alert-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- MAIN LAYOUT GRID -->
        <div class="layout-grid">

            <!-- FORM ENTRY (LEFT CARD) -->
            <div class="table-box glass-effect entry-card">
                <form action="/admin/tiket-wahana/update/{{ $tiketWahana->id }}" method="POST" id="tiketForm" class="form-wrapper">
                    @csrf
                    @method('PUT')

                    <div class="form-group-custom">
                        <label class="form-label-custom">Nama Entitas Wahana</label>
                        <div class="input-custom-wrapper">
                            <i class="fas fa-ticket input-icon"></i>
                            <input type="text" name="wahana" id="wahanaInput" value="{{ old('wahana', $tiketWahana->wahana) }}" placeholder="Contoh: Ferris Wheel Deluxe, Roller Coaster" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Regulasi & Ketentuan Wahana</label>
                        <div class="textarea-custom-wrapper">
                            <textarea name="ketentuan" id="ketentuanInput" rows="5" placeholder="Tuliskan batas tinggi badan minimum, batasan usia, atau kondisi kesehatan khusus pengunjung di sini...">{{ old('ketentuan', $tiketWahana->ketentuan) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label class="form-label-custom">Nominal Tarif Masuk (IDR)</label>
                        <div class="input-custom-wrapper">
                            <i class="fas fa-wallet input-icon"></i>
                            <input type="text" id="harga" name="harga" value="{{ old('harga', number_format($tiketWahana->harga, 0, ',', '.')) }}" placeholder="2.000" autocomplete="off" maxlength="12" required>
                        </div>
                        <small class="input-helper"><i class="fas fa-info-circle"></i> Batas minimal nominal transaksi yang diizinkan sistem adalah Rp 2.000</small>
                    </div>

                    <button type="submit" class="btn-submit-luxury">
                        <span class="btn-text">Perbarui & Sinkronisasikan Tiket</span>
                        <i class="fas fa-arrow-right-long"></i>
                    </button>
                </form>
            </div>

            <!-- INTERACTIVE LIVE PREVIEW (RIGHT CARD) -->
            <div class="preview-sticky-container">
                <div class="ticket-preview-card glass-effect">
                    <div class="preview-glow"></div>
                    
                    <!-- Top Ribbon -->
                    <div class="ticket-top-ribbon">
                        <div class="ticket-badge">ADMISSION TICKET</div>
                        <div class="ticket-serial">ID #{{ $tiketWahana->id }}</div>
                    </div>

                    <!-- Main Core Content -->
                    <div class="ticket-body">
                        <div class="ticket-brand">
                            <div class="brand-circle">
                                <i class="fas fa-fort-awesome"></i>
                            </div>
                            <span class="brand-text">Premium Theme Park</span>
                        </div>

                        <h2 id="previewNama" class="ticket-title">{{ $tiketWahana->wahana }}</h2>
                        
                        <div class="ticket-price-container">
                            <span class="currency-tag">TARIF MASUK</span>
                            <div id="previewHarga" class="ticket-price">Rp {{ number_format($tiketWahana->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <!-- Decorative Separation Line (Stub Cut Effect) -->
                    <div class="ticket-divider">
                        <div class="notch left"></div>
                        <div class="dashed-line"></div>
                        <div class="notch right"></div>
                    </div>

                    <!-- Bottom Rules Content -->
                    <div class="ticket-footer">
                        <span class="footer-label">KETENTUAN & REGULASI VALIDASI</span>
                        <p id="previewKetentuan" class="footer-text">{{ $tiketWahana->ketentuan ?: 'Ketentuan tiket wahana serta batasan operasional pengunjung akan ter-render secara real-time di area manifes ini.' }}</p>
                    </div>
                </div>
            </div>

        </div>

    </main>

<script>
/* ==========================================================================
   INTERACTIVE LIVE PREVIEW ENGINE & VALIDATION
   ========================================================================== */

const hargaInput = document.getElementById('harga');
const previewHarga = document.getElementById('previewHarga');
const wahanaInput = document.getElementById('wahanaInput');
const ketentuanInput = document.getElementById('ketentuanInput');

// Formatting & Syncing Price Field
hargaInput.addEventListener('input', function(e) {
    let rawValue = e.target.value.replace(/\D/g, '');

    if (rawValue && parseInt(rawValue) < 2000) {
        previewHarga.innerText = 'Min Rp 2.000';
        previewHarga.classList.add('invalid-price');
    } else {
        previewHarga.classList.remove('invalid-price');
    }

    let formatted = '';
    if (rawValue) {
        formatted = new Intl.NumberFormat('id-ID').format(rawValue);
    }

    e.target.value = formatted;
    previewHarga.innerText = rawValue ? 'Rp ' + formatted : 'Rp 0';
});

// Syncing Attraction Name
wahanaInput.addEventListener('input', function() {
    document.getElementById('previewNama').innerText = this.value.trim() || 'Nama Wahana';
});

// Syncing Regulation/Terms
ketentuanInput.addEventListener('input', function() {
    document.getElementById('previewKetentuan').innerText = this.value.trim() || 'Ketentuan tiket wahana serta batasan operasional pengunjung akan ter-render secara real-time di area manifes ini.';
});

// Safe Form Interception & Submission Cleanup
document.getElementById('tiketForm').addEventListener('submit', function(event) {
    let finalHarga = parseInt(hargaInput.value.replace(/\./g, ''));

    if (finalHarga < 2000 || isNaN(finalHarga)) {
        event.preventDefault();
        alert('Gagal Menyimpan: Batas nilai nominal harga tiket wahana minimal adalah Rp 2.000');
        return;
    }

    // Strip out all thousand dots separator before sending to backend database integers
    hargaInput.value = finalHarga;
});
</script>

<style>
/* ==========================================================================
   ADVANCED LUXURY THEME UI DESIGN (MATCHED & REFINED) - NO COLOR ALTERATIONS
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
    max-width: 650px;
    line-height: 1.6;
}

/* Premium Glassmorphic Foundation Style */
.glass-effect {
    background: rgba(18, 18, 18, 0.4);
    border: 1px solid var(--border-soft);
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}

/* Layout Grid System */
.layout-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 40px;
    align-items: start;
}

/* Form Container Style Card */
.entry-card {
    border-radius: 24px;
    padding: 45px;
}

.form-wrapper {
    display: flex;
    flex-direction: column;
    gap: 28px;
}

.form-group-custom {
    display: flex;
    flex-direction: column;
}

.form-label-custom {
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.5px;
    color: var(--text-secondary);
    margin-bottom: 12px;
}

/* Input Fields Engineering */
.input-custom-wrapper {
    position: relative;
    width: 100%;
}

.input-icon {
    position: absolute;
    top: 50%;
    left: 22px;
    transform: translateY(-50%);
    color: var(--accent-dark);
    font-size: 15px;
    transition: color 0.3s ease;
}

.input-custom-wrapper input {
    width: 100%;
    height: 58px;
    padding: 0 24px 0 56px;
    border-radius: 14px;
    border: 1px solid var(--border-soft);
    background: rgba(255, 255, 255, 0.02);
    color: var(--text-primary);
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
    transition: all var(--transition);
}

.input-custom-wrapper input:focus {
    border-color: var(--accent);
    background: rgba(226, 201, 151, 0.02);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.08);
}

.input-custom-wrapper input:focus + .input-icon {
    color: var(--accent);
}

/* Textarea Engineering */
.textarea-custom-wrapper textarea {
    width: 100%;
    padding: 20px 24px;
    border-radius: 14px;
    border: 1px solid var(--border-soft);
    background: rgba(255, 255, 255, 0.02);
    color: var(--text-primary);
    font-size: 14px;
    line-height: 1.7;
    outline: none;
    box-sizing: border-box;
    resize: none;
    transition: all var(--transition);
}

.textarea-custom-wrapper textarea:focus {
    border-color: var(--accent);
    background: rgba(226, 201, 151, 0.02);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.08);
}

.input-helper {
    color: var(--text-muted);
    font-size: 12px;
    margin-top: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Luxury Call-To-Action Button */
.btn-submit-luxury {
    position: relative;
    width: 100%;
    height: 58px;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--accent), var(--accent-hover));
    color: var(--bg-primary);
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    overflow: hidden;
    transition: all var(--transition);
}

.btn-submit-luxury:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(226, 201, 151, 0.25);
}

.btn-submit-luxury i {
    transition: transform 0.3s ease;
}

.btn-submit-luxury:hover i {
    transform: translateX(4px);
}

/* ==========================================================================
   TICKET LIVE PREVIEW LUXURY COMPONENT (RIGHT SIDE)
   ========================================================================== */

.preview-sticky-container {
    position: sticky;
    top: 40px;
}

.ticket-preview-card {
    border-radius: 28px;
    overflow: hidden;
    position: relative;
    border: 1px solid var(--border-gold);
}

.preview-glow {
    position: absolute;
    width: 250px;
    height: 250px;
    top: -100px;
    right: -100px;
    border-radius: 50%;
    background: rgba(226, 201, 151, 0.08);
    filter: blur(60px);
    pointer-events: none;
}

.ticket-top-ribbon {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px 32px 12px 32px;
}

.ticket-badge {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    color: var(--accent);
    background: rgba(226, 201, 151, 0.1);
    padding: 6px 14px;
    border-radius: 30px;
}

.ticket-serial {
    font-size: 11px;
    font-weight: 500;
    color: var(--text-muted);
    letter-spacing: 1px;
}

.ticket-body {
    padding: 20px 32px 32px 32px;
}

.ticket-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 24px;
}

.brand-circle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(226, 201, 151, 0.1);
    color: var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
}

.brand-text {
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 1px;
    color: var(--text-secondary);
    text-transform: uppercase;
}

.ticket-title {
    font-family: 'Playfair Display', serif;
    font-size: 38px;
    font-weight: 700;
    margin: 0 0 28px 0;
    line-height: 1.2;
    color: var(--text-primary);
    word-break: break-word;
}

.ticket-price-container {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.currency-tag {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    color: var(--accent-dark);
}

.ticket-price {
    font-size: 32px;
    font-weight: 800;
    color: var(--text-primary);
    letter-spacing: -0.5px;
    transition: color 0.3s ease;
}

.ticket-price.invalid-price {
    color: #ff7b7b;
    font-size: 24px;
}

/* Ticket Stub Separation Line */
.ticket-divider {
    position: relative;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notch {
    position: absolute;
    width: 24px;
    height: 24px;
    background: var(--bg-primary);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}

.notch.left { left: -13px; border-right: 1px solid var(--border-gold); }
.notch.right { right: -13px; border-left: 1px solid var(--border-gold); }

.dashed-line {
    width: calc(100% - 32px);
    height: 0px;
    border-top: 1.5px dashed rgba(226, 201, 151, 0.2);
}

/* Ticket Bottom Rules Section */
.ticket-footer {
    padding: 32px;
}

.footer-label {
    display: block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2px;
    color: var(--accent-dark);
    margin-bottom: 12px;
}

.footer-text {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.7;
    margin: 0;
    word-break: break-word;
}

/* Error Notification Bar Alerts */
.custom-alert.error {
    display: flex;
    align-items: flex-start;
    gap: 18px;
    padding: 22px 28px;
    border-radius: 16px;
    margin-bottom: 35px;
    border-left: 3px solid #ef4444;
    background: linear-gradient(90deg, rgba(239, 68, 68, 0.02) 0%, rgba(18, 18, 18, 0.4) 100%);
}

.alert-icon-wrapper { color: #ff7b7b; font-size: 18px; margin-top: 2px; }
.alert-content { display: flex; flex-direction: column; gap: 4px; }
.alert-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #ff7b7b; }
.alert-list { margin: 4px 0 0 0; padding-left: 16px; color: #ffb4b4; font-size: 14px; display: flex; flex-direction: column; gap: 4px; }

/* Responsive Engines Adaptor */
@media (max-width: 1300px) {
    .layout-grid { grid-template-columns: 1fr; gap: 35px; }
    .preview-sticky-container { position: relative; top: 0; }
}

@media (max-width: 991px) {
    .admin-main { margin-left: 0; padding: 120px 24px 40px 24px; }
    .dashboard-title { font-size: 38px; }
    .entry-card { padding: 32px; }
}

@media (max-width: 576px) {
    .entry-card { padding: 24px; }
    .ticket-body, .ticket-footer { padding: 24px; }
    .ticket-title { font-size: 30px; }
}
</style>

</body>
</html>