<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Tiket Wahana — Admin Panel</title>

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
                <span class="dashboard-subtitle">ADMIN PANEL / MANAGEMENT</span>
                <h1 class="dashboard-title text-gradient">Kelola Tiket Wahana</h1>Kelola daftar tiket wahana dan kustomisasi nominal tarif masuk.
                <p class="dashboard-desc"></p>
            </div>

            <a href="/admin/tiket-wahana/create" class="btn-add">
                <div class="btn-add-glow"></div>
                <i class="fas fa-plus"></i>
                <span>Tambah Tiket</span>
            </a>
        </div>

        @if(session('success'))
            <div class="custom-alert success glass-effect">
                <div class="alert-icon-wrapper">
                    <i class="fas fa-circle-check"></i>
                </div>
                <div class="alert-content">
                    <span class="alert-title">Aksi Berhasil</span>
                    <span class="alert-desc">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="table-filter-wrapper">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchTiket" placeholder="Cari entitas nama wahana...">
            </div>
        </div>

        <div class="table-box glass-effect">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Wahana</th>
                            <th>Ketentuan Operasional</th>
                            <th width="200">Harga Tiket</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tiketWahanas as $tiket)
                        <tr class="tiket-row" data-nama="{{ strtolower($tiket->wahana) }}">

                            <td>
                                <div class="wahana-wrapper">
                                    <div class="wahana-icon">
                                        <i class="fas fa-ticket"></i>
                                    </div>
                                    <div class="wahana-name">{{ $tiket->wahana }}</div>
                                </div>
                            </td>

                            <td>
                                <div class="ketentuan-text">
                                    {{ Str::limit($tiket->ketentuan, 100) }}
                                </div>
                            </td>

                            <td>
                                <span class="harga-badge">
                                    <span class="currency-prefix">Rp</span>{{ number_format($tiket->harga, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <div class="action-group">
                                    <a href="/admin/tiket-wahana/edit/{{ $tiket->id }}" class="btn-action edit-btn" title="Edit Tiket">
                                        <i class="fas fa-pen-nib"></i>
                                    </a>

                                    <button type="button" class="btn-action delete-btn" onclick="openDeleteModal({{ $tiket->id }})" title="Hapus Tiket">
                                        <i class="fas fa-trash-can"></i>
                                    </button>

                                    <form id="delete-form-{{ $tiket->id }}"
                                          action="/admin/tiket-wahana/delete/{{ $tiket->id }}"
                                          method="POST"
                                          style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon-circle">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <h3>Katalog Tiket Kosong</h3>
                                    <p>Belum ada manifest atau tarif tiket wahana baru yang terarsip di sistem.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-wrapper">
            <button id="prevPage" class="pagination-btn" title="Halaman Sebelumnya">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div id="paginationNumbers"></div>
            <button id="nextPage" class="pagination-btn" title="Halaman Selanjutnya">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

    </main>

    <div class="modal-overlay" id="deleteModal">
        <div class="delete-modal glass-effect">
            <div class="modal-icon">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
            <h3>Hapus Tiket?</h3>
            <p>Tindakan ini bersifat permanen. Data tiket wahana terpilih akan dihapus sepenuhnya dari server publikasi.</p>
            <div class="modal-buttons">
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
                <button type="button" class="btn-delete-confirm" id="confirmDeleteBtn">Ya, Eksekusi</button>
            </div>
        </div>
    </div>

<script>
/* ==========================================================================
   INTERACTIVE LOGIC & FILTERS
   ========================================================================== */

let selectedDeleteId = null;
const deleteModal = document.getElementById('deleteModal');
const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

function openDeleteModal(id) {
    selectedDeleteId = id;
    deleteModal.style.display = 'flex';
    setTimeout(() => { deleteModal.classList.add('active'); }, 10);
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    deleteModal.classList.remove('active');
    setTimeout(() => { deleteModal.style.display = 'none'; }, 300);
    document.body.style.overflow = 'auto';
}

confirmDeleteBtn.addEventListener('click', function() {
    if (!selectedDeleteId) return;
    document.getElementById('delete-form-' + selectedDeleteId).submit();
});

/* SEARCH & CLIENT-SIDE PAGINATION */
const searchTiket = document.getElementById('searchTiket');
const tiketRows = Array.from(document.querySelectorAll('.tiket-row'));
const itemsPerPage = 7;
let currentPage = 1;

function getFilteredRows() {
    return tiketRows.filter(row => {
        const keyword = searchTiket.value.toLowerCase();
        const nama = row.dataset.nama;
        return nama.includes(keyword);
    });
}

function renderButtons(totalPages) {
    const container = document.getElementById('paginationNumbers');
    container.innerHTML = '';

    if (totalPages <= 1) return;

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement('button');
        btn.className = 'number-btn';
        if (i === currentPage) btn.classList.add('active');
        btn.innerText = i;
        btn.onclick = () => {
            currentPage = i;
            renderPagination();
        };
        container.appendChild(btn);
    }

    document.getElementById('prevPage').disabled = currentPage === 1;
    document.getElementById('nextPage').disabled = currentPage === totalPages;
}

function renderPagination() {
    const filteredRows = getFilteredRows();
    const totalPages = Math.ceil(filteredRows.length / itemsPerPage);

    tiketRows.forEach(row => row.style.display = 'none');

    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    filteredRows.slice(start, end).forEach(row => row.style.display = '');
    renderButtons(totalPages);
}

document.getElementById('prevPage').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        renderPagination();
    }
});

