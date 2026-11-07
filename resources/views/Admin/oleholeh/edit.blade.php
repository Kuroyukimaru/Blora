<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Oleh-Oleh</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style id="noyo-gimbal-sidebar-reference-final">

@media (max-width:900px){

    html,
    body{
        width:100%;
        min-width:0;
        min-height:100%;
    }

    body{
        overflow-x:hidden !important;
    }

    .admin-sidebar{
        position:fixed !important;

        top:14px !important;
        left:18px !important;
        right:auto !important;
        bottom:14px !important;

        width:min(320px, calc(100vw - 36px)) !important;
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

        text-decoration:none !important;
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
        font-family:'Playfair Display', Georgia, serif !important;
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

        transition:
            background .2s ease,
            border-color .2s ease,
            transform .2s ease,
            color .2s ease !important;
    }

    .admin-sidebar-close-button:hover{
        background:rgba(226,201,151,.09) !important;
        border-color:rgba(226,201,151,.40) !important;
        color:#f8f4ed !important;
        transform:translateY(-1px) !important;
    }

    .admin-sidebar-close-button:focus-visible{
        outline:2px solid rgba(226,201,151,.72) !important;
        outline-offset:3px !important;
    }

    .admin-sidebar-user{
        margin:11px 12px 10px !important;
        padding:10px !important;

        border:1px solid rgba(226,201,151,.10) !important;
        border-radius:14px !important;

        background:rgba(255,255,255,.028) !important;

        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.018) !important;
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
        display:block !important;

        color:#f8f4ed !important;
        font-size:14px !important;
        font-weight:800 !important;
        line-height:1.35 !important;

        white-space:nowrap !important;
        overflow:hidden !important;
        text-overflow:ellipsis !important;
    }

    .admin-user-info span{
        display:block !important;

        margin-top:2px !important;

        color:#a89988 !important;
        font-size:12px !important;
        line-height:1.35 !important;

        white-space:nowrap !important;
        overflow:hidden !important;
        text-overflow:ellipsis !important;
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

    .admin-sidebar-nav::-webkit-scrollbar-track{
        background:transparent !important;
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
        line-height:1.2 !important;
        letter-spacing:1.35px !important;

        text-transform:uppercase !important;
    }

    .admin-nav-link{
        position:relative !important;

        width:100% !important;
        min-height:50px !important;

        display:flex !important;
        align-items:center !important;

        margin:2px 0 !important;
        padding:0 8px !important;

        border:1px solid transparent !important;
        border-radius:11px !important;

        color:#d0cbc3 !important;

        transition:
            background .2s ease,
            border-color .2s ease,
            color .2s ease,
            transform .2s ease !important;
    }

    .admin-nav-link:hover{
        background:rgba(255,255,255,.03) !important;
        border-color:rgba(255,255,255,.04) !important;
        color:#f8f4ed !important;
        transform:translateX(1px) !important;
    }

    .admin-nav-icon{
        width:36px !important;
        height:36px !important;
        flex:0 0 36px !important;

        display:flex !important;
        align-items:center !important;
        justify-content:center !important;

        border-radius:11px !important;

        color:#a9a39a !important;
        font-size:13px !important;
    }

    .admin-nav-text{
        min-width:0 !important;

        color:inherit !important;
        font-size:14.5px !important;
        font-weight:700 !important;
        line-height:1.3 !important;

        white-space:nowrap !important;
        overflow:hidden !important;
        text-overflow:ellipsis !important;
    }

    .admin-nav-link.active,
    .admin-nav-link[aria-current="page"]{
        border-color:rgba(226,201,151,.20) !important;

        background:
            linear-gradient(
                135deg,
                rgba(226,201,151,.095),
                rgba(226,201,151,.025)
            ) !important;

        color:#f8f4ed !important;
    }

    .admin-nav-link.active::before,
    .admin-nav-link[aria-current="page"]::before{
        content:"" !important;

        position:absolute !important;
        left:-1px !important;
        top:8px !important;
        bottom:8px !important;

        width:3px !important;

        border-radius:0 999px 999px 0 !important;

        background:#e2c997 !important;
        box-shadow:0 0 12px rgba(226,201,151,.22) !important;
    }

    .admin-nav-link.active .admin-nav-icon,
    .admin-nav-link[aria-current="page"] .admin-nav-icon{
        color:#e2c997 !important;
        background:rgba(226,201,151,.075) !important;
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

        display:flex !important;
        align-items:center !important;

        margin:0 0 6px !important;
        padding:0 10px !important;

        border:1px solid rgba(255,255,255,.045) !important;
        border-radius:10px !important;

        background:rgba(255,255,255,.022) !important;

        color:#a89988 !important;
        font-size:11px !important;
    }

    .admin-logout-button{
        min-height:43px !important;

        padding:0 9px !important;

        border-radius:10px !important;

        color:#bdb6ac !important;
        font-size:13.5px !important;
        font-weight:700 !important;
    }

    .admin-logout-button:hover{
        background:rgba(255,255,255,.025) !important;
        color:#f8f4ed !important;
    }

    .admin-sidebar-copyright{
        display:flex !important;
        align-items:center !important;
        justify-content:space-between !important;

        margin-top:5px !important;
        padding:8px 2px 0 !important;

        border-top:1px solid rgba(255,255,255,.045) !important;
    }

    .admin-sidebar-copyright small{
        color:#71695f !important;
        font-size:9px !important;
        line-height:1.2 !important;
    }

    .admin-sidebar-overlay,
    #adminSidebarOverlay,
    #sidebarOverlay{
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

    .admin-sidebar-overlay.show,
    .admin-sidebar-overlay.visible,
    #adminSidebarOverlay.show,
    #adminSidebarOverlay.visible,
    #sidebarOverlay.show,
    #sidebarOverlay.visible{
        opacity:1 !important;
        pointer-events:auto !important;
    }

    body.admin-sidebar-open,
    body.sidebar-open{
        overflow:hidden !important;
    }

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

    .admin-mobile-menu-button:hover{
        border-color:rgba(226,201,151,.40) !important;
        background:
            linear-gradient(
                145deg,
                rgba(226,201,151,.16),
                rgba(255,255,255,.04)
            ),
            rgba(18,18,18,.96) !important;
    }

    .admin-mobile-menu-button span{
        display:block !important;
        width:19px !important;
        height:2px !important;
        border-radius:999px !important;
        background:currentColor !important;
    }

    body.admin-sidebar-open .admin-mobile-menu-button,
    body.sidebar-open .admin-mobile-menu-button{
        opacity:0 !important;
        pointer-events:none !important;
        transform:translateY(-8px) !important;
    }
}

