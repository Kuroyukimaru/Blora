<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>Edit Event — Noyo Gimbal</title>


    {{-- =========================================================
        FONT
    ========================================================== --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >


    {{-- =========================================================
        FONT AWESOME
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    {{-- =========================================================
        VITE
    ========================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body>


    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}

    @include('Admin.partials.sidebar')


    {{-- =========================================================
        MAIN
    ========================================================== --}}

    <main class="admin-main">


        {{-- =====================================================
            MOBILE HEADER
        ====================================================== --}}

        <div class="mobile-header">

            <button
                type="button"
                class="mobile-menu-button"
                id="openAdminSidebar"
                aria-label="Buka menu navigasi"
                aria-controls="adminSidebar"
                aria-expanded="false"
            >
                <i class="fas fa-bars"></i>
            </button>

        </div>


        {{-- =====================================================
            PAGE HEADER
        ====================================================== --}}

        <section class="page-header">

<div class="header-content">

                <div>
<h1 class="page-title">
                        Edit Event
                    </h1>

                    <p class="page-description">
                        Perbarui informasi event yang akan datang, tanggal pelaksanaan,
                        deskripsi, atau poster event.
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
            SUCCESS MESSAGE
        ====================================================== --}}

        @if(session('success'))

            <div class="alert alert-success">

                <div class="alert-icon">

                    <i class="fas fa-circle-check"></i>

                </div>


                <div class="alert-body">

                    <strong>
                        Berhasil
                    </strong>

                    <p>
                        {{ session('success') }}
                    </p>

                </div>


                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove()"
                >

                    <i class="fas fa-xmark"></i>

                </button>

            </div>

        @endif


        {{-- =====================================================
            VALIDATION ERROR
        ====================================================== --}}

        @if($errors->any())

            <div class="alert alert-danger">

                <div class="alert-icon">

                    <i class="fas fa-circle-exclamation"></i>

                </div>


                <div class="alert-body">

                    <strong>
                        Data belum dapat diperbarui
                    </strong>

                    <p>
                        Silakan periksa kembali data berikut:
                    </p>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>


                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove()"
                >

                    <i class="fas fa-xmark"></i>

                </button>

            </div>

        @endif


        {{-- =====================================================
            FORM
        ====================================================== --}}

        <form
            action="{{ route('admin.event.update', $event->id_event) }}"
            method="POST"
            enctype="multipart/form-data"
            id="eventForm"
        >

            @csrf

            @method('PUT')


            <div class="form-layout">


                {{-- =================================================
                    INFORMASI EVENT
                ================================================== --}}

                <div class="form-main-card">


                    {{-- CARD HEADER --}}

                    <div class="card-header">

                        <div class="card-header-icon">

                            <i class="fas fa-calendar-pen"></i>

                        </div>


                        <div>

                            <h2>
                                Informasi Event
                            </h2>

                            <p>
                                Perbarui informasi utama event.
                            </p>

                        </div>

                    </div>


                    {{-- CARD BODY --}}

                    <div class="card-body">


                        {{-- =================================================
                            JUDUL
                        ================================================== --}}

                        <div class="form-group">

                            <label for="judul">

                                <span class="label-icon">
                                    <i class="fas fa-heading"></i>
                                </span>

                                Judul Event

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <div class="input-wrapper">

                                <input
                                    type="text"
                                    id="judul"
                                    name="judul"
                                    value="{{ old('judul', $event->judul) }}"
                                    placeholder="Contoh: Festival Noyo Gimbal 2026"
                                    maxlength="255"
                                    autocomplete="off"
                                    required
                                >


                                <span
                                    class="input-counter"
                                    id="judulCounter"
                                >
                                    0 / 255
                                </span>

                            </div>


                            @error('judul')

                                <span class="field-error">

                                    <i class="fas fa-circle-exclamation"></i>

                                    {{ $message }}

                                </span>

                            @enderror

                        </div>


                        {{-- =================================================
                            TANGGAL
                        ================================================== --}}

                        <div class="form-group">

                            <label for="tanggal">

                                <span class="label-icon">
                                    <i class="far fa-calendar"></i>
                                </span>

                                Tanggal Event

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <div class="input-wrapper date-wrapper">

                                <input
                                    type="date"
                                    id="tanggal"
                                    name="tanggal"
                                    value="{{ old('tanggal', optional($event->tanggal)->format('Y-m-d')) }}"
                                    required
                                >

                            </div>


                            <span class="field-hint">

                                <i class="fas fa-circle-info"></i>

                                Tanggal pelaksanaan event yang akan datang.

                            </span>


                            @error('tanggal')

                                <span class="field-error">

                                    <i class="fas fa-circle-exclamation"></i>

                                    {{ $message }}

                                </span>

                            @enderror

                        </div>


                        {{-- =================================================
                            DESKRIPSI
                        ================================================== --}}

                        <div class="form-group">

                            <label for="deskripsi">

                                <span class="label-icon">
                                    <i class="fas fa-align-left"></i>
                                </span>

                                Deskripsi

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <div class="textarea-wrapper">

                                <textarea
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="9"
                                    placeholder="Tuliskan informasi lengkap mengenai event..."
                                    required
                                >{{ old('deskripsi', $event->deskripsi) }}</textarea>


                                <span
                                    class="textarea-counter"
                                    id="deskripsiCounter"
                                >
                                    0 karakter
                                </span>

                            </div>


                            @error('deskripsi')

                                <span class="field-error">

                                    <i class="fas fa-circle-exclamation"></i>

                                    {{ $message }}

                                </span>

                            @enderror

                        </div>


                    </div>

                </div>


                {{-- =================================================
                    SIDEBAR FORM
                ================================================== --}}

                <div class="form-side">


                    {{-- =================================================
                        POSTER
                    ================================================== --}}

                    <div class="image-card">


                        {{-- HEADER --}}

                        <div class="card-header">

                            <div class="card-header-icon">

                                <i class="fas fa-image"></i>

                            </div>


                            <div>

                                <h2>
                                    Poster Event
                                </h2>

                                <p>
                                    Kelola gambar event.
                                </p>

                            </div>

                        </div>


                        {{-- BODY --}}

                        <div class="image-card-body">


                            {{-- =================================================
                                PREVIEW
                            ================================================== --}}

                            <div
                                class="image-preview"
                                id="imagePreview"
                            >

                                @if($event->gambar)

                                    <img
                                        src="{{ asset('uploads/event/' . $event->gambar) }}"
                                        alt="Poster {{ $event->judul }}"
                                        id="previewImage"
                                        class="show"
                                    >

                                    <div
                                        class="preview-empty hidden"
                                        id="previewEmpty"
                                    >

                                        <div class="preview-icon">

                                            <i class="fas fa-image"></i>

                                        </div>

                                        <strong>
                                            Belum ada gambar
                                        </strong>

                                        <span>
                                            Preview poster akan muncul di sini
                                        </span>

                                    </div>

                                @else

                                    <div
                                        class="preview-empty"
                                        id="previewEmpty"
                                    >

                                        <div class="preview-icon">

                                            <i class="fas fa-image"></i>

                                        </div>

                                        <strong>
                                            Belum ada gambar
                                        </strong>

                                        <span>
                                            Preview poster akan muncul di sini
                                        </span>

                                    </div>


                                    <img
                                        src=""
                                        alt="Preview"
                                        id="previewImage"
                                    >

                                @endif


                                {{-- REMOVE PREVIEW --}}

                                <button
                                    type="button"
                                    class="remove-image"
                                    id="removeImage"
                                    title="Batalkan gambar baru"
                                >

                                    <i class="fas fa-xmark"></i>

                                </button>

                            </div>


                            {{-- =================================================
                                UPLOAD
                            ================================================== --}}

                            <label
                                for="gambar"
                                class="upload-area"
                                id="uploadArea"
                            >

                                <input
                                    type="file"
                                    id="gambar"
                                    name="gambar"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                >


                                <div class="upload-icon">

                                    <i class="fas fa-cloud-arrow-up"></i>

                                </div>


                                <strong id="uploadTitle">
                                    Pilih gambar baru
                                </strong>


                                <span id="uploadDescription">
                                    Klik atau tarik gambar ke sini
                                </span>


                                <small>
                                    JPG, JPEG, PNG, WEBP
                                    <br>
                                    Maksimal 2 MB
                                </small>

                            </label>


                            @error('gambar')

                                <span class="field-error">

                                    <i class="fas fa-circle-exclamation"></i>

                                    {{ $message }}

                                </span>

                            @enderror


                        </div>

                    </div>


                    {{-- =================================================
                        TIPS
                    ================================================== --}}

                    <div class="info-card">

                        <div class="info-icon">

                            <i class="fas fa-lightbulb"></i>

                        </div>


                        <div>

                            <strong>
                                Catatan
                            </strong>

                            <p>
                                Jika tidak memilih gambar baru,
                                poster yang sekarang akan tetap digunakan.
                            </p>

                        </div>

                    </div>


                </div>

            </div>


            {{-- =====================================================
                ACTION
            ====================================================== --}}

            <div class="form-actions">

                <a
                    href="{{ route('admin.event.index') }}"
                    class="cancel-button"
                >
                    <i class="fas fa-xmark"></i>
                    Batal
                </a>

                <button
                    type="submit"
                    class="save-button"
                    id="saveButton"
                >

                    <span
                        class="button-normal"
                        id="buttonNormal"
                    >

                        <i class="fas fa-floppy-disk"></i>

                        Perbarui Event

                    </span>


                    <span
                        class="button-loading"
                        id="buttonLoading"
                    >

                        <i class="fas fa-spinner fa-spin"></i>

                        Memperbarui...

                    </span>

                </button>

            </div>


        </form>


    </main>


    {{-- =============================================================
        JAVASCRIPT
    ============================================================= --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | ELEMENTS
        |--------------------------------------------------------------------------
        */

        const eventForm =
            document.getElementById('eventForm');

        const judulInput =
            document.getElementById('judul');

        const judulCounter =
            document.getElementById('judulCounter');

        const deskripsiInput =
            document.getElementById('deskripsi');

        const deskripsiCounter =
            document.getElementById('deskripsiCounter');

        const gambarInput =
            document.getElementById('gambar');

        const imagePreview =
            document.getElementById('imagePreview');

        const previewEmpty =
            document.getElementById('previewEmpty');

        const previewImage =
            document.getElementById('previewImage');

        const removeImage =
            document.getElementById('removeImage');

        const uploadArea =
            document.getElementById('uploadArea');

        const uploadTitle =
            document.getElementById('uploadTitle');

        const uploadDescription =
            document.getElementById('uploadDescription');

        const saveButton =
            document.getElementById('saveButton');

        const buttonNormal =
            document.getElementById('buttonNormal');

        const buttonLoading =
            document.getElementById('buttonLoading');


        /*
        |--------------------------------------------------------------------------
        | JUDUL COUNTER
        |--------------------------------------------------------------------------
        */

        function updateJudulCounter()
        {

            if (!judulInput || !judulCounter) {
                return;
            }


            const length =
                judulInput.value.length;


            judulCounter.textContent =
                `${length} / 255`;


            if (length >= 230) {

                judulCounter.classList.add(
                    'warning'
                );

            } else {

                judulCounter.classList.remove(
                    'warning'
                );

            }

        }


        if (judulInput) {

            judulInput.addEventListener(
                'input',
                updateJudulCounter
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DESKRIPSI COUNTER
        |--------------------------------------------------------------------------
        */

        function updateDeskripsiCounter()
        {

            if (!deskripsiInput || !deskripsiCounter) {
                return;
            }


            const length =
                deskripsiInput.value.length;


            deskripsiCounter.textContent =
                `${length} karakter`;

        }


        if (deskripsiInput) {

            deskripsiInput.addEventListener(
                'input',
                updateDeskripsiCounter
            );

        }


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPLOAD
        |--------------------------------------------------------------------------
        */

        if (gambarInput) {

            gambarInput.addEventListener(
                'change',
                function ()
                {

                    const file =
                        this.files[0];


                    if (!file) {

                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI FORMAT
                    |--------------------------------------------------------------------------
                    */

                    const allowedTypes = [
                        'image/jpeg',
                        'image/png',
                        'image/webp'
                    ];


                    if (
                        !allowedTypes.includes(
                            file.type
                        )
                    ) {

                        alert(
                            'Format gambar tidak didukung. Gunakan JPG, JPEG, PNG, atau WEBP.'
                        );


                        this.value = '';


                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | VALIDASI UKURAN
                    |--------------------------------------------------------------------------
                    */

                    const maxSize =
                        2 * 1024 * 1024;


                    if (
                        file.size > maxSize
                    ) {

                        alert(
                            'Ukuran gambar terlalu besar. Maksimal 2 MB.'
                        );


                        this.value = '';


                        return;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | PREVIEW
                    |--------------------------------------------------------------------------
                    */

                    const reader =
                        new FileReader();


                    reader.onload =
                        function (event)
                        {

                            previewImage.src =
                                event.target.result;


                            previewImage.classList.add(
                                'show'
                            );


                            if (previewEmpty) {

                                previewEmpty.classList.add(
                                    'hidden'
                                );

                            }


                            if (removeImage) {

                                removeImage.classList.add(
                                    'show'
                                );

                            }


                            if (uploadArea) {

                                uploadArea.classList.add(
                                    'selected'
                                );

                            }


                            if (uploadTitle) {

                                uploadTitle.textContent =
                                    file.name;

                            }


                            if (uploadDescription) {

                                uploadDescription.textContent =
                                    formatFileSize(
                                        file.size
                                    );

                            }

                        };


                    reader.readAsDataURL(file);

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | REMOVE NEW IMAGE
        |--------------------------------------------------------------------------
        */

        if (removeImage) {

            removeImage.addEventListener(
                'click',
                function (event)
                {

                    event.preventDefault();

                    event.stopPropagation();


                    gambarInput.value = '';


                    resetNewImage();

                }
            );

        }


        function resetNewImage()
        {

            /*
            |--------------------------------------------------------------------------
            | Jika event mempunyai gambar lama,
            | tampilkan kembali gambar lama.
            |--------------------------------------------------------------------------
            */

            const oldImage =
                "{{ $event->gambar ? asset('uploads/event/' . $event->gambar) : '' }}";


            if (oldImage) {

                previewImage.src =
                    oldImage;

                previewImage.classList.add(
                    'show'
                );


                if (previewEmpty) {

                    previewEmpty.classList.add(
                        'hidden'
                    );

                }

            } else {

                previewImage.src = '';

                previewImage.classList.remove(
                    'show'
                );


                if (previewEmpty) {

                    previewEmpty.classList.remove(
                        'hidden'
                    );

                }

            }


            if (removeImage) {

                removeImage.classList.remove(
                    'show'
                );

            }


            if (uploadArea) {

                uploadArea.classList.remove(
                    'selected'
                );

            }


            if (uploadTitle) {

                uploadTitle.textContent =
                    'Pilih gambar baru';

            }


            if (uploadDescription) {

                uploadDescription.textContent =
                    'Klik atau tarik gambar ke sini';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT FILE SIZE
        |--------------------------------------------------------------------------
        */

        function formatFileSize(bytes)
        {

            if (bytes < 1024) {

                return bytes + ' B';

            }


            if (
                bytes <
                1024 * 1024
            ) {

                return (
                    bytes / 1024
                ).toFixed(1) + ' KB';

            }


            return (
                bytes /
                (1024 * 1024)
            ).toFixed(2) + ' MB';

        }


        /*
        |--------------------------------------------------------------------------
        | DRAG & DROP
        |--------------------------------------------------------------------------
        */

        if (uploadArea) {

            [
                'dragenter',
                'dragover'
            ].forEach(
                function (eventName)
                {

                    uploadArea.addEventListener(
                        eventName,
                        function (event)
                        {

                            event.preventDefault();

                            event.stopPropagation();


                            uploadArea.classList.add(
                                'dragging'
                            );

                        }
                    );

                }
            );


            [
                'dragleave',
                'drop'
            ].forEach(
                function (eventName)
                {

                    uploadArea.addEventListener(
                        eventName,
                        function (event)
                        {

                            event.preventDefault();

                            event.stopPropagation();


                            uploadArea.classList.remove(
                                'dragging'
                            );

                        }
                    );

                }
            );


            uploadArea.addEventListener(
                'drop',
                function (event)
                {

                    const files =
                        event.dataTransfer.files;


                    if (!files.length) {

                        return;

                    }


                    gambarInput.files =
                        files;


                    gambarInput.dispatchEvent(
                        new Event('change')
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FORM SUBMIT
        |--------------------------------------------------------------------------
        */

        if (eventForm) {

            eventForm.addEventListener(
                'submit',
                function (event)
                {
                    const tanggalInput = document.getElementById('tanggal');
                    const today = new Date().toISOString().split('T')[0];

                    if (tanggalInput && tanggalInput.value < today) {
                        event.preventDefault();
                        alert('Tanggal event harus hari ini atau tanggal yang akan datang.');
                        tanggalInput.focus();
                        return;
                    }

                    if (
                        saveButton.disabled
                    ) {

                        event.preventDefault();

                        return;

                    }


                    saveButton.disabled =
                        true;


                    buttonNormal.style.display =
                        'none';


                    buttonLoading.style.display =
                        'inline-flex';

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | INITIAL COUNTER
        |--------------------------------------------------------------------------
        */

        updateJudulCounter();

        updateDeskripsiCounter();


    </script>


    {{-- =============================================================
        STYLE
    ============================================================= --}}

    <style>
        @import "tailwindcss";

        /* =========================================================
           NOYO GIMBAL — MODERN ELEGANT DESIGN SYSTEM
        ========================================================== */
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

            --white:#fff;
            --black:#000;

            --shadow-soft:0 20px 60px rgba(0,0,0,.40);
            --shadow-hover:0 25px 70px rgba(0,0,0,.50);

            --radius-lg:28px;
            --radius-md:16px;
            --radius-sm:13px;
            --radius-full:999px;

            --transition:.25s cubic-bezier(.4,0,.2,1);

            --sidebar-desktop:300px;
            --sidebar-tablet:250px;
        }

        *,
        *::before,
        *::after{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html{
            scroll-behavior:smooth;
        }

        body{
            min-height:100vh;
            font-family:'Inter',Arial,sans-serif;
            color:var(--text-primary);
            background:
                radial-gradient(circle at 88% 3%,rgba(226,201,151,.055),transparent 28%),
                radial-gradient(circle at 5% 95%,rgba(226,201,151,.025),transparent 25%),
                var(--bg-primary);
            overflow-x:hidden;
            line-height:1.65;
            font-size:15px;
        }

        button,
        input,
        textarea{
            font:inherit;
        }

        button,
        a,
        input,
        textarea{
            -webkit-tap-highlight-color:transparent;
        }

        ::selection{
            background:rgba(226,201,151,.22);
            color:var(--text-primary);
        }

        /* =========================================================
           MAIN LAYOUT
        ========================================================== */
        .admin-main{
            width:calc(100% - var(--sidebar-desktop));
            margin-left:var(--sidebar-desktop);
            min-height:100vh;
            padding:54px 56px 76px;
        }

        /* =========================================================
           MOBILE HEADER
        ========================================================== */
        .mobile-header{
            display:none;
        }

        .mobile-menu-button{
            width:46px;
            height:46px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border:1px solid var(--border-gold);
            border-radius:13px;
            background:rgba(255,255,255,.035);
            color:var(--accent);
            cursor:pointer;
            transition:all var(--transition);
            flex:0 0 auto;
        }

        .mobile-menu-button:hover{
            background:rgba(226,201,151,.08);
            border-color:rgba(226,201,151,.40);
            transform:translateY(-1px);
        }

        /* =========================================================
           PAGE HEADER
        ========================================================== */
        .page-header{
            margin-bottom:28px;
        }

        .header-content{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:30px;
        }

        .page-title{
            margin:0;
            font-family:'Playfair Display',Georgia,serif;
            font-size:clamp(42px,4vw,60px);
            line-height:1.06;
            letter-spacing:-1.2px;
            font-weight:700;
            background:linear-gradient(
                135deg,
                var(--accent) 0%,
                #f8f4ed 52%,
                var(--accent-dark) 100%
            );
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            background-clip:text;
        }

        .page-description{
            max-width:780px;
            margin-top:12px;
            color:var(--text-muted);
            font-size:16px;
            line-height:1.75;
        }

        /* =========================================================
           ALERTS
        ========================================================== */
        .alert{
            position:relative;
            display:flex;
            align-items:flex-start;
            gap:14px;
            margin-bottom:22px;
            padding:18px 20px;
            border:1px solid var(--border-gold);
            border-radius:18px;
            background:
                linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.015)),
                rgba(18,18,18,.84);
            box-shadow:var(--shadow-soft);
            backdrop-filter:blur(18px);
            -webkit-backdrop-filter:blur(18px);
        }

        .alert-success{
            border-color:rgba(127,201,149,.22);
            background:
                linear-gradient(145deg,rgba(127,201,149,.055),rgba(255,255,255,.012)),
                rgba(18,18,18,.85);
        }

        .alert-danger{
            border-color:rgba(205,100,100,.25);
            background:
                linear-gradient(145deg,rgba(205,100,100,.055),rgba(255,255,255,.012)),
                rgba(18,18,18,.85);
        }

        .alert-icon{
            width:38px;
            height:38px;
            flex:0 0 38px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(226,201,151,.14);
            border-radius:12px;
            background:rgba(226,201,151,.07);
            color:var(--accent);
            font-size:15px;
        }

        .alert-success .alert-icon{
            color:#9be4bd;
            background:rgba(127,201,149,.08);
        }

        .alert-danger .alert-icon{
            color:#f0aaa5;
            background:rgba(205,100,100,.08);
        }

        .alert-body{
            flex:1;
            min-width:0;
        }

        .alert-body strong{
            display:block;
            margin-bottom:4px;
            color:var(--text-primary);
            font-size:15px;
            font-weight:800;
        }

        .alert-body p{
            margin:0;
            color:var(--text-muted);
            font-size:14px;
            line-height:1.65;
        }

        .alert-body ul{
            margin:8px 0 0;
            padding-left:18px;
            color:var(--text-secondary);
            font-size:14px;
            line-height:1.7;
        }

        .alert-close{
            width:38px;
            height:38px;
            flex:0 0 38px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(255,255,255,.07);
            border-radius:11px;
            background:rgba(255,255,255,.025);
            color:var(--text-muted);
            cursor:pointer;
            transition:all var(--transition);
        }

        .alert-close:hover{
            color:var(--accent);
            border-color:var(--border-gold);
            background:rgba(226,201,151,.07);
        }

        /* =========================================================
           FORM LAYOUT
        ========================================================== */
        .form-layout{
            display:grid;
            grid-template-columns:minmax(0,1.58fr) minmax(360px,.82fr);
            gap:24px;
            align-items:start;
        }

        .form-main-card,
        .image-card,
        .info-card{
            position:relative;
            border:1px solid var(--border-gold);
            border-radius:var(--radius-lg);
            background:
                linear-gradient(145deg,rgba(255,255,255,.045),rgba(255,255,255,.015)),
                rgba(18,18,18,.90);
            box-shadow:var(--shadow-soft);
            backdrop-filter:blur(24px);
            -webkit-backdrop-filter:blur(24px);
            overflow:hidden;
        }

        .form-main-card::before,
        .image-card::before,
        .info-card::before{
            content:"";
            position:absolute;
            top:0;
            left:0;
            right:0;
            height:1px;
            background:linear-gradient(90deg,transparent,rgba(226,201,151,.34),transparent);
            pointer-events:none;
        }

        .form-side{
            display:flex;
            flex-direction:column;
            gap:18px;
        }

        /* =========================================================
           CARD HEADER
        ========================================================== */
        .card-header{
            display:flex;
            align-items:center;
            gap:13px;
            padding:23px 25px;
            border-bottom:1px solid rgba(226,201,151,.10);
        }

        .card-header-icon{
            width:42px;
            height:42px;
            flex:0 0 42px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(226,201,151,.18);
            border-radius:13px;
            background:rgba(226,201,151,.075);
            color:var(--accent);
            font-size:15px;
        }

        .card-header h2{
            margin:0 0 2px;
            color:var(--text-primary);
            font-family:'Playfair Display',Georgia,serif;
            font-size:22px;
            line-height:1.25;
            font-weight:700;
        }

        .card-header p{
            margin:0;
            color:var(--text-muted);
            font-size:14px;
            line-height:1.55;
        }

        .card-body{
            padding:30px 25px 32px;
        }

        /* =========================================================
           FORM FIELDS
        ========================================================== */
        .form-group{
            margin-bottom:24px;
        }

        .form-group:last-child{
            margin-bottom:0;
        }

        .form-group label{
            display:flex;
            align-items:center;
            gap:8px;
            margin-bottom:10px;
            color:var(--text-primary);
            font-size:15px;
            font-weight:700;
            line-height:1.45;
            letter-spacing:0;
            text-transform:none;
        }

        .label-icon{
            color:var(--accent);
            font-size:13px;
        }

        .required{
            color:#efaaa5;
            font-size:14px;
        }

        .input-wrapper,
        .textarea-wrapper{
            position:relative;
        }

        .input-wrapper input,
        .textarea-wrapper textarea{
            width:100%;
            border:1px solid rgba(255,255,255,.075);
            border-radius:15px;
            outline:none;
            background:rgba(255,255,255,.032);
            color:var(--text-primary);
            transition:
                border-color var(--transition),
                background var(--transition),
                box-shadow var(--transition),
                transform var(--transition);
        }

        .input-wrapper input{
            height:58px;
            padding:0 18px;
            font-size:15px;
        }

        .textarea-wrapper textarea{
            min-height:205px;
            padding:16px 18px 38px;
            resize:vertical;
            font-size:15px;
            line-height:1.75;
        }

        .input-wrapper input::placeholder,
        .textarea-wrapper textarea::placeholder{
            color:var(--text-dim);
            opacity:1;
        }

        .input-wrapper input:focus,
        .textarea-wrapper textarea:focus{
            border-color:rgba(226,201,151,.52);
            background:rgba(226,201,151,.042);
            box-shadow:0 0 0 4px rgba(226,201,151,.06);
        }

        .date-wrapper input{
            color-scheme:dark;
        }

        ::-webkit-calendar-picker-indicator{
            opacity:.75;
            cursor:pointer;
        }

        .input-counter,
        .textarea-counter{
            position:absolute;
            color:var(--text-dim);
            font-size:12px;
            line-height:1;
        }

        .input-counter{
            top:50%;
            right:15px;
            transform:translateY(-50%);
        }

        .textarea-counter{
            right:15px;
            bottom:13px;
        }

        .input-counter.warning{
            color:#f1b35b;
        }

        .field-hint,
        .field-error{
            display:flex;
            align-items:flex-start;
            gap:7px;
            margin-top:8px;
            font-size:13px;
            line-height:1.6;
        }

        .field-hint{
            color:var(--text-dim);
        }

        .field-error{
            color:#f0aaa5;
        }

        /* =========================================================
           IMAGE / POSTER
        ========================================================== */
        .image-card-body{
            padding:21px;
        }

        .image-preview{
            position:relative;
            width:100%;
            aspect-ratio:16 / 10;
            overflow:hidden;
            margin-bottom:14px;
            border:1px solid rgba(226,201,151,.15);
            border-radius:17px;
            background:
                radial-gradient(circle at 50% 0%,rgba(226,201,151,.055),transparent 42%),
                #0f0f0f;
        }

        .preview-empty{
            position:absolute;
            inset:0;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:6px;
            padding:22px;
            color:var(--text-dim);
            text-align:center;
        }

        .preview-empty.hidden{
            display:none;
        }

        .preview-icon{
            width:52px;
            height:52px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom:7px;
            border:1px solid rgba(226,201,151,.16);
            border-radius:15px;
            background:rgba(226,201,151,.065);
            color:var(--accent);
            font-size:18px;
        }

        .preview-empty strong{
            color:var(--text-secondary);
            font-size:14px;
            font-weight:700;
        }

        .preview-empty span{
            max-width:220px;
            color:var(--text-dim);
            font-size:13px;
            line-height:1.55;
        }

        #previewImage{
            width:100%;
            height:100%;
            display:none;
            object-fit:cover;
        }

        #previewImage.show{
            display:block;
        }

        .remove-image{
            position:absolute;
            top:12px;
            right:12px;
            z-index:5;
            width:40px;
            height:40px;
            display:none;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(255,255,255,.12);
            border-radius:12px;
            background:rgba(0,0,0,.56);
            color:#fff;
            cursor:pointer;
            backdrop-filter:blur(9px);
            transition:all var(--transition);
        }

        .remove-image.show{
            display:flex;
        }

        .remove-image:hover{
            background:rgba(157,75,75,.75);
            border-color:rgba(235,130,130,.4);
        }

        .upload-area{
            position:relative;
            min-height:168px;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            padding:24px;
            border:1px dashed rgba(226,201,151,.28);
            border-radius:17px;
            background:
                radial-gradient(circle at 50% 0%,rgba(226,201,151,.055),transparent 45%),
                rgba(255,255,255,.016);
            text-align:center;
            cursor:pointer;
            transition:all var(--transition);
        }

        .upload-area input{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            opacity:0;
            cursor:pointer;
        }

        .upload-area:hover,
        .upload-area.dragging{
            border-color:rgba(226,201,151,.60);
            background:rgba(226,201,151,.045);
            transform:translateY(-1px);
        }

        .upload-area.selected{
            border-color:rgba(127,201,149,.34);
            background:rgba(127,201,149,.028);
        }

        .upload-icon{
            width:62px;
            height:62px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom:13px;
            border:1px solid rgba(226,201,151,.18);
            border-radius:18px;
            background:rgba(226,201,151,.075);
            color:var(--accent);
            font-size:23px;
            box-shadow:0 12px 30px rgba(0,0,0,.20);
        }

        .upload-area strong{
            max-width:280px;
            overflow:hidden;
            color:var(--text-primary);
            font-size:15px;
            font-weight:800;
            line-height:1.45;
            text-overflow:ellipsis;
            white-space:nowrap;
        }

        .upload-area span{
            margin-top:6px;
            color:var(--text-muted);
            font-size:13px;
            line-height:1.55;
        }

        .upload-area small{
            margin-top:10px;
            color:var(--text-dim);
            font-size:12px;
            line-height:1.55;
        }

        /* =========================================================
           INFO CARD
        ========================================================== */
        .info-card{
            display:flex;
            align-items:flex-start;
            gap:13px;
            padding:18px;
        }

        .info-icon{
            width:38px;
            height:38px;
            flex:0 0 38px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid rgba(226,201,151,.14);
            border-radius:11px;
            background:rgba(226,201,151,.07);
            color:var(--accent);
            font-size:14px;
        }

        .info-card strong{
            display:block;
            margin-bottom:4px;
            color:var(--text-primary);
            font-size:14px;
            font-weight:800;
        }

        .info-card p{
            margin:0;
            color:var(--text-muted);
            font-size:13px;
            line-height:1.65;
        }

        /* =========================================================
           ACTIONS
        ========================================================== */
        .form-actions{
            display:flex;
            align-items:center;
            justify-content:flex-end;
            gap:12px;
            margin-top:26px;
            padding-top:22px;
            border-top:1px solid rgba(226,201,151,.10);
        }

        .cancel-button,
        .save-button{
            min-height:56px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:9px;
            padding:0 25px;
            border-radius:var(--radius-full);
            font-size:15px;
            font-weight:800;
            text-decoration:none;
            cursor:pointer;
            transition:all var(--transition);
        }

        .cancel-button{
            border:1px solid var(--border-gold);
            background:rgba(226,201,151,.05);
            color:var(--text-secondary);
        }

        .cancel-button:hover{
            color:var(--accent);
            border-color:rgba(226,201,151,.42);
            background:rgba(226,201,151,.10);
            transform:translateY(-2px);
        }

        .save-button{
            min-width:190px;
            border:1px solid rgba(226,201,151,.42);
            background:linear-gradient(
                135deg,
                var(--accent) 0%,
                var(--accent-hover) 100%
            );
            color:var(--bg-primary);
            box-shadow:0 12px 30px rgba(0,0,0,.24);
        }

        .save-button:hover:not(:disabled){
            background:linear-gradient(
                135deg,
                var(--accent-hover) 0%,
                var(--accent-dark) 100%
            );
            transform:translateY(-3px);
            box-shadow:var(--shadow-hover);
        }

        .save-button:disabled{
            opacity:.68;
            cursor:wait;
            transform:none;
        }

        .button-loading{
            display:none;
            align-items:center;
            gap:8px;
        }

        /* =========================================================
           RESPONSIVE — LARGE SCREENS
        ========================================================== */
        @media (min-width:1500px){
            .admin-main{
                padding:62px 72px 88px;
            }

            .form-layout{
                grid-template-columns:minmax(0,1.62fr) minmax(390px,.82fr);
                gap:28px;
            }

            .card-body{
                padding:34px 30px 36px;
            }

            .card-header{
                padding:25px 30px;
            }
        }

        /* =========================================================
           RESPONSIVE — LAPTOP
        ========================================================== */
        @media (max-width:1199px){
            .admin-main{
                width:calc(100% - var(--sidebar-tablet));
                margin-left:var(--sidebar-tablet);
                padding:44px 32px 60px;
            }

            .form-layout{
                grid-template-columns:minmax(0,1.45fr) minmax(320px,.85fr);
                gap:20px;
            }

            .page-title{
                font-size:48px;
            }
        }

        @media (max-width:1024px){
            .admin-main{
                width:100%;
                margin-left:0;
                padding:92px 28px 52px;
            }

            .mobile-header{
                position:fixed;
                top:0;
                left:0;
                right:0;
                z-index:2000;
                height:68px;
                display:flex;
                align-items:center;
                justify-content:space-between;
                padding:0 22px;
                border-bottom:1px solid var(--border-soft);
                background:rgba(9,9,9,.91);
                backdrop-filter:blur(18px);
                -webkit-backdrop-filter:blur(18px);
            }

            .form-layout{
                grid-template-columns:1fr;
            }

            .form-side{
                display:grid;
                grid-template-columns:1fr 1fr;
                align-items:start;
                gap:18px;
            }

            .page-header{
                margin-bottom:26px;
            }
        }

        /* =========================================================
           RESPONSIVE — TABLET
        ========================================================== */
        @media (max-width:900px){
            .admin-main{
                padding:88px 24px 48px;
            }

            .page-title{
                font-size:44px;
            }

            .page-description{
                font-size:15px;
            }

            .form-side{
                display:flex;
                flex-direction:column;
            }

            .card-header{
                padding:21px 22px;
            }

            .card-body{
                padding:26px 22px 30px;
            }

            .image-card-body{
                padding:20px;
            }

            .form-group label{
                font-size:15px;
            }

            .input-wrapper input{
                height:58px;
                font-size:15px;
            }

            .textarea-wrapper textarea{
                min-height:190px;
                font-size:15px;
            }
        }

        /* =========================================================
           RESPONSIVE — HP
        ========================================================== */
        @media (max-width:640px){
            .admin-main{
                padding:82px 15px 34px;
            }

            .mobile-header{
                height:64px;
                padding:0 14px;
                justify-content:flex-start;
            }

            .mobile-menu-button{
                width:46px;
                height:46px;
            }

            .page-title{
                font-size:37px;
                letter-spacing:-.75px;
            }

            .page-description{
                margin-top:10px;
                font-size:14px;
                line-height:1.72;
            }

            .alert{
                padding:15px;
                gap:11px;
                border-radius:16px;
            }

            .alert-icon,
            .alert-close{
                width:36px;
                height:36px;
                flex-basis:36px;
            }

            .alert-body strong{
                font-size:14px;
            }

            .alert-body p,
            .alert-body ul{
                font-size:13px;
            }

            .form-main-card,
            .image-card,
            .info-card{
                border-radius:21px;
            }

            .card-header{
                padding:18px;
                gap:11px;
            }

            .card-header-icon{
                width:38px;
                height:38px;
                flex-basis:38px;
                border-radius:11px;
            }

            .card-header h2{
                font-size:20px;
            }

            .card-header p{
                font-size:13px;
            }

            .card-body{
                padding:21px 18px 25px;
            }

            .form-group{
                margin-bottom:21px;
            }

            .form-group label{
                font-size:15px;
                margin-bottom:9px;
            }

            .input-wrapper input{
                height:56px;
                padding:0 16px;
                font-size:15px;
            }

            .textarea-wrapper textarea{
                min-height:165px;
                padding:15px 16px 36px;
                font-size:15px;
            }

            .input-counter,
            .textarea-counter{
                font-size:11px;
            }

            .field-hint,
            .field-error{
                font-size:12px;
            }

            .image-card-body{
                padding:18px;
            }

            .image-preview{
                aspect-ratio:16 / 10;
            }

            .upload-area{
                min-height:170px;
                padding:20px;
            }

            .upload-icon{
                width:58px;
                height:58px;
                font-size:21px;
            }

            .upload-area strong{
                font-size:14px;
            }

            .upload-area span{
                font-size:12px;
            }

            .upload-area small{
                font-size:11px;
            }

            .info-card{
                padding:16px;
            }

            .info-card p{
                font-size:12px;
            }

            .form-actions{
                position:sticky;
                bottom:0;
                z-index:100;
                margin:0 -15px;
                padding:11px 15px;
                display:grid;
                grid-template-columns:1fr 1.45fr;
                gap:9px;
                border-top:1px solid rgba(226,201,151,.10);
                background:rgba(9,9,9,.91);
                backdrop-filter:blur(18px);
                -webkit-backdrop-filter:blur(18px);
            }

            .cancel-button,
            .save-button{
                width:100%;
                min-height:56px;
                padding:0 12px;
                font-size:14px;
            }

            .save-button{
                min-width:0;
            }
        }

        /* =========================================================
           RESPONSIVE — SMALL HP
        ========================================================== */
        @media (max-width:380px){
            .admin-main{
                padding-left:12px;
                padding-right:12px;
            }

            .page-title{
                font-size:33px;
            }

            .form-actions{
                margin-left:-12px;
                margin-right:-12px;
                padding-left:12px;
                padding-right:12px;
            }

            .cancel-button,
            .save-button{
                font-size:13px;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================== */
        @media (prefers-reduced-motion:reduce){
            *,
            *::before,
            *::after{
                scroll-behavior:auto !important;
                animation:none !important;
                transition:none !important;
            }
        }
    </style>




    <!--
        FINAL SIDEBAR OVERRIDE
        Dibuat sebagai glass drawer di HP/tablet agar tidak terpotong,
        tetap transparan, dan tetap kompatibel dengan sidebar asli.
    -->
    <style>
        @media (max-width:900px){

            body{
                overflow-x:hidden;
            }

            .mobile-header{
                position:fixed;
                top:0;
                left:0;
                right:0;
                height:68px;
                z-index:1050;
                display:flex;
                align-items:center;
                justify-content:flex-start;
                padding:10px 14px;
                background:rgba(10,10,10,.30);
                border-bottom:1px solid rgba(226,201,151,.06);
                backdrop-filter:blur(12px);
                -webkit-backdrop-filter:blur(12px);
                transition:opacity .22s ease;
            }

            .mobile-menu-button{
                width:46px;
                height:46px;
                border-radius:14px;
                border:1px solid rgba(226,201,151,.28);
                background:rgba(18,18,18,.72);
                color:var(--accent,#e2c997);
                box-shadow:0 12px 30px rgba(0,0,0,.28);
                backdrop-filter:blur(18px);
                -webkit-backdrop-filter:blur(18px);
            }

            .admin-sidebar{
                position:fixed !important;
                top:12px !important;
                right:auto !important;
                bottom:12px !important;
                left:4px !important;

                width:min(320px, calc(100vw - 16px)) !important;
                height:calc(100dvh - 24px) !important;
                max-height:calc(100dvh - 24px) !important;

                z-index:2200 !important;

                border:1px solid rgba(226,201,151,.18) !important;
                border-radius:18px !important;

                background:
                    linear-gradient(
                        145deg,
                        rgba(255,255,255,.055),
                        rgba(255,255,255,.018)
                    ),
                    rgba(10,10,10,.76) !important;

                box-shadow:
                    22px 22px 70px rgba(0,0,0,.52),
                    inset 0 1px 0 rgba(255,255,255,.035) !important;

                backdrop-filter:blur(26px) saturate(115%) !important;
                -webkit-backdrop-filter:blur(26px) saturate(115%) !important;

                overflow:hidden !important;
                transform:translate3d(calc(-100% - 16px),0,0) !important;
                transition:transform .30s cubic-bezier(.4,0,.2,1) !important;
            }

            .admin-sidebar.open{
                transform:translate3d(0,0,0) !important;
            }

            .admin-sidebar::after{
                opacity:.7;
            }

            .admin-sidebar-brand{
                position:relative;
                z-index:2;
                padding:18px 16px 16px !important;
                background:rgba(10,10,10,.18);
                border-bottom:1px solid rgba(226,201,151,.07);
            }

            .admin-sidebar-close-button{
                display:flex !important;
                width:40px !important;
                height:40px !important;
                top:14px !important;
                right:12px !important;
                border-radius:11px !important;
                background:rgba(255,255,255,.035) !important;
                border-color:rgba(255,255,255,.08) !important;
                color:var(--admin-text-muted,#a89988) !important;
                z-index:5;
            }

            .admin-brand-link{
                padding-right:52px;
            }

            .admin-sidebar-user{
                margin:14px 14px 16px !important;
                padding:12px !important;
                background:rgba(255,255,255,.032) !important;
                border-color:rgba(255,255,255,.075) !important;
                border-radius:14px !important;
            }

            .admin-sidebar-nav{
                min-height:0 !important;
                overflow-x:hidden !important;
                overflow-y:auto !important;
                padding:0 10px 9px !important;
                scrollbar-width:thin;
                scrollbar-color:rgba(226,201,151,.22) transparent;
            }

            .admin-sidebar-nav::-webkit-scrollbar{
                width:5px;
            }

            .admin-sidebar-nav::-webkit-scrollbar-thumb{
                background:rgba(226,201,151,.22);
                border-radius:999px;
            }

            .admin-nav-link{
                min-height:50px !important;
                border-radius:11px !important;
            }

            .admin-sidebar-footer{
                background:rgba(10,10,10,.52) !important;
                backdrop-filter:blur(18px);
                -webkit-backdrop-filter:blur(18px);
                padding:12px 13px max(13px, env(safe-area-inset-bottom)) !important;
            }

            .admin-sidebar-overlay{
                display:block !important;
                position:fixed !important;
                inset:0 !important;
                z-index:2100 !important;
                background:rgba(0,0,0,.26) !important;
                backdrop-filter:blur(7px) !important;
                -webkit-backdrop-filter:blur(7px) !important;
                opacity:0;
                visibility:hidden;
                pointer-events:none;
                transition:opacity .25s ease, visibility .25s ease !important;
            }

            .admin-sidebar-overlay.show{
                display:block !important;
                opacity:1 !important;
                visibility:visible !important;
                pointer-events:auto !important;
            }

            body.admin-sidebar-open .mobile-header{
                opacity:0;
                pointer-events:none;
            }

            body.admin-sidebar-open{
                overflow:hidden !important;
            }
        }

        @media (max-width:600px){

            .admin-sidebar{
                top:8px !important;
                left:4px !important;
                bottom:8px !important;
                width:min(320px, calc(100vw - 12px)) !important;
                height:calc(100dvh - 16px) !important;
                max-height:calc(100dvh - 16px) !important;
                border-radius:17px !important;
            }

            .admin-sidebar-brand{
                padding:15px 13px 14px !important;
            }

            .admin-sidebar-user{
                margin:12px 12px 14px !important;
            }

            .admin-nav-link{
                min-height:51px !important;
            }

            .admin-sidebar-footer{
                padding-left:12px !important;
                padding-right:12px !important;
            }
        }

        @media (max-height:700px) and (max-width:900px){

            .admin-sidebar{
                top:8px !important;
                bottom:8px !important;
                height:calc(100dvh - 16px) !important;
                max-height:calc(100dvh - 16px) !important;
            }

            .admin-sidebar-brand{
                padding-top:12px !important;
                padding-bottom:11px !important;
            }

            .admin-sidebar-user{
                margin-top:9px !important;
                margin-bottom:10px !important;
            }

            .admin-nav-link{
                min-height:46px !important;
            }

            .admin-sidebar-footer{
                padding-top:9px !important;
                padding-bottom:max(9px, env(safe-area-inset-bottom)) !important;
            }
        }

        @media (prefers-reduced-motion:reduce){
            .admin-sidebar,
            .admin-sidebar-overlay,
            .mobile-header{
                transition:none !important;
            }
        }
    </style>

</body>

</html>