document.getElementById('nextPage').addEventListener('click', () => {
    const totalPages = Math.ceil(getFilteredRows().length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderPagination();
    }
});

searchTiket.addEventListener('keyup', () => { currentPage = 1; renderPagination(); });

// Initialization Run
renderPagination();
</script>

<style>
/* ==========================================================================
   ADVANCED MODERN DASHBOARD THEME (THE LUXURY MINIMALIST) - NO COLOR ALTERATIONS
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
    max-width: 600px;
    line-height: 1.5;
}

/* Premium Glassmorphic Style Generator */
.glass-effect {
    background: rgba(18, 18, 18, 0.4);
    border: 1px solid var(--border-soft);
    box-shadow: var(--shadow-soft);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}

/* CTA Adding Button Wrapper */
.btn-add {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 32px;
    border-radius: 14px;
    text-decoration: none;
    background: linear-gradient(135deg, var(--accent), var(--accent-hover));
    color: var(--bg-primary);
    font-weight: 700;
    font-size: 14px;
    transition: all var(--transition);
    overflow: hidden;
}

.btn-add:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(226, 201, 151, 0.25);
}

/* Controls Filters Layout */
.table-filter-wrapper {
    display: flex;
    gap: 20px;
    margin-bottom: 35px;
}

.search-box {
    flex: 1;
    position: relative;
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
    height: 56px;
    padding: 0 24px 0 56px;
    border-radius: 14px;
    border: 1px solid var(--border-soft);
    background: rgba(255, 255, 255, 0.02);
    color: var(--text-primary);
    font-size: 14px;
    outline: none;
    transition: all var(--transition);
}

.search-box input:focus {
    border-color: var(--accent);
    background: rgba(226, 201, 151, 0.02);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.08);
}

/* Master Grid Table Box */
.table-box {
    border-radius: 20px;
    overflow: hidden;
}

.custom-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.custom-table th {
    padding: 22px 24px;
    color: var(--accent);
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    border-bottom: 1px solid var(--border-soft);
    background: rgba(255, 255, 255, 0.01);
}

.custom-table td {
    padding: 20px 24px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    vertical-align: middle;
}

.custom-table tbody tr {
    transition: background var(--transition);
}

.custom-table tbody tr:hover {
    background: rgba(226, 201, 151, 0.01);
}

/* Row Visual Elements */
.wahana-wrapper {
    display: flex;
    align-items: center;
    gap: 16px;
}

.wahana-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(226, 201, 151, 0.06);
    border: 1px solid rgba(226, 201, 151, 0.15);
    color: var(--accent);
    font-size: 16px;
}

.wahana-name {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
}

.ketentuan-text {
    color: var(--text-muted);
    font-size: 14px;
    line-height: 1.6;
}

.harga-badge {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
}

.currency-prefix {
    font-size: 12px;
    color: var(--accent-dark);
    margin-right: 2px;
    font-weight: 500;
}

/* Micro-interaction Action Triggers */
.action-group {
    display: flex;
    gap: 8px;
}