@media (max-width:600px){

    .admin-sidebar{
        top:10px !important;
        left:10px !important;
        bottom:10px !important;

        width:min(320px,calc(100vw - 20px)) !important;
        height:calc(100dvh - 20px) !important;
        max-height:calc(100dvh - 20px) !important;

        border-radius:18px !important;
    }

    .admin-sidebar-brand{
        min-height:78px !important;
        padding:16px 11px 12px !important;
    }

    .admin-brand-logo{
        width:44px !important;
        height:44px !important;
        flex-basis:44px !important;
    }

    .admin-brand-text strong{
        font-size:17px !important;
    }

    .admin-sidebar-user{
        margin:10px 11px 9px !important;
    }

    .admin-nav-title{
        margin-top:13px !important;
    }

    .admin-nav-link{
        min-height:49px !important;
    }

    .admin-mobile-menu-button{
        top:12px !important;
        left:12px !important;
        width:46px !important;
        height:46px !important;
    }
}

@media (max-width:380px){

    .admin-sidebar{
        top:8px !important;
        left:8px !important;
        bottom:8px !important;

        width:min(305px,calc(100vw - 16px)) !important;
        height:calc(100dvh - 16px) !important;
        max-height:calc(100dvh - 16px) !important;

        border-radius:16px !important;
    }

    .admin-sidebar-brand{
        padding-left:10px !important;
        padding-right:10px !important;
    }

    .admin-sidebar-user{
        margin-left:10px !important;
        margin-right:10px !important;
    }

    .admin-nav-link{
        min-height:47px !important;
    }

    .admin-nav-text{
        font-size:14px !important;
    }
}

@media (prefers-reduced-motion:reduce){

    .admin-sidebar,
    .admin-sidebar-overlay,
    #adminSidebarOverlay,
    #sidebarOverlay,
    .admin-mobile-menu-button,
    .admin-nav-link,
    .admin-sidebar-close-button{
        transition:none !important;
    }
}
</style>

</head>

<body>

<button type="button"
    class="admin-mobile-menu-button"
    id="openAdminSidebar"
    aria-label="Buka menu navigasi"
    aria-controls="adminSidebar"
    aria-expanded="false"
    title="Buka menu">
    <span></span><span></span><span></span>
</button>

@include('admin.partials.sidebar')

<main class="admin-oleholeh-page">
    <div class="admin-oleholeh-inner">

    <div style="margin-bottom:40px;">
