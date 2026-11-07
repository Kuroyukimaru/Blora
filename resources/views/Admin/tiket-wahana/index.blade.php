<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kelola Tiket Wahana — Admin Panel</title>


    {{-- ==========================================================
         FONT
    =========================================================== --}}

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


    {{-- ==========================================================
         FONT AWESOME
    =========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    {{-- ==========================================================
         VITE
    =========================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>


    {{-- ==========================================================
         SIDEBAR
    =========================================================== --}}

    @include('admin.partials.sidebar')


    {{-- ==========================================================
         MAIN
    =========================================================== --}}

    <main class="admin-main">
        <button
            type="button"
            class="admin-mobile-menu-button"
            id="openAdminSidebar"
            aria-label="Buka menu navigasi"
            aria-controls="adminSidebar"
            aria-expanded="false"
            title="Buka menu"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>



        {{-- ======================================================
             HEADER
        ======================================================= --}}

        <div class="top-section">

            <div class="header-text-wrapper">

                <span class="dashboard-subtitle">
                    
                </span>

                <h1 class="dashboard-title text-gradient">
                    Kelola Tiket Wahana
                </h1>

                <p class="dashboard-desc">
                    Kelola daftar tiket wahana, harga tiket,
                    ketentuan, gambar, dan status ketersediaan wahana.
                </p>

            </div>


            {{-- ==================================================
                 ADD BUTTON
            =================================================== --}}

            <a
                href="{{ route('admin.tiket-wahana.create') }}"
                class="btn-add"
            >

                <div class="btn-add-glow"></div>

                <i class="fas fa-plus"></i>

                <span>
                    Tambah Tiket
                </span>

            </a>

        </div>


        {{-- ======================================================
             SUCCESS ALERT
        ======================================================= --}}

        @if(session('success'))

            <div class="custom-alert success glass-effect">

                <div class="alert-icon-wrapper">
                    <i class="fas fa-circle-check"></i>
                </div>

                <div class="alert-content">

                    <span class="alert-title">
                        Aksi Berhasil
                    </span>

                    <span class="alert-desc">
                        {{ session('success') }}
                    </span>

                </div>

            </div>

        @endif


        {{-- ======================================================
             ERROR ALERT
        ======================================================= --}}

        @if(session('error'))

            <div class="custom-alert error glass-effect">

                <div class="alert-icon-wrapper">
                    <i class="fas fa-circle-exclamation"></i>
                </div>

                <div class="alert-content">

                    <span class="alert-title">
                        Terjadi Kesalahan
                    </span>

                    <span class="alert-desc">
                        {{ session('error') }}
                    </span>

                </div>

            </div>

        @endif


        {{-- ======================================================
             VALIDATION ERROR
        ======================================================= --}}

        @if($errors->any())

            <div class="custom-alert error glass-effect">

                <div class="alert-icon-wrapper">
                    <i class="fas fa-circle-exclamation"></i>
                </div>

                <div class="alert-content">

                    <span class="alert-title">
                        Data Tidak Valid
                    </span>

                    <span class="alert-desc">
                        {{ $errors->first() }}
                    </span>

                </div>

            </div>

        @endif


        {{-- ======================================================
             SEARCH
        ======================================================= --}}

        <div class="table-filter-wrapper">

            <div class="search-box">

                <i class="fas fa-search search-icon"></i>

                <input
                    type="text"
                    id="searchTiket"
                    placeholder="Cari nama wahana..."
                    autocomplete="off"
                >

            </div>

            <div class="page-size-box">
                <label for="itemsPerPage">
                    Tampilkan
                </label>

                <select
                    id="itemsPerPage"
                    aria-label="Jumlah tiket per halaman"
                >
                    <option value="5">5 data</option>
                    <option value="10" selected>10 data</option>
                </select>
            </div>

        </div>


        {{-- ======================================================
             TABLE
        ======================================================= --}}

        <div class="table-box glass-effect">

            <div class="table-responsive">

                <table class="custom-table">

                    <thead>

                        <tr>

                            <th>
                                Wahana
                            </th>

                            <th>
                                Ketentuan Operasional
                            </th>

                            <th width="200">
                                Harga Tiket
                            </th>

                            <th width="160">
                                Status
                            </th>

                            <th width="140">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody id="tiketTableBody">


                        @forelse($tiketWahanas as $tiket)

                            <tr
                                class="tiket-row"
                                data-nama="{{ strtolower($tiket->nama_wahana) }}"
                            >


                                {{-- ==================================================
                                     WAHANA + GAMBAR
                                =================================================== --}}

                                <td>

                                    <div class="wahana-wrapper">


                                        <div class="wahana-image-container">

                                            @if(!empty($tiket->gambar))

                                                <img
                                                    src="{{ asset('storage/' . ltrim($tiket->gambar, '/')) }}"
                                                    alt="{{ $tiket->nama_wahana }}"
                                                    class="wahana-image"
                                                    loading="lazy"
                                                    onerror="handleImageError(this)"
                                                >

                                                <div class="image-loading">

                                                    <i class="fas fa-spinner fa-spin"></i>

                                                </div>

                                            @else

                                                <div class="image-placeholder">

                                                    

                                                </div>

                                            @endif

                                        </div>


                                        <div class="wahana-info">

                                            <div class="wahana-name">
                                                {{ $tiket->nama_wahana }}
                                            </div>

                                            <div class="wahana-id">
                                                #{{ $tiket->id_tiket_wahana }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- ==================================================
                                     KETENTUAN
                                =================================================== --}}

                                <td>

                                    <div class="ketentuan-text">

                                        @if($tiket->ketentuan)

                                            {{ \Illuminate\Support\Str::limit(
                                                $tiket->ketentuan,
                                                100
                                            ) }}

                                        @else

                                            <span class="text-empty">
                                                Tidak ada ketentuan
                                            </span>

                                        @endif

                                    </div>

                                </td>


                                {{-- ==================================================
                                     HARGA
                                =================================================== --}}

                                <td>

                                    <span class="harga-badge">

                                        <span class="currency-prefix">
                                            Rp
                                        </span>

                                        {{ number_format(
                                            (int) $tiket->harga,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </span>

                                </td>


                                {{-- ==================================================
                                     STATUS
                                =================================================== --}}

                                <td>

                                    @if($tiket->status === 'Tersedia')

                                        <span class="status-badge available">

                                            <span class="status-dot"></span>

                                            Tersedia

                                        </span>

                                    @else

                                        <span class="status-badge unavailable">

                                            <span class="status-dot"></span>

                                            Tidak Tersedia

                                        </span>

                                    @endif

                                </td>


                                {{-- ==================================================
                                     ACTION
                                =================================================== --}}

                                <td>

                                    <div class="action-group">


                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route(
                                                'admin.tiket-wahana.edit',
                                                $tiket->id_tiket_wahana
                                            ) }}"
                                            class="btn-action edit-btn"
                                            title="Edit Tiket"
                                        >

                                            <i class="fas fa-pen-nib"></i>

                                        </a>


                                        {{-- DELETE --}}

                                        <button
                                            type="button"
                                            class="btn-action delete-btn"
                                            onclick="openDeleteModal({{ $tiket->id_tiket_wahana }})"
                                            title="Hapus Tiket"
                                        >

                                            <i class="fas fa-trash-can"></i>

                                        </button>


                                        {{-- DELETE FORM --}}

                                        <form
                                            id="delete-form-{{ $tiket->id_tiket_wahana }}"
                                            action="{{ route(
                                                'admin.tiket-wahana.destroy',
                                                $tiket->id_tiket_wahana
                                            ) }}"
                                            method="POST"
                                            class="delete-form"
                                        >

                                            @csrf

                                            @method('DELETE')

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty


                            {{-- ==================================================
                                 EMPTY DATA
                            =================================================== --}}

                            <tr id="emptyDataRow">

                                <td colspan="5">

                                    <div class="empty-state">

                                        <div class="empty-icon-circle">

                                            <i class="fas fa-ticket-alt"></i>

                                        </div>

                                        <h3>
                                            Katalog Tiket Kosong
                                        </h3>

                                        <p>
                                            Belum ada tiket wahana
                                            yang terdaftar di sistem.
                                        </p>

                                        <a
                                            href="{{ route('admin.tiket-wahana.create') }}"
                                            class="empty-add-btn"
                                        >

                                            <i class="fas fa-plus"></i>

                                            Tambah Tiket

                                        </a>

                                    </div>

                                </td>

                            </tr>


                        @endforelse


                        {{-- ==================================================
                             SEARCH EMPTY
                        =================================================== --}}

                        <tr
                            id="searchEmptyRow"
                            style="display:none;"
                        >

                            <td colspan="5">

                                <div class="empty-state search-empty">

                                    <div class="empty-icon-circle">

                                        <i class="fas fa-search"></i>

                                    </div>

                                    <h3>
                                        Tiket Tidak Ditemukan
                                    </h3>

                                    <p>
                                        Tidak ada wahana yang
                                        sesuai dengan pencarian.
                                    </p>

                                </div>

                            </td>

                        </tr>


                    </tbody>

                </table>

            </div>

        </div>


        {{-- ======================================================
             PAGINATION CLIENT SIDE
        ======================================================= --}}

        @if($tiketWahanas->count() > 0)

            <div
                class="pagination-wrapper"
                id="paginationWrapper"
            >

                <div
                    class="pagination-info"
                    id="paginationInfo"
                ></div>

                <div class="pagination-controls">

                    <button
                        id="prevPage"
                        class="pagination-btn"
                        type="button"
                        title="Halaman Sebelumnya"
                        aria-label="Halaman sebelumnya"
                    >
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div id="paginationNumbers"></div>

                    <button
                        id="nextPage"
                        class="pagination-btn"
                        type="button"
                        title="Halaman Selanjutnya"
                        aria-label="Halaman selanjutnya"
                    >
                        <i class="fas fa-chevron-right"></i>
                    </button>

                </div>

            </div>

        @endif


    </main>


    {{-- ==========================================================
         DELETE MODAL
    =========================================================== --}}

    <div
        class="modal-overlay"
        id="deleteModal"
        aria-hidden="true"
    >

        <div
            class="delete-modal glass-effect"
            role="dialog"
            aria-modal="true"
            aria-labelledby="deleteModalTitle"
        >

            <div class="modal-icon">

                <i class="fas fa-triangle-exclamation"></i>

            </div>


            <h3 id="deleteModalTitle">
                Hapus Tiket?
            </h3>


            <p>
                Tindakan ini bersifat permanen.
                Data tiket wahana yang dipilih akan
                dihapus beserta yang sudah masuk di  bundling.
            </p>


            <div class="modal-buttons">

                <button
                    type="button"
                    class="btn-cancel"
                    onclick="closeDeleteModal()"
                >
                    Batal
                </button>


                <button
                    type="button"
                    class="btn-delete-confirm"
                    id="confirmDeleteBtn"
                >

                    <i class="fas fa-trash-can"></i>

                    <span>
                        Ya, Hapus
                    </span>

                </button>

            </div>

        </div>

    </div>


    {{-- ==========================================================
         JAVASCRIPT
    =========================================================== --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | IMAGE ERROR HANDLER
        |--------------------------------------------------------------------------
        */

        function handleImageError(image)
        {
            if (!image) {
                return;
            }

            const container =
                image.closest('.wahana-image-container');

            if (!container) {
                return;
            }

            image.remove();

            const loading =
                container.querySelector('.image-loading');

            if (loading) {
                loading.remove();
            }

            const placeholder =
                document.createElement('div');

            placeholder.className =
                'image-placeholder';

            placeholder.innerHTML =
                '<i class="fas fa-image"></i>';

            container.appendChild(
                placeholder
            );
        }


        /*
        |--------------------------------------------------------------------------
        | INITIALIZATION
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'DOMContentLoaded',
            function () {


                /*
                |--------------------------------------------------------------------------
                | IMAGE LOADING
                |--------------------------------------------------------------------------
                */

                const images =
                    document.querySelectorAll(
                        '.wahana-image'
                    );


                images.forEach(
                    function (image) {

                        image.addEventListener(
                            'load',
                            function () {

                                const container =
                                    this.closest(
                                        '.wahana-image-container'
                                    );

                                if (!container) {
                                    return;
                                }

                                const loading =
                                    container.querySelector(
                                        '.image-loading'
                                    );

                                if (loading) {
                                    loading.remove();
                                }

                            }
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | DELETE MODAL
                |--------------------------------------------------------------------------
                */

                let selectedDeleteId = null;


                const deleteModal =
                    document.getElementById(
                        'deleteModal'
                    );


                const confirmDeleteBtn =
                    document.getElementById(
                        'confirmDeleteBtn'
                    );


                window.openDeleteModal =
                    function (id) {

                        selectedDeleteId = id;

                        if (!deleteModal) {
                            return;
                        }

                        deleteModal.style.display =
                            'flex';

                        deleteModal.setAttribute(
                            'aria-hidden',
                            'false'
                        );

                        document.body.classList.add(
                            'modal-open'
                        );

                        requestAnimationFrame(
                            function () {

                                deleteModal.classList.add(
                                    'active'
                                );

                            }
                        );

                    };


                window.closeDeleteModal =
                    function () {

                        if (!deleteModal) {
                            return;
                        }

                        deleteModal.classList.remove(
                            'active'
                        );

                        deleteModal.setAttribute(
                            'aria-hidden',
                            'true'
                        );

                        setTimeout(
                            function () {

                                deleteModal.style.display =
                                    'none';

                            },
                            300
                        );

                        document.body.classList.remove(
                            'modal-open'
                        );

                        selectedDeleteId =
                            null;

                    };


                /*
                |--------------------------------------------------------------------------
                | CONFIRM DELETE
                |--------------------------------------------------------------------------
                */

                if (confirmDeleteBtn) {

                    confirmDeleteBtn.addEventListener(
                        'click',
                        function () {

                            if (!selectedDeleteId) {
                                return;
                            }

                            const form =
                                document.getElementById(
                                    'delete-form-' +
                                    selectedDeleteId
                                );

                            if (!form) {
                                return;
                            }

                            confirmDeleteBtn.disabled =
                                true;

                            confirmDeleteBtn.innerHTML =
                                '<i class="fas fa-spinner fa-spin"></i>' +
                                '<span>Menghapus...</span>';


                            form.submit();

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | CLICK OUTSIDE MODAL
                |--------------------------------------------------------------------------
                */

                if (deleteModal) {

                    deleteModal.addEventListener(
                        'click',
                        function (event) {

                            if (
                                event.target ===
                                deleteModal
                            ) {

                                window.closeDeleteModal();

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | ESCAPE
                |--------------------------------------------------------------------------
                */

                document.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Escape' &&
                            deleteModal &&
                            deleteModal.classList.contains(
                                'active'
                            )
                        ) {

                            window.closeDeleteModal();

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | SEARCH
                |--------------------------------------------------------------------------
                */

                const searchTiket =
                    document.getElementById(
                        'searchTiket'
                    );


                const tiketRows =
                    Array.from(
                        document.querySelectorAll(
                            '.tiket-row'
                        )
                    );


                const prevPage =
                    document.getElementById(
                        'prevPage'
                    );


                const nextPage =
                    document.getElementById(
                        'nextPage'
                    );


                const paginationNumbers =
                    document.getElementById(
                        'paginationNumbers'
                    );


                const paginationWrapper =
                    document.getElementById(
                        'paginationWrapper'
                    );


                const searchEmptyRow =
                    document.getElementById(
                        'searchEmptyRow'
                    );


                const itemsPerPageSelect =
                    document.getElementById('itemsPerPage');

                const paginationInfo =
                    document.getElementById('paginationInfo');

                let itemsPerPage =
                    itemsPerPageSelect
                        ? parseInt(itemsPerPageSelect.value, 10)
                        : 10;

                let currentPage =
                    1;


                function getFilteredRows()
                {
                    if (!searchTiket) {
                        return tiketRows;
                    }

                    const keyword =
                        searchTiket.value
                            .toLowerCase()
                            .trim();

                    if (!keyword) {
                        return tiketRows;
                    }

                    return tiketRows.filter(
                        function (row) {

                            const nama =
                                (
                                    row.dataset.nama ||
                                    ''
                                ).toLowerCase();

                            return nama.includes(keyword);

                        }
                    );
                }


                function renderButtons(totalPages)
                {
                    if (
                        !paginationNumbers ||
                        !prevPage ||
                        !nextPage
                    ) {
                        return;
                    }

                    paginationNumbers.innerHTML = '';

                    if (totalPages <= 1) {
                        prevPage.style.display = 'none';
                        nextPage.style.display = 'none';
                        return;
                    }

                    prevPage.style.display = 'inline-flex';
                    nextPage.style.display = 'inline-flex';

                    prevPage.disabled =
                        currentPage === 1;

                    nextPage.disabled =
                        currentPage === totalPages;

                    /*
                     * Untuk jumlah halaman yang sedikit,
                     * tampilkan seluruh nomor halaman.
                     * Jika halaman banyak, tampilkan nomor yang
                     * relevan di sekitar halaman aktif.
                     */
                    let pages = [];

                    if (totalPages <= 7) {
                        for (let i = 1; i <= totalPages; i++) {
                            pages.push(i);
                        }
                    } else {
                        pages = [
                            1,
                            currentPage - 1,
                            currentPage,
                            currentPage + 1,
                            totalPages
                        ];

                        pages = [
                            ...new Set(
                                pages.filter(
                                    function (page) {
                                        return page >= 1 &&
                                            page <= totalPages;
                                    }
                                )
                            )
                        ];
                    }

                    pages.forEach(
                        function (page, index) {

                            if (
                                index > 0 &&
                                page - pages[index - 1] > 1
                            ) {
                                const dots =
                                    document.createElement('span');

                                dots.className =
                                    'pagination-dots';

                                dots.textContent =
                                    '...';

                                paginationNumbers.appendChild(dots);
                            }

                            const button =
                                document.createElement('button');

                            button.type = 'button';
                            button.className = 'number-btn';
                            button.innerText = page;
                            button.setAttribute(
                                'aria-label',
                                'Halaman ' + page
                            );

                            if (page === currentPage) {
                                button.classList.add('active');
                                button.setAttribute(
                                    'aria-current',
                                    'page'
                                );
                            }

                            button.addEventListener(
                                'click',
                                function () {

                                    currentPage = page;

                                    renderPagination();

                                    const tableBox =
                                        document.querySelector(
                                            '.table-box'
                                        );

                                    if (tableBox) {
                                        tableBox.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'start'
                                        });
                                    }

                                }
                            );

                            paginationNumbers.appendChild(button);

                        }
                    );
                }


                function renderPagination()
                {
                    const filteredRows =
                        getFilteredRows();

                    const totalItems =
                        filteredRows.length;

                    const totalPages =
                        Math.ceil(
                            totalItems /
                            itemsPerPage
                        );

                    if (
                        totalPages > 0 &&
                        currentPage > totalPages
                    ) {
                        currentPage =
                            totalPages;
                    }

                    if (totalPages === 0) {
                        currentPage = 1;
                    }

                    tiketRows.forEach(
                        function (row) {
                            row.style.display = 'none';
                        }
                    );

                    const start =
                        (currentPage - 1) *
                        itemsPerPage;

                    const end =
                        start +
                        itemsPerPage;

                    const visibleRows =
                        filteredRows.slice(
                            start,
                            end
                        );

                    visibleRows.forEach(
                        function (row) {
                            row.style.display = '';
                        }
                    );

                    if (searchEmptyRow) {
                        if (
                            searchTiket &&
                            searchTiket.value.trim() !== '' &&
                            totalItems === 0
                        ) {
                            searchEmptyRow.style.display = '';
                        } else {
                            searchEmptyRow.style.display = 'none';
                        }
                    }

                    renderButtons(totalPages);

                    if (paginationInfo) {
                        if (totalItems === 0) {
                            paginationInfo.innerHTML =
                                'Tidak ada data yang ditampilkan';
                        } else {
                            const firstItem =
                                start + 1;

                            const lastItem =
                                Math.min(
                                    end,
                                    totalItems
                                );

                            paginationInfo.innerHTML =
                                '<strong>' +
                                firstItem +
                                '–' +
                                lastItem +
                                '</strong>' +
                                ' dari ' +
                                totalItems +
                                ' tiket';
                        }
                    }

                    if (paginationWrapper) {
                        paginationWrapper.style.display =
                            totalPages > 1
                                ? 'flex'
                                : 'none';
                    }
                }


                if (prevPage) {
                    prevPage.addEventListener(
                        'click',
                        function () {

                            if (currentPage > 1) {
                                currentPage--;
                                renderPagination();
                            }

                        }
                    );
                }


                if (nextPage) {
                    nextPage.addEventListener(
                        'click',
                        function () {

                            const totalPages =
                                Math.ceil(
                                    getFilteredRows().length /
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
                }


                if (searchTiket) {
                    searchTiket.addEventListener(
                        'input',
                        function () {

                            currentPage = 1;

                            renderPagination();

                        }
                    );
                }


                if (itemsPerPageSelect) {
                    itemsPerPageSelect.addEventListener(
                        'change',
                        function () {

                            const selectedValue =
                                parseInt(
                                    this.value,
                                    10
                                );

                            itemsPerPage =
                                selectedValue === 5
                                    ? 5
                                    : 10;

                            currentPage = 1;

                            renderPagination();

                        }
                    );
                }


                renderPagination();

            }
        );

    </script>


    {{-- ==========================================================
         STYLE
    =========================================================== --}}

    <style>
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

            --white:#ffffff;
            --black:#000000;

            --shadow-soft:0 20px 60px rgba(0,0,0,.4);
            --shadow-hover:0 25px 70px rgba(0,0,0,.5);

            --radius-lg:28px;
            --radius-md:16px;
            --radius-full:999px;

            --transition:.25s cubic-bezier(.4,0,.2,1);
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
                radial-gradient(circle at 82% 4%,rgba(226,201,151,.055),transparent 32%),
                radial-gradient(circle at 12% 90%,rgba(226,201,151,.025),transparent 30%),
                var(--bg-primary);
            color:var(--text-primary);
            font-family:'Inter',sans-serif;
            line-height:1.65;
            overflow-x:hidden;
            -webkit-font-smoothing:antialiased;
            text-rendering:optimizeLegibility;
        }

        body.modal-open{
            overflow:hidden;
        }

        button,
        input,
        a{
            font:inherit;
        }

        button,
        a{
            -webkit-tap-highlight-color:transparent;
        }

        .admin-main{
            min-height:100vh;
            margin-left:290px;
            padding:56px clamp(28px,4vw,64px) 70px;
            position:relative;
            isolation:isolate;
        }

        .admin-main::before{
            content:"";
            position:fixed;
            inset:0;
            pointer-events:none;
            z-index:-1;
            background:
                linear-gradient(90deg,rgba(255,255,255,.012) 1px,transparent 1px),
                linear-gradient(rgba(255,255,255,.012) 1px,transparent 1px);
            background-size:56px 56px;
            mask-image:linear-gradient(to bottom,rgba(0,0,0,.35),transparent 75%);
        }

        .admin-mobile-menu-button{
            display:none;
            position:fixed;
            top:18px;
            left:18px;
            width:48px;
            height:48px;
            z-index:10001;
            border:1px solid var(--border-gold);
            border-radius:14px;
            background:rgba(18,18,18,.92);
            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);
            box-shadow:0 12px 35px rgba(0,0,0,.35);
            cursor:pointer;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            gap:5px;
            transition:all var(--transition);
        }

        .admin-mobile-menu-button span{
            width:19px;
            height:2px;
            border-radius:99px;
            background:var(--accent);
            transition:all var(--transition);
        }

        .admin-mobile-menu-button:hover{
            border-color:var(--accent);
            transform:translateY(-1px);
        }

        .top-section{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:32px;
            margin-bottom:38px;
        }

        .header-text-wrapper{
            min-width:0;
        }

        .dashboard-subtitle{
            display:flex;
            align-items:center;
            gap:9px;
            width:max-content;
            margin-bottom:10px;
            color:var(--accent-dark);
            font-size:12px;
            font-weight:800;
            letter-spacing:2.4px;
            line-height:1.4;
        }

        .dashboard-subtitle i{
            font-size:11px;
            color:var(--accent);
        }

        .dashboard-title{
            margin:0 0 12px;
            font-family:'Playfair Display',serif;
            font-size:clamp(36px,4vw,56px);
            font-weight:700;
            line-height:1.08;
            letter-spacing:-.7px;
            background:linear-gradient(135deg,var(--accent) 0%,#f8f4ed 50%,var(--accent-dark) 100%);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            background-clip:text;
        }

        .dashboard-desc{
            max-width:720px;
            margin:0;
            color:var(--text-muted);
            font-size:16px;
            line-height:1.75;
        }

        .btn-add{
            position:relative;
            flex:0 0 auto;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            min-height:52px;
            padding:0 22px;
            border:1px solid rgba(255,255,255,.08);
            border-radius:var(--radius-full);
            overflow:hidden;
            background:linear-gradient(135deg,var(--accent),var(--accent-hover));
            color:var(--bg-primary);
            text-decoration:none;
            font-size:15px;
            font-weight:800;
            letter-spacing:.1px;
            box-shadow:0 12px 35px rgba(226,201,151,.12);
            transition:all var(--transition);
        }

        .btn-add::after{
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(110deg,transparent 25%,rgba(255,255,255,.25),transparent 70%);
            transform:translateX(-120%);
            transition:transform .55s ease;
        }

        .btn-add:hover{
            transform:translateY(-3px);
            box-shadow:0 18px 42px rgba(226,201,151,.18);
            background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark));
        }

        .btn-add:hover::after{
            transform:translateX(120%);
        }

        .btn-add-glow{
            position:absolute;
            width:90px;
            height:90px;
            right:-30px;
            top:-55px;
            border-radius:50%;
            background:rgba(255,255,255,.16);
            filter:blur(16px);
            pointer-events:none;
        }

        .glass-effect{
            background:linear-gradient(145deg,rgba(255,255,255,.045),rgba(255,255,255,.018));
            border:1px solid var(--border-gold);
            box-shadow:var(--shadow-soft);
            backdrop-filter:blur(24px);
            -webkit-backdrop-filter:blur(24px);
        }

        .custom-alert{
            display:flex;
            align-items:center;
            gap:16px;
            margin:0 0 24px;
            padding:16px 19px;
            border-radius:var(--radius-md);
        }

        .custom-alert.success{
            border-left:3px solid var(--accent);
            background:linear-gradient(90deg,rgba(226,201,151,.055),rgba(18,18,18,.35));
        }

        .custom-alert.error{
            border-left:3px solid #e87979;
            background:linear-gradient(90deg,rgba(232,121,121,.055),rgba(18,18,18,.35));
        }

        .alert-icon-wrapper{
            display:flex;
            align-items:center;
            justify-content:center;
            flex:0 0 38px;
            width:38px;
            height:38px;
            border-radius:12px;
            background:rgba(226,201,151,.07);
            font-size:17px;
        }

        .custom-alert.success .alert-icon-wrapper{
            color:var(--accent);
        }

        .custom-alert.error .alert-icon-wrapper{
            color:#ff9696;
            background:rgba(232,121,121,.07);
        }

        .alert-content{
            display:flex;
            flex-direction:column;
            min-width:0;
            gap:1px;
        }

        .alert-title{
            color:var(--text-primary);
            font-size:13px;
            font-weight:800;
        }

        .custom-alert.success .alert-title{
            color:var(--accent);
        }

        .custom-alert.error .alert-title{
            color:#ff9696;
        }

        .alert-desc{
            color:var(--text-secondary);
            font-size:14px;
            line-height:1.55;
        }

        .table-filter-wrapper{
            display:grid;
            grid-template-columns:minmax(0,1fr) auto;
            align-items:center;
            gap:14px;
            margin-bottom:22px;
        }

        .page-size-box{
            display:flex;
            align-items:center;
            gap:10px;
            min-height:58px;
            padding:0 12px 0 16px;
            border:1px solid var(--border-soft);
            border-radius:17px;
            background:rgba(18,18,18,.72);
            box-shadow:0 12px 40px rgba(0,0,0,.18);
        }

        .page-size-box label{
            color:var(--text-muted);
            font-size:14px;
            font-weight:700;
            white-space:nowrap;
        }

        .page-size-box select{
            min-height:40px;
            padding:0 34px 0 12px;
            border:1px solid rgba(226,201,151,.14);
            border-radius:11px;
            outline:none;
            background:#151515;
            color:var(--text-primary);
            font-size:14px;
            font-weight:750;
            cursor:pointer;
            transition:all var(--transition);
        }

        .page-size-box select:hover,
        .page-size-box select:focus{
            border-color:rgba(226,201,151,.42);
            box-shadow:0 0 0 3px rgba(226,201,151,.06);
        }

        .page-size-box select option{
            background:#151515;
            color:var(--text-primary);
        }

        .search-box{
            position:relative;
            width:100%;
        }

        .search-icon{
            position:absolute;
            left:19px;
            top:50%;
            z-index:2;
            transform:translateY(-50%);
            color:var(--accent-dark);
            font-size:16px;
            pointer-events:none;
        }

        .search-box input{
            width:100%;
            height:58px;
            padding:0 20px 0 52px;
            border:1px solid var(--border-soft);
            border-radius:17px;
            outline:none;
            background:rgba(18,18,18,.72);
            color:var(--text-primary);
            font-size:15px;
            box-shadow:0 12px 40px rgba(0,0,0,.18);
            transition:all var(--transition);
        }

        .search-box input:focus{
            border-color:rgba(226,201,151,.45);
            background:rgba(226,201,151,.035);
            box-shadow:0 0 0 4px rgba(226,201,151,.07),0 15px 45px rgba(0,0,0,.22);
        }

        .search-box input::placeholder{
            color:var(--text-dim);
        }

        .table-box{
            border-radius:22px;
            overflow:hidden;
        }

        .table-responsive{
            width:100%;
            overflow-x:auto;
            overflow-y:hidden;
            scrollbar-width:thin;
            scrollbar-color:var(--accent-dark) transparent;
        }

        .table-responsive::-webkit-scrollbar{
            height:7px;
        }

        .table-responsive::-webkit-scrollbar-track{
            background:rgba(255,255,255,.025);
        }

        .table-responsive::-webkit-scrollbar-thumb{
            border-radius:99px;
            background:rgba(226,201,151,.35);
        }

        .custom-table{
            width:100%;
            min-width:980px;
            border-collapse:separate;
            border-spacing:0;
            text-align:left;
        }

        .custom-table th{
            padding:19px 22px;
            border-bottom:1px solid var(--border-soft);
            background:rgba(255,255,255,.025);
            color:var(--accent);
            font-size:12px;
            font-weight:800;
            letter-spacing:1.25px;
            text-transform:uppercase;
            white-space:nowrap;
        }

        .custom-table td{
            padding:19px 22px;
            border-bottom:1px solid rgba(255,255,255,.045);
            color:var(--text-secondary);
            font-size:14px;
            vertical-align:middle;
        }

        .custom-table tbody tr:last-child td{
            border-bottom:none;
        }

        .custom-table tbody tr.tiket-row{
            transition:background var(--transition),transform var(--transition);
        }

        .custom-table tbody tr.tiket-row:hover{
            background:rgba(226,201,151,.035);
        }

        .wahana-wrapper{
            display:flex;
            align-items:center;
            gap:14px;
            min-width:240px;
        }

        .wahana-image-container{
            position:relative;
            display:flex;
            align-items:center;
            justify-content:center;
            flex:0 0 62px;
            width:62px;
            height:62px;
            overflow:hidden;
            border:1px solid rgba(226,201,151,.18);
            border-radius:16px;
            background:rgba(226,201,151,.055);
            color:var(--accent);
            box-shadow:0 8px 24px rgba(0,0,0,.18);
        }

        .wahana-image{
            position:relative;
            z-index:2;
            display:block;
            width:100%;
            height:100%;
            object-fit:cover;
            object-position:center;
            transition:transform .35s ease;
        }

        .tiket-row:hover .wahana-image{
            transform:scale(1.07);
        }

        .image-loading{
            position:absolute;
            inset:0;
            z-index:1;
            display:flex;
            align-items:center;
            justify-content:center;
            background:rgba(18,18,18,.9);
            color:var(--accent);
            font-size:14px;
        }

        .image-placeholder{
            display:flex;
            align-items:center;
            justify-content:center;
            width:100%;
            height:100%;
            background:rgba(226,201,151,.055);
            color:var(--accent);
            font-size:20px;
        }

        .wahana-info{
            min-width:0;
        }

        .wahana-name{
            color:var(--text-primary);
            font-size:15px;
            font-weight:750;
            line-height:1.4;
            overflow-wrap:anywhere;
        }

        .wahana-id{
            margin-top:4px;
            color:var(--text-dim);
            font-size:12px;
        }

        .ketentuan-text{
            max-width:390px;
            color:var(--text-muted);
            font-size:14px;
            line-height:1.65;
        }

        .text-empty{
            color:var(--text-dim);
            font-style:italic;
        }

        .harga-badge{
            display:inline-flex;
            align-items:baseline;
            gap:3px;
            color:var(--text-primary);
            font-size:16px;
            font-weight:800;
            white-space:nowrap;
        }

        .currency-prefix{
            color:var(--accent-dark);
            font-size:12px;
            font-weight:700;
        }

        .status-badge{
            display:inline-flex;
            align-items:center;
            gap:8px;
            min-height:34px;
            padding:7px 12px;
            border-radius:var(--radius-full);
            font-size:13px;
            font-weight:700;
            white-space:nowrap;
        }

        .status-dot{
            width:8px;
            height:8px;
            border-radius:50%;
            flex:0 0 8px;
        }

        .status-badge.available{
            border:1px solid rgba(126,220,153,.16);
            background:rgba(126,220,153,.065);
            color:#a6e6b7;
        }

        .status-badge.available .status-dot{
            background:#72db8f;
            box-shadow:0 0 10px rgba(114,219,143,.6);
        }

        .status-badge.unavailable{
            border:1px solid rgba(239,133,133,.16);
            background:rgba(239,133,133,.065);
            color:#f1aaaa;
        }

        .status-badge.unavailable .status-dot{
            background:#ef8585;
            box-shadow:0 0 8px rgba(239,133,133,.45);
        }

        .action-group{
            display:flex;
            align-items:center;
            gap:8px;
        }

        .btn-action{
            display:flex;
            align-items:center;
            justify-content:center;
            width:42px;
            height:42px;
            border:1px solid transparent;
            border-radius:13px;
            cursor:pointer;
            text-decoration:none;
            font-size:14px;
            transition:all var(--transition);
        }

        .delete-form{
            display:none;
        }

        .edit-btn{
            border-color:rgba(226,201,151,.13);
            background:rgba(226,201,151,.055);
            color:var(--accent);
        }

        .edit-btn:hover{
            border-color:rgba(226,201,151,.35);
            background:var(--accent);
            color:var(--bg-primary);
            transform:translateY(-2px);
            box-shadow:0 10px 25px rgba(226,201,151,.12);
        }

        .delete-btn{
            border-color:rgba(239,133,133,.13);
            background:rgba(239,133,133,.055);
            color:#ef9999;
        }

        .delete-btn:hover{
            border-color:#d66e6e;
            background:#a94e4e;
            color:#fff;
            transform:translateY(-2px);
            box-shadow:0 10px 25px rgba(169,78,78,.18);
        }

        .empty-state{
            padding:86px 24px;
            text-align:center;
        }

        .empty-icon-circle{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:72px;
            height:72px;
            margin-bottom:20px;
            border:1px solid var(--border-gold);
            border-radius:50%;
            background:rgba(226,201,151,.045);
            color:var(--accent);
            font-size:25px;
            box-shadow:0 12px 35px rgba(0,0,0,.2);
        }

        .empty-state h3{
            margin:0 0 7px;
            color:var(--text-primary);
            font-size:20px;
            font-weight:750;
        }

        .empty-state p{
            max-width:470px;
            margin:0 auto 22px;
            color:var(--text-muted);
            font-size:15px;
            line-height:1.7;
        }

        .empty-add-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:9px;
            min-height:46px;
            padding:0 18px;
            border-radius:var(--radius-full);
            background:linear-gradient(135deg,var(--accent),var(--accent-hover));
            color:var(--bg-primary);
            text-decoration:none;
            font-size:14px;
            font-weight:800;
            transition:all var(--transition);
        }

        .empty-add-btn:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 28px rgba(226,201,151,.18);
        }

        .pagination-wrapper{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            margin-top:28px;
            padding:0 4px;
        }

        .pagination-info{
            color:var(--text-muted);
            font-size:14px;
            line-height:1.5;
        }

        .pagination-info strong{
            color:var(--accent);
            font-weight:800;
        }

        .pagination-controls{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:9px;
        }

        #paginationNumbers{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:7px;
            flex-wrap:wrap;
        }

        .pagination-dots{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:30px;
            height:42px;
            color:var(--text-dim);
            font-size:13px;
            font-weight:800;
        }

        .pagination-btn,
        .number-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:42px;
            height:42px;
            padding:0 12px;
            border:1px solid var(--border-soft);
            border-radius:12px;
            background:rgba(255,255,255,.02);
            color:var(--text-secondary);
            font-size:13px;
            font-weight:750;
            cursor:pointer;
            transition:all var(--transition);
        }

        .pagination-btn:hover:not(:disabled),
        .number-btn:hover{
            border-color:rgba(226,201,151,.35);
            background:rgba(226,201,151,.055);
            color:var(--accent);
        }

        .pagination-btn:disabled{
            opacity:.3;
            cursor:not-allowed;
        }

        .number-btn.active{
            border-color:var(--accent);
            background:var(--accent);
            color:var(--bg-primary);
            box-shadow:0 7px 20px rgba(226,201,151,.14);
        }

        .modal-overlay{
            position:fixed;
            inset:0;
            z-index:9999;
            display:none;
            align-items:center;
            justify-content:center;
            padding:20px;
            background:rgba(0,0,0,.72);
            backdrop-filter:blur(14px);
            -webkit-backdrop-filter:blur(14px);
            opacity:0;
            transition:opacity .28s ease;
        }

        .modal-overlay.active{
            opacity:1;
        }

        .delete-modal{
            position:relative;
            width:min(100%,440px);
            padding:36px;
            border-radius:26px;
            text-align:center;
            transform:translateY(18px) scale(.97);
            transition:transform .3s cubic-bezier(.2,.8,.2,1);
        }

        .modal-overlay.active .delete-modal{
            transform:translateY(0) scale(1);
        }

        .modal-icon{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:64px;
            height:64px;
            margin-bottom:19px;
            border:1px solid rgba(226,201,151,.18);
            border-radius:20px;
            background:linear-gradient(145deg,rgba(226,201,151,.1),rgba(226,201,151,.035));
            color:var(--accent);
            font-size:22px;
            box-shadow:0 12px 32px rgba(0,0,0,.22);
        }

        .delete-modal h3{
            margin:0 0 9px;
            color:var(--text-primary);
            font-family:'Playfair Display',serif;
            font-size:26px;
            font-weight:700;
            line-height:1.25;
        }

        .delete-modal p{
            margin:0 auto 25px;
            max-width:350px;
            color:var(--text-muted);
            font-size:14px;
            line-height:1.7;
        }

        .modal-buttons{
            display:flex;
            gap:10px;
        }

        .btn-cancel,
        .btn-delete-confirm{
            flex:1;
            min-height:50px;
            border-radius:14px;
            font-size:14px;
            font-weight:800;
            cursor:pointer;
            transition:all var(--transition);
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
        }

        .btn-cancel{
            border:1px solid var(--border-soft);
            background:rgba(255,255,255,.035);
            color:var(--text-secondary);
        }

        .btn-cancel:hover{
            border-color:var(--border-gold);
            background:rgba(226,201,151,.055);
            color:var(--text-primary);
        }

        .btn-delete-confirm{
            border:1px solid rgba(218,112,112,.3);
            background:linear-gradient(135deg,#8e4141,#6f3030);
            color:#fff7f7;
        }

        .btn-delete-confirm:hover{
            background:linear-gradient(135deg,#a74d4d,#803737);
            box-shadow:0 10px 28px rgba(128,55,55,.22);
            transform:translateY(-2px);
        }

        .btn-delete-confirm:disabled{
            opacity:.65;
            cursor:wait;
            transform:none;
        }

        .admin-mobile-menu-button:focus-visible,
        .btn-add:focus-visible,
        .btn-action:focus-visible,
        .pagination-btn:focus-visible,
        .number-btn:focus-visible,
        .btn-cancel:focus-visible,
        .btn-delete-confirm:focus-visible,
        .search-box input:focus-visible{
            outline:2px solid var(--accent);
            outline-offset:3px;
        }

        @media (max-width:1280px){
            .admin-main{
                margin-left:270px;
                padding:48px 38px 60px;
            }

            .top-section{
                gap:24px;
            }

            .dashboard-title{
                font-size:48px;
            }

            .custom-table th,
            .custom-table td{
                padding-left:18px;
                padding-right:18px;
            }
        }

        @media (max-width:1024px){
            .admin-main{
                margin-left:0;
                padding:108px 30px 52px;
            }

            .admin-mobile-menu-button{
                display:flex;
            }

            .top-section{
                align-items:flex-start;
            }

            .dashboard-title{
                font-size:44px;
            }

            .dashboard-desc{
                font-size:15px;
            }

            .btn-add{
                min-height:50px;
                padding:0 20px;
            }

            .custom-table{
                min-width:900px;
            }
        }

        @media (max-width:768px){

            .table-filter-wrapper{
                grid-template-columns:1fr;
                gap:10px;
            }

            .page-size-box{
                width:100%;
                justify-content:space-between;
            }

            .page-size-box select{
                min-width:110px;
            }

            .pagination-wrapper{
                flex-direction:column;
                align-items:stretch;
                gap:14px;
            }

            .pagination-info{
                text-align:center;
            }

            .pagination-controls{
                width:100%;
            }

            .admin-main{
                padding:94px 22px 42px;
            }

            .top-section{
                flex-direction:column;
                align-items:stretch;
                gap:20px;
                margin-bottom:28px;
            }

            .dashboard-subtitle{
                font-size:11px;
                letter-spacing:2px;
            }

            .dashboard-title{
                font-size:38px;
            }

            .dashboard-desc{
                font-size:15px;
                line-height:1.7;
            }

            .btn-add{
                width:100%;
                min-height:54px;
                font-size:15px;
            }

            .custom-alert{
                align-items:flex-start;
                padding:15px;
            }

            .table-filter-wrapper{
                margin-bottom:17px;
            }

            .search-box input{
                height:56px;
                font-size:15px;
            }

            .table-box{
                border-radius:19px;
            }

            .custom-table{
                min-width:860px;
            }

            .custom-table th{
                padding:17px 16px;
                font-size:11px;
            }

            .custom-table td{
                padding:17px 16px;
                font-size:14px;
            }

            .wahana-image-container{
                flex-basis:58px;
                width:58px;
                height:58px;
            }

            .delete-modal{
                padding:30px 23px;
            }
        }

        @media (max-width:576px){

            .page-size-box{
                min-height:54px;
                border-radius:15px;
                padding-left:14px;
            }

            .page-size-box label,
            .page-size-box select{
                font-size:13px;
            }

            .pagination-controls{
                gap:6px;
            }

            .pagination-btn,
            .number-btn{
                min-width:40px;
                height:40px;
            }

            .pagination-dots{
                height:40px;
                min-width:22px;
            }

            .admin-mobile-menu-button{
                top:14px;
                left:14px;
                width:46px;
                height:46px;
                border-radius:13px;
            }

            .admin-main{
                padding:82px 15px 32px;
            }

            .dashboard-subtitle{
                font-size:10px;
                letter-spacing:1.7px;
            }

            .dashboard-title{
                font-size:33px;
                letter-spacing:-.4px;
            }

            .dashboard-desc{
                font-size:14px;
            }

            .btn-add{
                min-height:52px;
                border-radius:15px;
            }

            .custom-alert{
                gap:12px;
                margin-bottom:18px;
            }

            .alert-icon-wrapper{
                flex-basis:34px;
                width:34px;
                height:34px;
                border-radius:10px;
                font-size:15px;
            }

            .alert-title{
                font-size:12px;
            }

            .alert-desc{
                font-size:13px;
            }

            .search-box input{
                height:54px;
                padding-left:48px;
                font-size:14px;
            }

            .search-icon{
                left:17px;
            }

            .table-box{
                border-radius:17px;
            }

            .custom-table{
                min-width:820px;
            }

            .empty-state{
                padding:70px 18px;
            }

            .delete-modal{
                width:100%;
                padding:28px 19px 21px;
                border-radius:23px;
            }

            .modal-icon{
                width:58px;
                height:58px;
                border-radius:17px;
            }

            .delete-modal h3{
                font-size:23px;
            }

            .modal-buttons{
                flex-direction:column;
            }

            .btn-cancel,
            .btn-delete-confirm{
                width:100%;
                min-height:52px;
            }
        }

        @media (prefers-reduced-motion:reduce){
            *,
            *::before,
            *::after{
                scroll-behavior:auto !important;
                transition-duration:.01ms !important;
                animation-duration:.01ms !important;
                animation-iteration-count:1 !important;
            }
        }
    

/* =========================================================
   SIDEBAR MOBILE / TABLET
   Referensi: floating glass sidebar, tidak kepotong
========================================================= */
@media (max-width:900px){
    html,
    body{
        width:100%;
        min-height:100%;
    }

    body{
        overflow-x:hidden;
    }

    .admin-sidebar{
        position:fixed !important;
        top:10px !important;
        left:10px !important;
        right:auto !important;
        bottom:10px !important;

        width:min(320px, calc(100vw - 20px)) !important;
        height:calc(100dvh - 20px) !important;
        max-height:calc(100dvh - 20px) !important;
        min-height:0 !important;

        border:1px solid rgba(226,201,151,.16) !important;
        border-radius:18px !important;

        background:
            linear-gradient(
                180deg,
                rgba(18,18,18,.88) 0%,
                rgba(10,10,10,.84) 100%
            ) !important;

        backdrop-filter:blur(22px) saturate(115%) !important;
        -webkit-backdrop-filter:blur(22px) saturate(115%) !important;

        box-shadow:
            20px 0 60px rgba(0,0,0,.42),
            0 16px 45px rgba(0,0,0,.24) !important;

        overflow:hidden !important;
        isolation:isolate !important;

        transform:translate3d(calc(-100% - 18px),0,0) !important;
        transition:transform .30s cubic-bezier(.4,0,.2,1) !important;

        z-index:2100 !important;
    }

    .admin-sidebar.open{
        transform:translate3d(0,0,0) !important;
    }

    .admin-sidebar-brand{
        position:relative !important;
        padding:18px 14px 13px !important;
        border-bottom:1px solid rgba(255,255,255,.055) !important;
        background:rgba(0,0,0,.08) !important;
    }

    .admin-brand-link{
        gap:11px !important;
        padding-right:52px !important;
    }

    .admin-brand-logo{
        width:45px !important;
        height:45px !important;
        flex:0 0 45px !important;
        border-radius:12px !important;
    }

    .admin-brand-text strong{
        font-size:18px !important;
    }

    .admin-brand-text span{
        margin-top:4px !important;
        font-size:8.5px !important;
    }

    .admin-sidebar-close-button{
        display:flex !important;
        position:absolute !important;
        top:14px !important;
        right:13px !important;
        width:40px !important;
        height:40px !important;
        align-items:center !important;
        justify-content:center !important;
        border:1px solid rgba(226,201,151,.13) !important;
        border-radius:11px !important;
        background:rgba(255,255,255,.035) !important;
        color:#e2c997 !important;
        z-index:4 !important;
    }

    .admin-sidebar-user{
        margin:12px 13px 12px !important;
        padding:11px !important;
        border:1px solid rgba(226,201,151,.10) !important;
        border-radius:14px !important;
        background:rgba(255,255,255,.028) !important;
    }

    .admin-user-avatar{
        width:40px !important;
        height:40px !important;
        flex:0 0 40px !important;
    }

    .admin-user-info strong{
        font-size:14px !important;
    }

    .admin-user-info span{
        font-size:12px !important;
    }

    .admin-sidebar-nav{
        min-height:0 !important;
        padding:0 10px 8px !important;
        overflow-x:hidden !important;
        overflow-y:auto !important;
        scrollbar-width:thin !important;
        scrollbar-color:rgba(226,201,151,.22) transparent !important;
    }

    .admin-sidebar-nav::-webkit-scrollbar{
        width:5px;
    }

    .admin-sidebar-nav::-webkit-scrollbar-track{
        background:transparent;
    }

    .admin-sidebar-nav::-webkit-scrollbar-thumb{
        background:rgba(226,201,151,.22);
        border-radius:999px;
    }

    .admin-nav-title{
        margin:15px 9px 7px !important;
        font-size:10px !important;
    }

    .admin-nav-link{
        min-height:51px !important;
        margin:3px 0 !important;
        padding:0 9px !important;
        border-radius:11px !important;
    }

    .admin-nav-icon{
        width:36px !important;
        height:36px !important;
        flex:0 0 36px !important;
        font-size:13px !important;
    }

    .admin-nav-text{
        font-size:14.5px !important;
    }

    .admin-sidebar-footer{
        padding:10px 12px max(12px, env(safe-area-inset-bottom)) !important;
        border-top:1px solid rgba(255,255,255,.055) !important;
        background:rgba(0,0,0,.20) !important;
    }

    .admin-system-status{
        margin-bottom:7px !important;
        padding:9px 10px !important;
        border-radius:10px !important;
        font-size:11px !important;
    }

    .admin-logout-button{
        min-height:43px !important;
        padding:0 9px !important;
        font-size:13.5px !important;
    }

    .admin-sidebar-copyright{
        margin-top:7px !important;
        padding-top:8px !important;
        font-size:9px !important;
    }

    .admin-sidebar-copyright small{
        font-size:9px !important;
    }

    .admin-sidebar-overlay{
        z-index:2050 !important;
        background:rgba(0,0,0,.46) !important;
        backdrop-filter:blur(3px) !important;
        -webkit-backdrop-filter:blur(3px) !important;
    }

    body.admin-sidebar-open{
        overflow:hidden !important;
    }
}

@media (max-width:600px){
    .admin-sidebar{
        top:9px !important;
        left:9px !important;
        bottom:9px !important;
        width:min(320px, calc(100vw - 18px)) !important;
        height:calc(100dvh - 18px) !important;
        max-height:calc(100dvh - 18px) !important;
        border-radius:17px !important;
    }

    .admin-sidebar-brand{
        padding:18px 13px 12px !important;
    }
}

@media (max-width:380px){
    .admin-sidebar{
        top:8px !important;
        left:8px !important;
        bottom:8px !important;
        width:min(305px, calc(100vw - 16px)) !important;
        height:calc(100dvh - 16px) !important;
        max-height:calc(100dvh - 16px) !important;
    }

    .admin-sidebar-brand{
        padding-left:12px !important;
        padding-right:12px !important;
    }
}

@media (prefers-reduced-motion:reduce){
    .admin-sidebar,
    .admin-sidebar-overlay{
        transition:none !important;
    }
}

</style>


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
                const overlay = document.getElementById('sidebarOverlay');

                if (sidebar) {
                    sidebar.classList.add('active', 'open', 'show');
                }

                if (overlay) {
                    overlay.classList.add('active', 'open', 'show');
                    overlay.style.display = 'block';
                }

                document.body.classList.add('sidebar-open');
                openButton.setAttribute('aria-expanded', 'true');
            });
        });
    </script>

</body>

</html>