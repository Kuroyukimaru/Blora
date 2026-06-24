<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Paket Bundling</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

@include('admin.partials.sidebar')

<div class="container-custom"
     style="margin-left:320px;padding:50px 30px;">

    <div style="margin-bottom:40px;">

        <p style="
            color:var(--text-muted);
            letter-spacing:2px;
            text-transform:uppercase;
        ">
            ADMIN PANEL / PAKET BUNDLING
        </p>

        <h1 class="text-gradient"
            style="
                font-size:3rem;
                font-weight:800;
            ">
            Tambah Paket Bundling
        </h1>

        <p style="
            color:var(--text-secondary);
            margin-top:10px;
        ">
            Buat kombinasi menu dan wahana untuk wisatawan.
        </p>

    </div>

    @if ($errors->any())

        <div class="glass-effect"
             style="
                padding:20px;
                border-radius:20px;
                margin-bottom:25px;
                border-color:#ef4444;
             ">

            <strong style="color:#ef4444;">
                Terjadi Kesalahan
            </strong>

            <ul style="margin-top:10px;">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="glass-effect"
         style="
            padding:40px;
            border-radius:28px;
         ">

        <form
            action="{{ route('admin.paketbundling.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:40px;
            ">

                {{-- KIRI --}}
                <div>

                    <div style="margin-bottom:25px;">

                        <label>Nama Paket</label>

                        <input
                            type="text"
                            name="nama_paket"
                            value="{{ old('nama_paket') }}"
                            required
                            style="
                                width:100%;
                                margin-top:10px;
                                padding:15px;
                                border-radius:16px;
                                background:var(--bg-soft);
                                border:1px solid var(--border-gold);
                                color:var(--text-primary);
                            "
                        >

                    </div>

                    <div style="margin-bottom:25px;">

                        <label>Untuk</label>

                        <select
                            name="untuk"
                            required
                            style="
                                width:100%;
                                margin-top:10px;
                                padding:15px;
                                border-radius:16px;
                                background:var(--bg-soft);
                                border:1px solid var(--border-gold);
                                color:var(--text-primary);
                            "
                        >

                            <option value="">
                                Pilih Target
                            </option>

                            <option value="Anak-anak">
                                Anak-anak
                            </option>

                            <option value="Dewasa">
                                Dewasa
                            </option>

                        </select>

                    </div>

                    <div style="margin-bottom:25px;">

                        <label>Harga Paket</label>

                        <input
                            type="number"
                            name="harga"
                            value="{{ old('harga') }}"
                            min="0"
                            required
                            style="
                                width:100%;
                                margin-top:10px;
                                padding:15px;
                                border-radius:16px;
                                background:var(--bg-soft);
                                border:1px solid var(--border-gold);
                                color:var(--text-primary);
                            "
                        >

                    </div>

                    <div style="margin-bottom:25px;">

                        <label>Deskripsi</label>

                        <textarea
                            name="deskripsi"
                            rows="5"
                            required
                            style="
                                width:100%;
                                margin-top:10px;
                                padding:15px;
                                border-radius:16px;
                                background:var(--bg-soft);
                                border:1px solid var(--border-gold);
                                color:var(--text-primary);
                            "
                        >{{ old('deskripsi') }}</textarea>

                    </div>

                    <div>

                        <label>Gambar Paket</label>

                        <input
                            type="file"
                            name="gambar"
                            accept=".jpg,.jpeg,.png,.webp"
                            style="
                                width:100%;
                                margin-top:10px;
                                padding:15px;
                                border-radius:16px;
                                background:var(--bg-soft);
                                border:1px solid var(--border-gold);
                                color:var(--text-primary);
                            "
                        >

                    </div>

                </div>

                {{-- KANAN --}}
                <div>

                    <div class="glass-effect"
                         style="
                            padding:20px;
                            border-radius:20px;
                            margin-bottom:25px;
                         ">

                        <h3 class="text-gradient">
                            Tiket Masuk
                        </h3>

                        <p style="
                            color:var(--text-secondary);
                            margin-top:10px;
                        ">
                            ✓ Tiket masuk wisata otomatis termasuk dalam paket bundling.
                        </p>

                    </div>

                    {{-- WAHANA --}}
                    <div class="glass-effect"
                         style="
                            padding:20px;
                            border-radius:20px;
                            margin-bottom:25px;
                         ">

                        <h3 class="text-gradient">
                            Pilih Wahana
                        </h3>

                        <div style="
                            margin-top:15px;
                            display:grid;
                            gap:10px;
                        ">

                            @foreach($wahanas as $wahana)

                                <label style="
                                    display:flex;
                                    align-items:center;
                                    gap:10px;
                                    padding:10px;
                                    border-radius:12px;
                                    background:rgba(255,255,255,.03);
                                ">

                                    <input
                                        type="checkbox"
                                        name="wahana_ids[]"
                                        value="{{ $wahana->id }}"
                                    >

                                    {{ $wahana->wahana }}

                                    <span style="
                                        color:var(--accent);
                                        margin-left:auto;
                                    ">
                                        Rp {{ number_format($wahana->harga,0,',','.') }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div>

                    {{-- MENU --}}
                    <div class="glass-effect"
                         style="
                            padding:20px;
                            border-radius:20px;
                         ">

                        <h3 class="text-gradient">
                            Pilih Menu
                        </h3>

                        @foreach($menus->groupBy('kategori') as $kategori => $items)

                            <div style="
                                margin-top:20px;
                                padding-bottom:15px;
                                border-bottom:1px solid var(--border-gold);
                            ">

                                <h4 style="
                                    color:var(--accent);
                                    margin-bottom:15px;
                                    font-weight:700;
                                ">
                                    {{ $kategori }}
                                </h4>

                                <div style="
                                    display:grid;
                                    gap:10px;
                                ">

                                    @foreach($items as $menu)

                                        <label style="
                                            display:flex;
                                            align-items:center;
                                            gap:10px;
                                            padding:10px;
                                            border-radius:12px;
                                            background:rgba(255,255,255,.03);
                                        ">

                                            <input
                                                type="checkbox"
                                                name="menu_ids[]"
                                                value="{{ $menu->id }}"
                                            >

                                            <div>

                                                <div>
                                                    {{ $menu->nama_menu }}
                                                </div>

                                                <small style="
                                                    color:var(--text-muted);
                                                ">
                                                    {{ $menu->status }}
                                                </small>

                                            </div>

                                            <span style="
                                                margin-left:auto;
                                                color:var(--accent);
                                            ">
                                                Rp {{ number_format($menu->harga,0,',','.') }}
                                            </span>

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <div style="
                margin-top:40px;
                display:flex;
                justify-content:flex-end;
            ">

                <button
                    type="submit"
                    class="btn-primary-travel"
                >
                    <i class="fas fa-floppy-disk"></i>
                    &nbsp;
                    Simpan Paket Bundling
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>