<h1
            class="text-gradient"
            style="
                font-size:3rem;
                font-weight:800;
                margin:0;
            "
        >
            Edit Oleh-Oleh
        </h1>

        <p
            style="
                color:var(--text-secondary);
                margin-top:10px;
            "
        >
            Perbarui informasi produk oleh-oleh khas Blora.
        </p>

    </div>

    @if(session('success'))

        <div
            class="glass-effect"
            style="
                padding:20px;
                border-radius:20px;
                margin-bottom:25px;
                color:#90ee90;
            "
        >
            <i class="fas fa-check-circle"></i>
            &nbsp;
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div
            class="glass-effect"
            style="
                padding:20px;
                border-radius:20px;
                margin-bottom:25px;
                color:#F87171;
            "
        >
            <i class="fas fa-exclamation-circle"></i>
            &nbsp;
            {{ session('error') }}
        </div>

    @endif

    @if ($errors->any())

        <div
            class="glass-effect"
            style="
                padding:25px;
                border-radius:20px;
                margin-bottom:25px;
                border:1px solid #ef4444;
            "
        >

            <strong style="color:#ef4444;">
                <i class="fas fa-exclamation-circle"></i>
                &nbsp;
                Gagal Memproses Data
            </strong>

            <ul
                style="
                    margin-top:12px;
                    padding-left:20px;
                    color:var(--text-secondary);
                "
            >

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    <div
        class="glass-effect"
        style="
            padding:40px;
            border-radius:28px;
        "
    >

        <form
            action="{{ route(
                'admin.oleholeh.update',
                $olehOleh->id_oleh_oleh
            ) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <input
                type="hidden"
                name="status"
                value="{{ old('status', $olehOleh->status ?? 'Tersedia') }}"
            >

            @method('PUT')

            <div class="form-grid">

                <div>

                    <div style="margin-bottom:25px;">

                        <label
                            for="nama"
                            style="
                                display:block;
                                margin-bottom:10px;
                                color:var(--text-secondary);
                            "
                        >
                            Nama Oleh-Oleh
                            <span style="color:#ef4444;">*</span>
                        </label>

                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama', $olehOleh->nama) }}"
                            maxlength="255"
                            required
                            class="form-input @error('nama') is-invalid @enderror"
                        >

                    </div>

                    <div style="margin-bottom:25px;">

                        <label
                            for="deskripsi"
                            style="
                                display:block;
                                margin-bottom:10px;
                                color:var(--text-secondary);
                            "
                        >
                            Deskripsi
                        </label>

                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="6"
                            placeholder="Masukkan deskripsi produk..."
                            class="form-textarea @error('deskripsi') is-invalid @enderror"
                        >{{ old('deskripsi', $olehOleh->deskripsi) }}</textarea>

                        @error('deskripsi')
                            <span class="field-error">{{ $message }}</span>
                        @enderror

                    </div>

                    <div>

                        <label
                            for="gambarInput"
                            style="
                                display:block;
                                margin-bottom:10px;
                                color:var(--text-secondary);
                            "
                        >
                            Gambar Produk
                        </label>

                        <div
                            class="glass-effect"
                            style="
                                padding:25px;
                                border-radius:20px;
                                text-align:center;
                            "
                        >

                            <img
                                id="previewImage"
                                src="{{ $olehOleh->gambar_url }}"
                                alt="{{ $olehOleh->nama }}"
                                style="
                                    max-width:100%;
                                    max-height:250px;
                                    border-radius:20px;
                                    display:block;
                                    margin:0 auto 20px;
                                    object-fit:cover;
                                "
                            >

                            <input
                                type="file"
                                name="gambar"
                                id="gambarInput"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            >

                            <p
                                id="fileName"
                                style="
                                    margin-top:12px;
                                    color:var(--text-muted);
                                "
                            >
                                Pilih gambar baru jika ingin mengganti
                            </p>

                            <p
                                style="
                                    margin-top:5px;
                                    color:var(--text-muted);
                                    font-size:0.8rem;
                                "
                            >
                                Format: JPG, JPEG, PNG, WEBP
                            </p>

                        </div>

                    </div>

                </div>

                <div>

                    <div style="margin-bottom:25px;">

                        <label
                            for="jenis"
                            style="
                                display:block;
                                margin-bottom:10px;
                                color:var(--text-secondary);
                            "
                        >
                            Jenis Oleh-Oleh
                            <span style="color:#ef4444;">*</span>
                        </label>

                        <select
                            id="jenis"
                            name="jenis"
                            required
                            class="form-select @error('jenis') is-invalid @enderror"
                        >

                            <option value="">
                                Pilih Jenis
                            </option>

                            <option
                                value="Totebag"
                                @selected(old('jenis', $olehOleh->jenis) === 'Totebag')
                            >
                                Totebag
                            </option>

                            <option
                                value="Baju"
                                @selected(old('jenis', $olehOleh->jenis) === 'Baju')
                            >
                                Baju
                            </option>

                            <option
                                value="Celana"
                                @selected(old('jenis', $olehOleh->jenis) === 'Celana')
                            >
                                Celana
                            </option>

                            <option
                                value="Topi"
                                @selected(old('jenis', $olehOleh->jenis) === 'Topi')
                            >
                                Topi
                            </option>

                            <option
                                value="Gantungan Kunci"
                                @selected(old('jenis', $olehOleh->jenis) === 'Gantungan Kunci')
                            >
                                Gantungan Kunci
                            </option>

                            <option
                                value="Ikat Rambut"
                                @selected(old('jenis', $olehOleh->jenis) === 'Ikat Rambut')
                            >
                                Ikat Rambut
                            </option>

                            <option
                                value="Kacamata"
                                @selected(old('jenis', $olehOleh->jenis) === 'Kacamata')
                            >
                                Kacamata
                            </option>

                            <option
                                value="Daster"
                                @selected(old('jenis', $olehOleh->jenis) === 'Daster')
                            >
                                Daster
                            </option>

                            <option
                                value="Sandal"
                                @selected(old('jenis', $olehOleh->jenis) === 'Sandal')
                            >
                                Sandal
                            </option>

                            <option
                                value="Pajangan Tumbuhan"
                                @selected(old('jenis', $olehOleh->jenis) === 'Pajangan Tumbuhan')
                            >
                                Pajangan Tumbuhan
                            </option>

                            <option
                                value="Barongan"
                                @selected(old('jenis', $olehOleh->jenis) === 'Barongan')
                            >
                                Barongan
                            </option>

                        </select>

                        @error('jenis')
                            <span class="field-error">{{ $message }}</span>
                        @enderror

                    </div>

                    <div style="margin-bottom:25px;">

                        <label
                            for="harga"
                            style="
                                display:block;
                                margin-bottom:10px;
                                color:var(--text-secondary);
                            "
                        >
                            Harga
                            <span style="color:#ef4444;">*</span>
                        </label>

                        <div style="position:relative;">

                            <span
                                style="
                                    position:absolute;
                                    left:18px;
                                    top:50%;
                                    transform:translateY(-50%);
                                    color:var(--text-muted);
                                    font-weight:600;
                                "
                            >
                                Rp
                            </span>

                            <input
                                type="text"
                                id="harga"
                                name="harga"
                                inputmode="numeric"
                                autocomplete="off"
                                maxlength="7"
                                value="{{ old('harga', $olehOleh->harga) }}"
                                placeholder="10.000"
                                required
                                class="form-input price-input @error('harga') is-invalid @enderror"
                            >

                        </div>

                        @error('harga')
                            <span class="field-error">{{ $message }}</span>
                        @enderror

                    </div>

                    <div style="margin-bottom:25px;">

                        <label
                            for="stok"
                            style="
                                display:block;
                                margin-bottom:10px;
                                color:var(--text-secondary);
                            "
                        >
                            Stok Produk
                        </label>

                        <input
                            type="number"
                            id="stok"
                            value="{{ $olehOleh->stok }}"
                            min="0"
                            disabled
                            class="form-input stock-readonly"
                        >

                        <small
                            style="
                                color:var(--text-muted);
                                display:block;
                                margin-top:10px;
                                line-height:1.5;
                            "
                        >
                            <i class="fas fa-lock"></i>
                            &nbsp;
                            Stok tidak dapat diubah oleh Admin.
                            Pengelolaan stok dilakukan oleh Kasir Oleh-Oleh.
                        </small>

                    </div>

                    <div
                        class="glass-effect"
                        style="
                            padding:20px;
                            border-radius:18px;
                            margin-bottom:30px;
                        "
                    >

                        <div
                            style="
                                display:flex;
                                align-items:center;
                                gap:12px;
                            "
                        >

                            @if($olehOleh->status === 'Tersedia')

                                <i
                                    class="fas fa-check-circle"
                                    style="
                                        color:#6EE7B7;
                                        font-size:1.3rem;
                                    "
                                ></i>

                                <div>

                                    <strong>
                                        Tersedia
                                    </strong>

                                    <p
                                        style="
                                            margin-top:4px;
                                            color:var(--text-muted);
                                            font-size:0.85rem;
                                        "
                                    >
                                        Produk sedang tersedia.
                                    </p>

                                </div>

                            @else

                                <i
                                    class="fas fa-times-circle"
                                    style="
                                        color:#F87171;
                                        font-size:1.3rem;
                                    "
                                ></i>

                                <div>

                                    <strong>
                                        Tidak Tersedia
                                    </strong>

                                    <p
                                        style="
                                            margin-top:4px;
                                            color:var(--text-muted);
                                            font-size:0.85rem;
                                        "
                                    >
                                        Produk sedang tidak tersedia.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>

                    <div class="edit-form-actions">

                        <button
                            type="submit"
                            class="btn-primary-travel"
                        >
                            <i class="fas fa-pen-to-square"></i>
                            &nbsp;
                            Update Oleh-Oleh
                        </button>

                        <a
                            href="{{ route('admin.oleholeh.index') }}"
                            class="btn-secondary-travel"
                        >
                            <i class="fas fa-arrow-left"></i>
                            &nbsp;
                            Kembali
                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const gambarInput = document.getElementById('gambarInput');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const hargaInput = document.getElementById('harga');
    const editForm = hargaInput ? hargaInput.closest('form') : null;
    const gambarAwal = @json($olehOleh->gambar_url);
    const namaGambarAwal = 'Pilih gambar baru jika ingin mengganti';
    const tipeGambarDiizinkan = ['image/jpeg', 'image/png', 'image/webp'];
    const ukuranMaksimalGambar = 2 * 1024 * 1024;

    function formatRupiah(value) {
        const digits = String(value || '').replace(/\D/g, '');
        return digits ? digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
    }

    function numericPrice(value) {
        return Number(String(value || '').replace(/\D/g, '')) || 0;
    }

    if (hargaInput) {
        hargaInput.value = formatRupiah(hargaInput.value);

        hargaInput.addEventListener('input', function () {
            let digits = this.value.replace(/\D/g, '').replace(/^0+(?=\d)/, '');

            if (digits && Number(digits) > 100000) {
                digits = '100000';
            }

            this.value = formatRupiah(digits);
            this.setCustomValidity('');
        });

        hargaInput.addEventListener('blur', function () {
            const value = numericPrice(this.value);

            if (!value) {
                this.setCustomValidity('Harga wajib diisi.');
            } else if (value < 10000) {
                this.setCustomValidity('Harga minimal Rp10.000.');
            } else if (value > 100000) {
                this.setCustomValidity('Harga maksimal Rp100.000.');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    if (editForm && hargaInput) {
        editForm.addEventListener('submit', function (event) {
            const value = numericPrice(hargaInput.value);

            if (value < 10000 || value > 100000) {
                event.preventDefault();
                hargaInput.setCustomValidity('Harga harus antara Rp10.000 dan Rp100.000.');
                hargaInput.reportValidity();
                hargaInput.focus();
                return;
            }

            hargaInput.setCustomValidity('');
            hargaInput.value = String(value);
        });
    }

    if (gambarInput && previewImage && fileName) {
        gambarInput.addEventListener('change', function (event) {
            const file = event.target.files && event.target.files[0];

            if (!file) {
                previewImage.src = gambarAwal;
                fileName.textContent = namaGambarAwal;
                return;
            }

            if (!tipeGambarDiizinkan.includes(file.type)) {
                gambarInput.value = '';
                previewImage.src = gambarAwal;
                fileName.textContent = 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WEBP.';
                return;
            }

            if (file.size > ukuranMaksimalGambar) {
                gambarInput.value = '';
                previewImage.src = gambarAwal;
                fileName.textContent = 'Ukuran gambar maksimal 2 MB.';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (readerEvent) {
                if (typeof readerEvent.target.result === 'string') {
                    previewImage.src = readerEvent.target.result;
                    previewImage.style.display = 'block';
                    fileName.textContent = file.name;
                }
            };

            reader.onerror = function () {
                gambarInput.value = '';
                previewImage.src = gambarAwal;
                fileName.textContent = 'Gambar gagal dibaca. Silakan pilih file lain.';
            };

            reader.readAsDataURL(file);
        });
    }
});
</script>

<style>

    * {
        box-sizing: border-box;
    }

    html,
    body {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .admin-oleholeh-page {
        width: calc(100% - 280px);
        max-width: none;
        min-height: 100vh;

        margin-left: 280px;
        padding: 42px 42px 55px;

        overflow-x: hidden;
    }

    .admin-oleholeh-inner {
        width: 100%;
        max-width: 1280px;

        margin: 0 auto;
    }

    .form-grid {
        display: grid;

        grid-template-columns:
            minmax(0, 1.08fr)
            minmax(0, .92fr);

        gap: clamp(22px, 3vw, 42px);

        width: 100%;
    }

    .form-grid > div {
        min-width: 0;
    }

    .form-input,
    .form-select,
    .form-textarea {
        display: block;

        width: 100%;
        max-width: 100%;

        box-sizing: border-box;
    }

    .form-input,
    .form-select {
        min-height: 54px;
    }

    .form-textarea {
        min-height: 180px;
        resize: vertical;
    }

    .price-input {
        padding-left: 55px !important;
    }

    .stock-readonly {
        opacity: .75;
        cursor: not-allowed;
    }

    .form-input.is-invalid,
    .form-select.is-invalid,
    .form-textarea.is-invalid {
        border-color: #ef4444 !important;
    }

    .field-error {
        display: block;
        margin-top: 7px;
        color: #ef6a6a;
        font-size: .8rem;
        line-height: 1.5;
    }

    #previewImage {
        display: block;
        width: 100%;
        max-width: 100%;
        max-height: 250px;
        object-fit: cover;
    }

    #gambarInput {
        width: 100%;
        max-width: 100%;
    }

    .edit-form-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    @media (max-width: 1200px) {

        .admin-oleholeh-page {
            width: calc(100% - 250px);
            margin-left: 250px;

            padding-left: 28px;
            padding-right: 28px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 5px;
        }
    }

    @media (max-width: 900px) {

        .admin-oleholeh-page {
            width: 100%;
            margin-left: 0;

            padding: 30px 22px 45px;
        }

        .admin-oleholeh-inner {
            max-width: 760px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {

        .admin-oleholeh-page {
            padding: 22px 14px 35px;
        }

        .form-grid {
            gap: 0;
        }

        .edit-form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .edit-form-actions > * {
            width: 100%;
        }

        #previewImage {
            max-height: 200px;
        }
    }
</style>

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
    --white:#fff;
    --black:#000;
    --shadow-soft:0 20px 60px rgba(0,0,0,.4);
    --shadow-hover:0 25px 70px rgba(0,0,0,.5);
    --radius-lg:28px;
    --radius-md:16px;
    --radius-full:999px;
    --transition:.25s cubic-bezier(.4,0,.2,1);
}

*{box-sizing:border-box}
html{scroll-behavior:smooth}
body{
    width:100%; min-height:100vh; overflow-x:hidden;
    margin:0; background:
    radial-gradient(circle at 88% 4%,rgba(226,201,151,.055),transparent 30%),
    radial-gradient(circle at 4% 96%,rgba(226,201,151,.025),transparent 28%),
    var(--bg-primary);
    color:var(--text-primary);
    font-family:'Inter',sans-serif;
    line-height:1.65;
}
button,input,select,textarea{font:inherit}
a{text-decoration:none;color:inherit}
::selection{background:rgba(226,201,151,.25);color:var(--text-primary)}

.admin-oleholeh-page{
    width:calc(100% - 270px)!important;
    min-height:100vh;
    margin-left:270px!important;
    padding:48px 46px 64px!important;
    overflow-x:hidden;
}
.admin-oleholeh-inner{
    width:100%;
    max-width:1320px;
    margin:0 auto;
}
.admin-oleholeh-page > .admin-oleholeh-inner > div:first-child{
    margin-bottom:30px!important;
}

.admin-oleholeh-page h1{
    margin:0!important;
    font-family:'Playfair Display','Inter',serif!important;
    font-size:clamp(38px,4vw,58px)!important;
    font-weight:700!important;
    line-height:1.12!important;
    letter-spacing:-.7px!important;
    background:linear-gradient(135deg,var(--accent) 0%,#f8f4ed 50%,var(--accent-dark) 100%)!important;
    -webkit-background-clip:text!important;
    -webkit-text-fill-color:transparent!important;
    background-clip:text!important;
}
.admin-oleholeh-page h1 + p{
    color:var(--text-muted)!important;
    margin:11px 0 0!important;
    font-size:16px!important;
    line-height:1.7!important;
}

.admin-oleholeh-page .glass-effect{
    background:linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.012)),var(--bg-card)!important;
    border:1px solid var(--border-soft)!important;
    box-shadow:var(--shadow-soft)!important;
    backdrop-filter:blur(18px);
}
.admin-oleholeh-page form > .form-grid,
.admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect{
    border-radius:var(--radius-lg)!important;
}
.admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect{
    padding:clamp(28px,3vw,40px)!important;
}

.form-grid{
    display:grid!important;
    grid-template-columns:minmax(0,1.08fr) minmax(0,.92fr)!important;
    gap:clamp(26px,3vw,42px)!important;
    width:100%;
}
.form-grid > div{min-width:0}
.form-grid label{
    display:block!important;
    margin:0 0 9px!important;
    color:var(--text-secondary)!important;
    font-size:15px!important;
    font-weight:700!important;
}
.form-grid label span{color:var(--accent)!important}
.form-input,.form-select,.form-textarea{
    display:block!important;
    width:100%!important;
    max-width:100%!important;
    color:var(--text-primary)!important;
    background:rgba(255,255,255,.035)!important;
    border:1px solid var(--border-soft)!important;
    border-radius:var(--radius-md)!important;
    outline:none!important;
    font-family:'Inter',sans-serif!important;
    font-size:15px!important;
    transition:all var(--transition)!important;
}
.form-input,.form-select{min-height:58px!important;padding:14px 17px!important}
.form-textarea{min-height:190px!important;padding:15px 17px!important;line-height:1.7!important;resize:vertical}
.form-input::placeholder,.form-textarea::placeholder{color:var(--text-dim)!important}
.form-input:hover,.form-select:hover,.form-textarea:hover{
    border-color:rgba(226,201,151,.24)!important;
    background:rgba(255,255,255,.045)!important;
}
.form-input:focus,.form-select:focus,.form-textarea:focus{
    border-color:rgba(226,201,151,.58)!important;
    background:rgba(226,201,151,.045)!important;
    box-shadow:0 0 0 3px rgba(226,201,151,.075)!important;
}
.form-input.is-invalid,.form-select.is-invalid,.form-textarea.is-invalid{
    border-color:rgba(239,110,110,.68)!important;
}
.field-error{
    display:block!important;
    margin:7px 0 0!important;
    color:#ffaaaa!important;
    font-size:13px!important;
    line-height:1.55!important;
}

.price-input{padding-left:55px!important}
.form-grid > div:nth-child(2) > div:nth-child(2) > div{
    position:relative;
}
.form-grid > div:nth-child(2) > div:nth-child(2) > div > span{
    color:var(--accent)!important;
    font-size:15px!important;
    font-weight:700!important;
}
.form-grid > div:nth-child(2) > div:nth-child(2)::after{
    content:'Harga minimal Rp10.000 dan maksimal Rp100.000. Contoh: 25.000';
    display:block;
    margin-top:8px;
    color:var(--text-dim);
    font-size:13px;
    line-height:1.5;
}

.form-grid > div:first-child > div:nth-child(3) .glass-effect{
    background:linear-gradient(145deg,rgba(226,201,151,.045),rgba(255,255,255,.018))!important;
    border:1px dashed rgba(226,201,151,.26)!important;
    box-shadow:none!important;
}

.form-grid > div:nth-child(2) > div:nth-child(4) .glass-effect{
    background:rgba(255,255,255,.035)!important;
    border:1px solid var(--border-soft)!important;
    box-shadow:none!important;
}
#previewImage{
    width:100%!important;
    max-width:100%!important;
    height:250px!important;
    max-height:250px!important;
    object-fit:cover!important;
    border-radius:14px!important;
    border:1px solid var(--border-soft)!important;
}
#fileName{
    color:var(--text-muted)!important;
    font-size:14px!important;
    line-height:1.5!important;
}
#gambarInput{
    width:100%;
    color:var(--text-secondary);
    font-size:14px;
}
#gambarInput::file-selector-button{
    margin-right:10px;
    padding:12px 16px;
    color:var(--bg-primary);
    background:linear-gradient(135deg,var(--accent),var(--accent-hover));
    border:0;
    border-radius:var(--radius-full);
    font-size:14px;
    font-weight:800;
    cursor:pointer;
}
.stock-readonly{
    opacity:.72!important;
    cursor:not-allowed!important;
}

