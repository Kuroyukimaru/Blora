<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Oleh-Oleh</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

@include('admin.partials.sidebar')

<div class="container-custom" style="margin-left:320px;padding:50px 30px;">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:40px;">

        <div>
            <p style="color:var(--text-muted);letter-spacing:2px;">
                ADMIN PANEL / OLEH-OLEH
            </p>

            <h1 class="text-gradient"
                style="font-size:3rem;font-weight:800;">
                Kelola Oleh-Oleh
            </h1>

            <p style="color:var(--text-secondary);margin-top:10px;">
                Kelola berbagai produk oleh-oleh khas Blora.
            </p>
        </div>

        <a href="{{ route('admin.oleholeh.create') }}"
           class="btn-primary-travel">
            <i class="fas fa-plus"></i>
            &nbsp;
            Tambah Oleh-Oleh
        </a>

    </div>

    @if(session('success'))

        <div class="glass-effect"
             style="padding:20px;border-radius:20px;margin-bottom:25px;color:#90ee90;">
            {{ session('success') }}
        </div>

    @endif

    <div class="glass-effect"
         style="padding:30px;border-radius:28px;">

        <div style="display:flex;gap:20px;margin-bottom:25px;">

            <input
                type="text"
                id="searchOlehOleh"
                placeholder="Cari oleh-oleh..."
                style="
                    flex:1;
                    background:var(--bg-soft);
                    border:1px solid var(--border-gold);
                    color:var(--text-primary);
                    padding:15px 20px;
                    border-radius:16px;
                "
            >

            <select
                id="filterJenis"
                style="
                    background:var(--bg-soft);
                    border:1px solid var(--border-gold);
                    color:var(--text-primary);
                    padding:15px 20px;
                    border-radius:16px;
                "
            >
                <option value="all">Semua Jenis</option>
                <option value="totebag">Totebag</option>
                <option value="baju">Baju</option>
                <option value="celana">Celana</option>
                <option value="topi">Topi</option>
                <option value="gantungan kunci">Gantungan Kunci</option>
                <option value="ikat rambut">Ikat Rambut</option>
                <option value="kacamata">Kacamata</option>
                <option value="daster">Daster</option>
                <option value="sandal">Sandal</option>
                <option value="pajangan tumbuhan">Pajangan Tumbuhan</option>
                <option value="barongan">Barongan</option>
            </select>

        </div>

        <table style="width:100%;border-collapse:collapse;">

            <thead>

                <tr style="border-bottom:1px solid var(--border-gold);">

                    <th style="padding:20px;text-align:left;">Gambar</th>
                    <th style="padding:20px;text-align:left;">Nama</th>
                    <th style="padding:20px;text-align:left;">Jenis</th>
                    <th style="padding:20px;text-align:left;">Stok</th>
                    <th style="padding:20px;text-align:left;">Status</th>
                    <th style="padding:20px;text-align:center;">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($olehOleh as $item)

                <tr class="souvenir-row"
                    data-nama="{{ strtolower($item->nama) }}"
                    data-jenis="{{ strtolower($item->jenis) }}"
                    style="border-bottom:1px solid var(--border-soft);">

                    <td style="padding:20px;">

                        @if($item->gambar)

                            <img
                                src="{{ asset('storage/'.$item->gambar) }}"
                                width="90"
                                height="90"
                                style="
                                    border-radius:18px;
                                    object-fit:cover;
                                "
                            >

                        @endif

                    </td>

                    <td style="padding:20px;">

                        <strong>
                            {{ $item->nama }}
                        </strong>

                        <br>

                        <span style="color:var(--text-muted);">
                            {{ Str::limit($item->deskripsi,60) }}
                        </span>

                    </td>

                    <td style="padding:20px;">
                        {{ ucfirst($item->jenis) }}
                    </td>

                    <td style="padding:20px;">
                        {{ $item->stock }}
                    </td>

                    <td style="padding:20px;">

                        @if($item->stock > 0)

                            <span style="color:#6EE7B7;">
                                Tersedia
                            </span>

                        @else

                            <span style="color:#F87171;">
                                Habis
                            </span>

                        @endif

                    </td>

                    <td style="padding:20px;text-align:center;">

                        <a href="{{ route('admin.oleholeh.edit',$item->id) }}"
                           class="btn-secondary-travel">
                            <i class="fas fa-pen"></i>
                        </a>

                        <form
                            action="{{ route('admin.oleholeh.destroy',$item->id) }}"
                            method="POST"
                            style="display:inline-block;"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Hapus data ini?')"
                                type="submit"
                                class="btn-secondary-travel"
                            >
                                <i class="fas fa-trash"></i>
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6"
                        style="padding:50px;text-align:center;color:var(--text-muted);">

                        Belum ada data oleh-oleh.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<script>
const searchInput = document.getElementById('searchOlehOleh');
const filterJenis = document.getElementById('filterJenis');

function filterData() {

    const keyword = searchInput.value.toLowerCase();
    const jenis = filterJenis.value;

    document.querySelectorAll('.souvenir-row').forEach(row => {

        const nama = row.dataset.nama;
        const kategori = row.dataset.jenis;

        const cocokNama = nama.includes(keyword);
        const cocokJenis = jenis === 'all' || kategori === jenis;

        row.style.display =
            cocokNama && cocokJenis
            ? ''
            : 'none';

    });
}

searchInput.addEventListener('keyup', filterData);
filterJenis.addEventListener('change', filterData);
</script>

</body>
</html>