.btn-action {
    width: 38px;
    height: 38px;
    border: none;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 14px;
    transition: all var(--transition);
    text-decoration: none;
}

.edit-btn {
    background: rgba(59, 130, 246, 0.06);
    color: #60a5fa;
    border: 1px solid rgba(59, 130, 246, 0.15);
}
.edit-btn:hover { background: #3b82f6; color: white; transform: translateY(-2px); }

.delete-btn {
    background: rgba(239, 68, 68, 0.06);
    color: #ff7b7b;
    border: 1px solid rgba(239, 68, 68, 0.15);
}
.delete-btn:hover { background: #ef4444; color: white; transform: translateY(-2px); }

/* Premium Success Banner Alerts */
.custom-alert.success {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 22px;
    border-radius: 14px;
    margin-bottom: 35px;
    border-left: 3px solid var(--accent);
    background: linear-gradient(90deg, rgba(226, 201, 151, 0.03) 0%, rgba(18, 18, 18, 0.4) 100%);
}

.alert-icon-wrapper { color: var(--accent); font-size: 18px; }
.alert-content { display: flex; flex-direction: column; gap: 2px; }
.alert-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--accent); }
.alert-desc { font-size: 14px; color: var(--text-secondary); }

/* Clean Empty State Representation */
.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-icon-circle {
    width: 64px;
    height: 64px;
    background: rgba(226, 201, 151, 0.04);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--accent);
    font-size: 24px;
    margin-bottom: 18px;
}

.empty-state h3 { font-size: 18px; font-weight: 600; margin: 0 0 6px 0; color: var(--text-primary); }
.empty-state p { color: var(--text-muted); font-size: 14px; margin: 0; }

/* Fixed Horizontal Pagination */
.pagination-wrapper {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 35px;
}

#paginationNumbers {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.pagination-btn, .number-btn {
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    border: 1px solid var(--border-soft);
    border-radius: 10px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 13px;
    background: rgba(255, 255, 255, 0.01);
    color: var(--text-secondary);
    transition: all var(--transition);
}

.pagination-btn:hover:not(:disabled), .number-btn:hover {
    border-color: var(--accent);
    color: var(--text-primary);
    background: rgba(226, 201, 151, 0.02);
}

.pagination-btn:disabled { opacity: 0.3; cursor: not-allowed; }

.number-btn.active {
    background: var(--accent);
    color: var(--bg-primary);
    border-color: var(--accent);
    font-weight: 700;
}

/* Modals Overlay Architecture */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-overlay.active { opacity: 1; }

.delete-modal {
    width: 90%;
    max-width: 400px;
    padding: 36px;
    border-radius: 24px;
    text-align: center;
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.modal-overlay.active .delete-modal { transform: translateY(0); }

.modal-icon {
    width: 54px;
    height: 54px;
    background: rgba(239, 68, 68, 0.08);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #ff7b7b;
    font-size: 20px;
    margin-bottom: 16px;
}

.delete-modal h3 { font-size: 20px; margin: 0 0 8px 0; font-weight: 700; color: var(--text-primary); }
.delete-modal p { color: var(--text-muted); font-size: 14px; line-height: 1.5; margin: 0 0 24px 0; }

.modal-buttons { display: flex; gap: 12px; }

.btn-cancel, .btn-delete-confirm {
    flex: 1;
    height: 48px;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    transition: all var(--transition);
}

.btn-cancel {
    background: rgba(255, 255, 255, 0.04);
    color: var(--text-primary);
    border: 1px solid var(--border-soft);
}
.btn-cancel:hover { background: rgba(255, 255, 255, 0.08); }

.btn-delete-confirm { background: #ef4444; color: white; }
.btn-delete-confirm:hover { background: #dc2626; box-shadow: 0 6px 15px rgba(239,68,68,0.25); }

/* Responsive Adapter Engine */
@media (max-width: 991px) {
    .admin-main { margin-left: 0; padding: 120px 24px 40px 24px; }
    .top-section { flex-direction: column; align-items: flex-start; gap: 20px; }
    .btn-add { width: 100%; justify-content: center; }
    .table-filter-wrapper { flex-direction: column; gap: 14px; }
    .custom-table { min-width: 850px; }
}
</style>

</body>
</html>