.form-grid .glass-effect strong{
    color:var(--text-primary);
    font-size:15px;
}
.form-grid .glass-effect p{
    color:var(--text-muted)!important;
    font-size:14px!important;
    line-height:1.65!important;
}
.form-grid .glass-effect i{
    color:var(--accent)!important;
}

.edit-form-actions{
    display:flex!important;
    align-items:center!important;
    justify-content:flex-end!important;
    gap:12px!important;
    margin-top:10px!important;
    padding-top:24px!important;
    border-top:1px solid var(--border-soft)!important;
    flex-wrap:wrap!important;
}
.btn-primary-travel,.btn-secondary-travel{
    min-height:56px!important;
    display:inline-flex!important;
    align-items:center!important;
    justify-content:center!important;
    gap:8px!important;
    padding:0 25px!important;
    border-radius:var(--radius-full)!important;
    font-family:'Inter',sans-serif!important;
    font-size:15px!important;
    font-weight:800!important;
    cursor:pointer!important;
    transition:all var(--transition)!important;
}
.btn-primary-travel{
    color:var(--bg-primary)!important;
    background:linear-gradient(135deg,var(--accent),var(--accent-hover))!important;
    border:1px solid var(--accent)!important;
    box-shadow:0 10px 28px rgba(0,0,0,.22)!important;
}
.btn-primary-travel:hover{
    background:linear-gradient(135deg,var(--accent-hover),var(--accent-dark))!important;
    transform:translateY(-3px)!important;
    box-shadow:var(--shadow-hover)!important;
}
.btn-secondary-travel{
    color:var(--text-secondary)!important;
    background:rgba(255,255,255,.035)!important;
    border:1px solid var(--border-soft)!important;
}
.btn-secondary-travel:hover{
    background:rgba(226,201,151,.08)!important;
    border-color:var(--border-gold)!important;
    color:var(--accent)!important;
    transform:translateY(-2px)!important;
}

