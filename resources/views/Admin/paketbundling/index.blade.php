<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Bundling</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

@include('admin.partials.sidebar')

<div class="container-custom"
     style="margin-left:320px;padding:50px 30px;">

    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:40px;
        flex-wrap:wrap;
        gap:20px;
    ">

        <div>

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
                Kelola Paket Bundling
            </h1>

            <p style="
                color:var(--text-secondary);
                margin-top:10px;
            ">
                Kombinasikan tiket masuk, wahana dan menu menjadi paket menarik.
            </p>

        </div>

        <a href="{{ route('admin.paketbundling.create') }}"
           class="btn-primary-travel">

            <i class="fas fa-plus"></i>
            &nbsp;
            Tambah Paket

        </a>

    </div>

    @if(session('success'))

        <div class="glass-effect"
             style="
                padding:20px;
                margin-bottom:25px;
                border-radius:20px;
             ">

            <i class="fas fa-circle-check"></i>
            {{ session('success') }}

        </div>

    @endif

    {{-- FILTER --}}
    <div style="
        display:flex;
        gap:15px;
        margin-bottom:25px;
        flex-wrap:wrap;
    ">

        <input
            type="text"
            id="searchPaket"
            placeholder="Cari nama paket..."
            style="
                flex:1;
                min-width:250px;
                padding:14px 18px;
                border-radius:16px;
                border:1px solid var(--border-gold);
                background:var(--bg-soft);
                color:var(--text-primary);
                outline:none;
            "
        >

        <select
            id="filterTarget"
            style="
                padding:14px 18px;
                border-radius:16px;
                border:1px solid var(--border-gold);
                background:var(--bg-soft);
                color:var(--text-primary);
                outline:none;
            "
        >
            <option value="all">
                Semua Target
            </option>

            <option value="anak-anak">
                Anak-anak
            </option>

            <option value="dewasa">
                Dewasa
            </option>

        </select>

    </div>

    <div class="glass-effect"
         style="
            padding:25px;
            border-radius:28px;
         ">

        <div style="overflow-x:auto;">

            <table style="
                width:100%;
                border-collapse:collapse;
            ">

                <thead>

                    <tr style="
                        border-bottom:1px solid var(--border-gold);
                    ">

                        <th style="padding:20px;text-align:left;">Gambar</th>
                        <th style="padding:20px;text-align:left;">Nama Paket</th>
                        <th style="padding:20px;text-align:left;">Untuk</th>
                        <th style="padding:20px;text-align:left;">Wahana</th>
                        <th style="padding:20px;text-align:left;">Menu</th>
                        <th style="padding:20px;text-align:left;">Harga</th>
                        <th style="padding:20px;text-align:center;">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($paketBundlings as $paket)

                    <tr
                        class="paket-row"
                        data-nama="{{ strtolower($paket->nama_paket) }}"
                        data-target="{{ strtolower($paket->untuk) }}"
                        style="
                            border-bottom:1px solid rgba(255,255,255,.05);
                        "
                    >

                        <td style="padding:20px;">

                            @if($paket->gambar)

                                <img
                                    src="{{ asset('storage/'.$paket->gambar) }}"
                                    width="80"
                                    height="80"
                                    style="
                                        object-fit:cover;
                                        border-radius:16px;
                                    "
                                >

                            @else

                                <div style="
                                    width:80px;
                                    height:80px;
                                    border-radius:16px;
                                    background:var(--bg-soft);
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                ">
                                    <i class="fas fa-box-open"></i>
                                </div>

                            @endif

                        </td>

                        <td style="padding:20px;">

                            <strong>
                                {{ $paket->nama_paket }}
                            </strong>

                            <br>

                            <small style="
                                color:var(--text-muted);
                            ">
                                Tiket masuk otomatis termasuk
                            </small>

                        </td>

                        <td style="padding:20px;">

                            <span style="
                                padding:8px 16px;
                                border-radius:999px;
                                background:rgba(226,201,151,.15);
                                color:var(--accent);
                            ">
                                {{ $paket->untuk }}
                            </span>

                        </td>

                        <td style="padding:20px;">

                            @foreach($paket->wahanas as $wahana)
                                <div>
                                    • {{ $wahana->wahana }}
                                </div>
                            @endforeach

                        </td>

                        <td style="padding:20px;">

                            @foreach($paket->menus as $menu)
                                <div>
                                    • {{ $menu->nama_menu }}
                                </div>
                            @endforeach

                        </td>

                        <td style="padding:20px;">

                            <strong class="text-gradient">
                                Rp {{ number_format($paket->harga,0,',','.') }}
                            </strong>

                        </td>

                        <td style="padding:20px;">

                            <div style="
                                display:flex;
                                justify-content:center;
                                gap:10px;
                            ">

                                <a
                                    href="{{ route('admin.paketbundling.edit',$paket->id) }}"
                                    class="btn-secondary-travel"
                                    style="padding:10px 16px;"
                                >
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form
                                    action="{{ route('admin.paketbundling.destroy',$paket->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus paket ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn-secondary-travel"
                                        style="
                                            padding:10px 16px;
                                            cursor:pointer;
                                        "
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            style="
                                text-align:center;
                                padding:60px;
                            ">

                            <i class="fas fa-box-open"
                               style="
                                    font-size:50px;
                                    color:var(--accent);
                               ">
                            </i>

                            <h3 style="margin-top:20px;">
                                Belum Ada Paket Bundling
                            </h3>

                            <p style="
                                color:var(--text-muted);
                            ">
                                Tambahkan paket bundling pertama Anda.
                            </p>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

const searchInput = document.getElementById('searchPaket');
const filterTarget = document.getElementById('filterTarget');
const rows = document.querySelectorAll('.paket-row');

function filterPaket() {

    const keyword = searchInput.value.toLowerCase();
    const target = filterTarget.value.toLowerCase();

    rows.forEach(row => {

        const nama = row.dataset.nama;
        const kategori = row.dataset.target;

        const matchNama =
            nama.includes(keyword);

        const matchTarget =
            target === 'all'
            || kategori === target;

        row.style.display =
            (matchNama && matchTarget)
            ? ''
            : 'none';

    });

}

searchInput.addEventListener(
    'keyup',
    filterPaket
);

filterTarget.addEventListener(
    'change',
    filterPaket
);

</script>

</body>
</html>