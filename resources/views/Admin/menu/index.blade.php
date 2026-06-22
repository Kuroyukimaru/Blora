<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu — Admin Panel</title>

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
                <h1 class="dashboard-title text-gradient">Kelola Menu</h1>
                <p class="dashboard-desc">Kelola ragam kuliner khas, paket hidangan, racikan sambal, dan kustomisasi menu.</p>
            </div>

            <a href="/admin/menu/create" class="btn-add">
                <div class="btn-add-glow"></div>
                <i class="fas fa-plus"></i>
                <span>Tambah Menu</span>
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
                <input type="text" id="searchMenu" placeholder="Cari entitas nama menu...">
            </div>

            <div class="filter-category">
                <select id="filterKategori">
                    <option value="all">Semua Kategori</option>
                    <option value="Paket">Paket Hidangan</option>
                    <option value="Minuman">Minuman Segar</option>
                    <option value="Sambal">Varian Sambal</option>
                    <option value="Lainnya">Menu Lainnya</option>
                </select>
            </div>
        </div>

        <div class="table-box glass-effect">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th width="110">Visual</th>
                            <th>Detail Hidangan</th>
                            <th width="160">Kategori</th>
                            <th width="160">Harga Satuan</th>
                            <th width="150">Status Rilis</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                        <tr class="menu-row"
                            data-kategori="{{ $menu->kategori }}"
                            data-nama="{{ strtolower($menu->nama_menu) }}">

                            <td>
                                @if($menu->gambar)
                                    <div class="menu-image-frame">
                                        <img src="{{ asset('storage/'.$menu->gambar) }}" class="menu-image" alt="{{ $menu->nama_menu }}">
                                    </div>
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div class="menu-info-wrapper">
                                    <div class="menu-name">{{ $menu->nama_menu }}</div>
                                    <div class="menu-desc">{{ Str::limit($menu->deskripsi, 75) }}</div>
                                </div>
                            </td>

                            <td>
                                <span class="category-badge">
                                    {{ $menu->kategori }}
                                </span>
                            </td>

                            <td>
                                <span class="menu-price">
                                    <span class="currency-prefix">Rp</span>{{ number_format($menu->harga, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="status-badge {{ $menu->status == 'Tersedia' ? 'tersedia' : 'habis' }}">
                                    <span class="status-dot"></span>
                                    {{ $menu->status }}
                                </span>
                            </td>

                            <td>
                                <div class="action-group">
                                    <a href="/admin/menu/edit/{{ $menu->id }}" class="btn-action edit-btn" title="Edit Menu">
                                        <i class="fas fa-pen-nib"></i>
                                    </a>

                                    <button type="button" class="btn-action delete-btn" onclick="openDeleteModal({{ $menu->id }})" title="Hapus Menu">
                                        <i class="fas fa-trash-can"></i>
                                    </button>

                                    <form id="delete-form-{{ $menu->id }}"
                                          action="/admin/menu/delete/{{ $menu->id }}"
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
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon-circle">
                                        <i class="fas fa-plate-wheat"></i>
                                    </div>
                                    <h3>Katalog Menu Kosong</h3>
                                    <p>Belum ada produk atau hidangan kuliner yang terarsip di sistem.</p>
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
            <h3>Hapus Menu?</h3>
            <p>Tindakan ini bersifat permanen. Data hidangan terpilih akan dihapus sepenuhnya dari server publikasi.</p>
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

/* SEARCH, CATEGORY FILTER & CLIENT-SIDE PAGINATION */
const searchMenu = document.getElementById('searchMenu');
const filterKategori = document.getElementById('filterKategori');
const menuRows = Array.from(document.querySelectorAll('.menu-row'));
const itemsPerPage = 7;
let currentPage = 1;

function getFilteredRows() {
    return menuRows.filter(row => {
        const keyword = searchMenu.value.toLowerCase();
        const kategori = filterKategori.value;
        const nama = row.dataset.nama;
        const category = row.dataset.kategori;

        const cocokNama = nama.includes(keyword);
        const cocokKategori = kategori === 'all' || kategori === category;

        return cocokNama && cocokKategori;
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

    menuRows.forEach(row => row.style.display = 'none');

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

searchMenu.addEventListener('keyup', () => { currentPage = 1; renderPagination(); });
filterKategori.addEventListener('change', () => { currentPage = 1; renderPagination(); });

// Initialization Run
renderPagination();
</script>

<style>
/* ==========================================================================
   ADVANCED MODERN DASHBOARD THEME (THE LUXURY MINIMALIST)
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

/* Luxury Category Dropdown Selector */
.filter-category select {
    height: 56px;
    min-width: 240px;
    padding: 0 50px 0 22px;
    border-radius: 14px;
    border: 1px solid var(--border-soft);
    background: rgba(255, 255, 255, 0.02) url("data:image/svg+xml;charset=UTF-8,%3Csvg width='20' height='20' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10L12 15L17 10' stroke='%23e2c997' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 18px center;
    background-size: 16px;
    color: var(--text-primary);
    outline: none;
    cursor: pointer;
    font-weight: 500;
    font-size: 14px;
    appearance: none;
    -webkit-appearance: none;
    transition: all var(--transition);
}

.filter-category select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(226, 201, 151, 0.08);
}

.filter-category select option {
    background: #181818;
    color: var(--text-primary);
    padding: 12px;
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

/* Visual Components (Frames) */
.menu-image-frame {
    width: 76px;
    height: 76px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.05);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

.menu-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 76px;
    height: 76px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.02);
    border: 1px dashed var(--border-soft);
    color: var(--text-dim);
    font-size: 20px;
}

/* Typography Inside Table Rows */
.menu-info-wrapper {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.menu-name {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
}

.menu-desc {
    color: var(--text-muted);
    font-size: 13px;
    line-height: 1.4;
}

.category-badge {
    padding: 6px 14px;
    border-radius: 30px;
    background: rgba(226, 201, 151, 0.06);
    border: 1px solid rgba(226, 201, 151, 0.15);
    color: var(--accent);
    font-size: 12px;
    font-weight: 600;
}

.menu-price {
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

/* Real-time Status Badging Architecture */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.status-badge.tersedia {
    background: rgba(34, 197, 94, 0.06);
    color: #4ade80;
    border: 1px solid rgba(34, 197, 94, 0.15);
}
.status-badge.tersedia .status-dot { background: #4ade80; box-shadow: 0 0 8px #4ade80; }

.status-badge.habis {
    background: rgba(239, 68, 68, 0.06);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.15);
}
.status-badge.habis .status-dot { background: #ef4444; }

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

/* ==========================================================================
   FIXED PAGINATION LAYOUT (MENYAMPING / HORIZONTAL DATAR)
   ========================================================================== */
.pagination-wrapper {
    display: flex;
    flex-direction: row; /* Mengunci arah horizontal */
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 35px;
}

#paginationNumbers {
    display: flex;
    flex-direction: row; /* Mengunci angka 1 2 dst agar berjejer ke samping */
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
    display: inline-flex; /* Diganti dari flex ke inline-flex untuk kestabilan element horizontal */
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
    .filter-category select { width: 100%; }
    .custom-table { min-width: 850px; }
}
</style>

</body>
</html>