.admin-mobile-menu-button{
    display:none;
    position:fixed;
    top:18px;
    left:18px;
    z-index:1200;
    width:52px;height:52px;
    align-items:center;justify-content:center;
    flex-direction:column;gap:5px;
    padding:0;
    border:1px solid rgba(226,201,151,.27);
    border-radius:14px;
    background:rgba(18,18,18,.96);
    color:var(--accent);
    box-shadow:0 14px 35px rgba(0,0,0,.4);
    backdrop-filter:blur(16px);
    cursor:pointer;
}
.admin-mobile-menu-button span{
    display:block;width:24px;height:2px;border-radius:999px;background:var(--accent);
}
.admin-mobile-menu-button:hover{
    border-color:rgba(226,201,151,.48);
    background:rgba(226,201,151,.09);
}
:focus-visible{outline:2px solid rgba(226,201,151,.78);outline-offset:3px}

@media (min-width:1101px) and (max-width:1399px){
    .admin-oleholeh-page{
        padding:46px 40px 62px!important;
    }
    .admin-oleholeh-page h1{font-size:46px!important}
}
@media (min-width:1400px){
    .admin-oleholeh-page{
        margin-left:285px!important;
        width:calc(100% - 285px)!important;
        padding:54px 58px 72px!important;
    }
}

@media (min-width:601px) and (max-width:1100px){
    .admin-mobile-menu-button{display:flex}
    .admin-oleholeh-page{
        width:100%!important;
        margin-left:0!important;
        padding:92px 28px 54px!important;
    }
    .admin-oleholeh-inner{max-width:850px}
    .form-grid{
        grid-template-columns:1fr!important;
        gap:0!important;
    }
    .admin-oleholeh-page h1{font-size:44px!important}
}

@media (max-width:600px){
    .admin-mobile-menu-button{
        display:flex;
        top:14px;left:14px;
        width:48px;height:48px;
    }
    .admin-oleholeh-page{
        width:100%!important;
        margin-left:0!important;
        padding:78px 15px 36px!important;
    }
    .admin-oleholeh-page > .admin-oleholeh-inner > div:first-child{
        margin-bottom:26px!important;
    }
    .admin-oleholeh-page h1{
        font-size:38px!important;
        letter-spacing:-.4px!important;
    }
    .admin-oleholeh-page h1 + p{
        font-size:15px!important;
        margin-top:9px!important;
    }
    .admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect{
        padding:24px 19px!important;
        border-radius:22px!important;
    }
    .form-grid{gap:0!important}
    .form-grid label{font-size:15px!important}
    .form-input,.form-select{min-height:56px!important;font-size:15px!important}
    .form-textarea{min-height:155px!important;font-size:15px!important}
    #previewImage{height:210px!important;max-height:210px!important}
    .edit-form-actions{
        flex-direction:column-reverse!important;
        align-items:stretch!important;
    }
    .edit-form-actions > *{
        width:100%!important;
        min-height:54px!important;
        font-size:15px!important;
    }
}
@media (max-width:380px){
    .admin-oleholeh-page{padding-left:12px!important;padding-right:12px!important}
    .admin-oleholeh-page h1{font-size:34px!important}
    .admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect{padding:21px 16px!important}
}
@media (prefers-reduced-motion:reduce){
    *,*::before,*::after{scroll-behavior:auto!important;transition:none!important;animation:none!important}
}
</style>

<style>

.admin-oleholeh-page h1{
    font-family:'Playfair Display','Inter',serif!important;
    font-size:clamp(38px,4vw,58px)!important;
    font-weight:700!important;
    line-height:1.12!important;
    letter-spacing:-.7px!important;
}

.admin-oleholeh-page h1 + p{
    font-size:16px!important;
    line-height:1.7!important;
    margin:11px 0 0!important;
    color:var(--text-muted)!important;
}

.admin-oleholeh-page > .admin-oleholeh-inner > div:first-child{
    margin-bottom:30px!important;
}

.form-grid label{
    font-size:15px!important;
    font-weight:700!important;
    line-height:1.45!important;
    margin-bottom:9px!important;
}

.form-input,
.form-select,
.form-textarea{
    font-size:15px!important;
    border-radius:16px!important;
}

.form-input,
.form-select{
    min-height:58px!important;
    padding:14px 17px!important;
}

.form-textarea{
    min-height:190px!important;
    padding:15px 17px!important;
    font-size:15px!important;
    line-height:1.7!important;
}

.price-input{
    padding-left:50px!important;
    font-size:15px!important;
    font-weight:500!important;
    letter-spacing:.1px;
}

.form-grid > div:nth-child(2) > div:nth-child(2) > div > span{
    left:17px!important;
    color:var(--accent)!important;
    font-size:15px!important;
    font-weight:700!important;
}

.form-grid > div:nth-child(2) > div:nth-child(2)::after{
    content:'Harga minimal Rp10.000 dan maksimal Rp100.000. Contoh: 25.000';
    display:block;
    margin-top:8px;
    color:var(--text-dim);
    font-size:13px;
    line-height:1.5;
}

#previewImage{
    width:100%!important;
    height:230px!important;
    max-height:230px!important;
    object-fit:cover!important;
    border-radius:14px!important;
    border:1px solid var(--border-soft)!important;
}

#gambarInput{
    width:100%!important;
    color:var(--text-secondary)!important;
    font-family:'Inter',sans-serif!important;
    font-size:14px!important;
}

#gambarInput::file-selector-button{
    margin-right:10px!important;
    padding:12px 16px!important;
    color:var(--bg-primary)!important;
    background:linear-gradient(135deg,var(--accent),var(--accent-hover))!important;
    border:0!important;
    border-radius:var(--radius-full)!important;
    font-family:'Inter',sans-serif!important;
    font-size:14px!important;
    font-weight:800!important;
}

#fileName{
    min-height:20px!important;
    margin:12px 0 0!important;
    color:var(--text-muted)!important;
    font-size:14px!important;
    line-height:1.5!important;
}

.form-grid .glass-effect strong{
    color:var(--text-primary)!important;
    font-size:15px!important;
    font-weight:800!important;
}

.form-grid .glass-effect p{
    color:var(--text-muted)!important;
    font-size:14px!important;
    line-height:1.65!important;
}

.edit-form-actions{
    margin-top:10px!important;
    padding-top:24px!important;
    border-top:1px solid var(--border-soft)!important;
    gap:12px!important;
}

.btn-primary-travel,
.btn-secondary-travel{
    min-height:56px!important;
    padding:0 25px!important;
    border-radius:var(--radius-full)!important;
    font-size:15px!important;
    font-weight:800!important;
}

.btn-primary-travel{
    color:var(--bg-primary)!important;
    background:linear-gradient(135deg,var(--accent),var(--accent-hover))!important;
    border:1px solid var(--accent)!important;
}

.btn-secondary-travel{
    color:var(--text-secondary)!important;
    background:rgba(255,255,255,.035)!important;
    border:1px solid var(--border-soft)!important;
}

@media (min-width:1400px){
    .admin-oleholeh-page{
        margin-left:285px!important;
        width:calc(100% - 285px)!important;
        padding:54px 58px 72px!important;
    }

    .admin-oleholeh-page h1{
        font-size:58px!important;
    }

    .form-grid{
        gap:42px!important;
    }
}

@media (min-width:1101px) and (max-width:1399px){
    .admin-oleholeh-page{
        padding:46px 40px 62px!important;
    }

    .admin-oleholeh-page h1{
        font-size:46px!important;
    }
}

@media (min-width:601px) and (max-width:1100px){
    .admin-mobile-menu-button{
        display:flex!important;
    }

    .admin-oleholeh-page{
        width:100%!important;
        margin-left:0!important;
        padding:92px 28px 54px!important;
    }

    .admin-oleholeh-inner{
        max-width:850px!important;
    }

    .form-grid{
        grid-template-columns:1fr!important;
        gap:0!important;
    }

    .admin-oleholeh-page h1{
        font-size:44px!important;
    }

    .form-card,
    .admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect{
        padding:30px 26px!important;
    }
}

@media (max-width:600px){
    .admin-mobile-menu-button{
        display:flex!important;
        top:14px!important;
        left:14px!important;
        width:48px!important;
        height:48px!important;
    }

    .admin-oleholeh-page{
        width:100%!important;
        margin-left:0!important;
        padding:78px 15px 36px!important;
    }

    .admin-oleholeh-page > .admin-oleholeh-inner > div:first-child{
        margin-bottom:26px!important;
    }

    .admin-oleholeh-page h1{
        font-size:38px!important;
        letter-spacing:-.4px!important;
    }

    .admin-oleholeh-page h1 + p{
        margin-top:8px!important;
        font-size:14px!important;
        line-height:1.7!important;
    }

    .admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect{
        padding:24px 19px!important;
        border-radius:22px!important;
    }

    .form-grid{
        gap:0!important;
    }

    .form-grid label{
        font-size:15px!important;
    }

    .form-input,
    .form-select{
        min-height:56px!important;
        font-size:15px!important;
    }

    .form-textarea{
        min-height:155px!important;
        font-size:15px!important;
    }

    #previewImage{
        height:210px!important;
        max-height:210px!important;
    }

    .edit-form-actions{
        flex-direction:column-reverse!important;
        align-items:stretch!important;
    }

    .edit-form-actions > *{
        width:100%!important;
    }

    .btn-primary-travel,
    .btn-secondary-travel{
        width:100%!important;
        min-height:54px!important;
        font-size:15px!important;
    }
}

@media (max-width:380px){
    .admin-oleholeh-page{
        padding-left:12px!important;
        padding-right:12px!important;
    }

    .admin-oleholeh-page h1{
        font-size:34px!important;
    }

    .admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect{
        padding:21px 16px!important;
    }
}
</style>

<style>

.admin-oleholeh-page{
    min-height:100vh;
    overflow-x:hidden;
}

.admin-oleholeh-inner{
    width:100%;
    max-width:1320px;
    margin:0 auto;
}

.admin-oleholeh-page h1,
.page-title{
    font-family:'Playfair Display','Inter',serif !important;
    font-size:clamp(38px,4vw,58px) !important;
    font-weight:700 !important;
    line-height:1.12 !important;
    letter-spacing:-.7px !important;
}

.admin-oleholeh-page h1 + p,
.page-description{
    font-size:16px !important;
    line-height:1.7 !important;
    color:var(--text-muted) !important;
}

.admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect,
.admin-oleholeh-page .form-card{
    width:100%;
    padding:clamp(28px,3vw,40px) !important;
    border:1px solid var(--border-soft) !important;
    border-radius:var(--radius-lg) !important;
    background:linear-gradient(145deg,rgba(255,255,255,.035),rgba(255,255,255,.012)),var(--bg-card) !important;
    box-shadow:var(--shadow-soft) !important;
    backdrop-filter:blur(18px);
}

.form-grid{
    display:grid !important;
    grid-template-columns:minmax(0,1.08fr) minmax(0,.92fr) !important;
    gap:clamp(26px,3vw,42px) !important;
    width:100%;
}

.form-grid > div{min-width:0}

.form-grid label,
.form-label{
    display:block;
    margin-bottom:9px !important;
    color:var(--text-secondary) !important;
    font-size:15px !important;
    font-weight:700 !important;
    line-height:1.5 !important;
}

.form-input,
.form-select,
.form-textarea{
    display:block;
    width:100% !important;
    max-width:100%;
    color:var(--text-primary) !important;
    background:rgba(255,255,255,.035) !important;
    border:1px solid var(--border-soft) !important;
    border-radius:var(--radius-md) !important;
    outline:none;
    font-family:'Inter',sans-serif !important;
    font-size:15px !important;
    transition:all var(--transition);
}

.form-input,
.form-select{
    min-height:58px !important;
    height:58px;
    padding:14px 17px !important;
}

.form-textarea{
    min-height:190px !important;
    padding:15px 17px !important;
    line-height:1.7 !important;
    resize:vertical;
}

.form-input::placeholder,
.form-textarea::placeholder{color:var(--text-dim) !important}

.form-input:hover,
.form-select:hover,
.form-textarea:hover{
    border-color:rgba(226,201,151,.24) !important;
    background:rgba(255,255,255,.045) !important;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus{
    border-color:rgba(226,201,151,.58) !important;
    background:rgba(226,201,151,.045) !important;
    box-shadow:0 0 0 3px rgba(226,201,151,.075) !important;
}

.price-input{
    padding-left:55px !important;
    font-variant-numeric:tabular-nums;
    letter-spacing:.15px;
}

.form-grid > div:nth-child(2) > div:nth-child(2) > div:first-child{
    color:var(--accent) !important;
    font-size:15px !important;
    font-weight:700 !important;
}

.field-error{
    display:block;
    margin-top:7px !important;
    color:#ffaaaa !important;
    font-size:13px !important;
    line-height:1.55 !important;
}

.form-grid #gambarInput{
    width:100%;
    max-width:100%;
    color:var(--text-secondary);
    font-size:14px;
}

.form-grid #gambarInput::file-selector-button{
    margin-right:10px;
    padding:12px 16px;
    color:var(--bg-primary);
    background:linear-gradient(135deg,var(--accent),var(--accent-hover));
    border:0;
    border-radius:var(--radius-full);
    font-family:'Inter',sans-serif;
    font-size:14px;
    font-weight:800;
    cursor:pointer;
}

#previewImage{
    width:100% !important;
    max-width:100% !important;
    height:230px !important;
    max-height:230px !important;
    object-fit:cover !important;
    border-radius:14px !important;
    border:1px solid var(--border-soft) !important;
}

.edit-form-actions{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:12px !important;
    margin-top:10px;
    padding-top:24px;
    border-top:1px solid var(--border-soft);
    flex-wrap:wrap;
}

.edit-form-actions .btn-primary-travel,
.edit-form-actions .btn-secondary-travel{
    min-height:56px !important;
    padding:0 25px !important;
    border-radius:var(--radius-full) !important;
    font-family:'Inter',sans-serif !important;
    font-size:15px !important;
    font-weight:800 !important;
}

@media (min-width:1400px){
    .admin-oleholeh-page{
        margin-left:285px !important;
        width:calc(100% - 285px) !important;
        padding:54px 58px 72px !important;
    }
    .admin-oleholeh-inner{max-width:1320px}
}

@media (min-width:1101px) and (max-width:1399px){
    .admin-oleholeh-page{
        margin-left:270px !important;
        width:calc(100% - 270px) !important;
        padding:46px 40px 62px !important;
    }
    .admin-oleholeh-inner{max-width:1200px}
    .form-grid{gap:30px !important}
}

@media (min-width:601px) and (max-width:1100px){
    .admin-mobile-menu-button{display:flex !important}

    .admin-oleholeh-page{
        width:100% !important;
        margin-left:0 !important;
        padding:94px 28px 56px !important;
    }

    .admin-oleholeh-inner{max-width:850px}

    .admin-oleholeh-page h1,
    .page-title{
        font-size:44px !important;
    }

    .admin-oleholeh-page h1 + p,
    .page-description{
        font-size:16px !important;
    }

    .form-grid{
        grid-template-columns:1fr !important;
        gap:0 !important;
    }

    .form-grid > div{width:100%}

    .form-input,
    .form-select{
        min-height:58px !important;
        height:58px !important;
    }

    .form-textarea{min-height:190px !important}

    .edit-form-actions{
        justify-content:flex-end;
    }
}

@media (max-width:600px){
    .admin-mobile-menu-button{
        display:flex !important;
        top:14px !important;
        left:14px !important;
        width:50px !important;
        height:50px !important;
        border-radius:14px !important;
    }

    .admin-mobile-menu-button span{
        width:23px !important;
        height:2px !important;
    }

    .admin-oleholeh-page{
        width:100% !important;
        margin-left:0 !important;
        padding:82px 15px 40px !important;
    }

    .admin-oleholeh-inner{max-width:760px}

    .admin-oleholeh-page > .admin-oleholeh-inner > div:first-child{
        margin-bottom:27px !important;
    }

    .admin-oleholeh-page h1,
    .page-title{
        font-size:38px !important;
        line-height:1.15 !important;
        letter-spacing:-.4px !important;
    }

    .admin-oleholeh-page h1 + p,
    .page-description{
        margin-top:9px !important;
        font-size:15px !important;
        line-height:1.7 !important;
    }

    .admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect,
    .admin-oleholeh-page .form-card{
        padding:24px 19px !important;
        border-radius:22px !important;
    }

    .form-grid{
        grid-template-columns:1fr !important;
        gap:0 !important;
    }

    .form-grid label,
    .form-label{
        font-size:15px !important;
        margin-bottom:9px !important;
    }

    .form-input,
    .form-select{
        min-height:56px !important;
        height:56px !important;
        font-size:15px !important;
        padding:13px 16px !important;
    }

    .form-textarea{
        min-height:160px !important;
        font-size:15px !important;
    }

    .price-input{padding-left:53px !important}

    #previewImage{
        height:210px !important;
        max-height:210px !important;
    }

    .edit-form-actions{
        flex-direction:column-reverse !important;
        align-items:stretch !important;
        gap:10px !important;
    }

    .edit-form-actions > *{
        width:100% !important;
        min-height:54px !important;
        font-size:15px !important;
    }
}

@media (max-width:380px){
    .admin-oleholeh-page{
        padding-left:12px !important;
        padding-right:12px !important;
    }

    .admin-oleholeh-page h1,
    .page-title{
        font-size:34px !important;
    }

    .admin-oleholeh-page h1 + p,
    .page-description{
        font-size:14px !important;
    }

    .admin-oleholeh-page > .admin-oleholeh-inner > .glass-effect,
    .admin-oleholeh-page .form-card{
        padding:21px 16px !important;
    }
}

@media (prefers-reduced-motion:reduce){
    *,*::before,*::after{
        scroll-behavior:auto !important;
        transition:none !important;
        animation:none !important;
    }
}
</style>

</body>
</html>