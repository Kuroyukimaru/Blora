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
            ADMIN PANEL / UPDATE
        </p>

        <h1 class="text-gradient"
            style="
                font-size:3rem;
                font-weight:800;
            ">
            Edit Oleh-Oleh
        </h1>

        <p style="
            color:var(--text-secondary);
            margin-top:10px;
        ">
            Perbarui informasi produk oleh-oleh khas Blora.
        </p>

    </div>

    @if ($errors->any())

        <div class="glass-effect"
             style="
                padding:25px;
                border-radius:20px;
                margin-bottom:25px;
                border-color:#ef4444;
             ">

            <strong style="color:#ef4444;">
                Gagal Memproses Data
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
            action="{{ route('admin.oleholeh.update',$olehOleh->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:40px;
            ">

                <div>

                    <div style="margin-bottom:25px;">

                        <label style="
                            display:block;
                            margin-bottom:10px;
                            color:var(--text-secondary);
                        ">
                            Nama Oleh-Oleh
                        </label>

                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama',$olehOleh->nama) }}"
                            required
                            style="
                                width:100%;
                                padding:16px 20px;
                                background:var(--bg-soft);
                                border:1px solid var(--border-gold);
                                border-radius:16px;
                                color:var(--text-primary);
                            "
                        >

                    </div>

                    <div style="margin-bottom:25px;">

                        <label style="
                            display:block;
                            margin-bottom:10px;
                            color:var(--text-secondary);
                        ">
                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            rows="6"
                            required
                            style="
                                width:100%;
                                padding:16px 20px;
                                background:var(--bg-soft);
                                border:1px solid var(--border-gold);
                                border-radius:16px;
                                color:var(--text-primary);
                                resize:none;
                            "
                        >{{ old('deskripsi',$olehOleh->deskripsi) }}</textarea>

                    </div>

                    <div>

                        <label style="
                            display:block;
                            margin-bottom:10px;
                            color:var(--text-secondary);
                        ">
                            Gambar Produk
                        </label>

                        <div class="glass-effect"
                             style="
                                padding:25px;
                                border-radius:20px;
                                text-align:center;
                             ">

                            <img
                                id="previewImage"
                                src="{{ $olehOleh->gambar ? asset('storage/'.$olehOleh->gambar) : '' }}"
                                style="
                                    max-width:100%;
                                    max-height:250px;
                                    border-radius:20px;
                                    {{ $olehOleh->gambar ? '' : 'display:none;' }}
                                    margin-bottom:20px;
                                "
                            >

                            <input
                                type="file"
                                name="gambar"
                                id="gambarInput"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <p id="fileName"
                               style="
                                    margin-top:10px;
                                    color:var(--text-muted);
                               ">
                                Pilih gambar baru (opsional)
                            </p>

                        </div>

                    </div>

                </div>

                <div>

                    <div style="margin-bottom:25px;">

                        <label style="
                            display:block;
                            margin-bottom:10px;
                            color:var(--text-secondary);
                        ">
                            Jenis Oleh-Oleh
                        </label>

                        <select
                            name="jenis"
                            required
                            style="
                                width:100%;
                                padding:16px 20px;
                                background:var(--bg-soft);
                                border:1px solid var(--border-gold);
                                border-radius:16px;
                                color:var(--text-primary);
                            "
                        >

                            <option value="totebag" {{ $olehOleh->jenis == 'totebag' ? 'selected' : '' }}>Totebag</option>
                            <option value="baju" {{ $olehOleh->jenis == 'baju' ? 'selected' : '' }}>Baju</option>
                            <option value="celana" {{ $olehOleh->jenis == 'celana' ? 'selected' : '' }}>Celana</option>
                            <option value="topi" {{ $olehOleh->jenis == 'topi' ? 'selected' : '' }}>Topi</option>
                            <option value="gantungan kunci" {{ $olehOleh->jenis == 'gantungan kunci' ? 'selected' : '' }}>Gantungan Kunci</option>
                            <option value="ikat rambut" {{ $olehOleh->jenis == 'ikat rambut' ? 'selected' : '' }}>Ikat Rambut</option>
                            <option value="kacamata" {{ $olehOleh->jenis == 'kacamata' ? 'selected' : '' }}>Kacamata</option>
                            <option value="daster" {{ $olehOleh->jenis == 'daster' ? 'selected' : '' }}>Daster</option>
                            <option value="sandal" {{ $olehOleh->jenis == 'sandal' ? 'selected' : '' }}>Sandal</option>
                            <option value="pajangan tumbuhan" {{ $olehOleh->jenis == 'pajangan tumbuhan' ? 'selected' : '' }}>Pajangan Tumbuhan</option>
                            <option value="barongan" {{ $olehOleh->jenis == 'barongan' ? 'selected' : '' }}>Barongan</option>

                        </select>

                    </div>

                    <div style="margin-bottom:35px;">

                        <label style="
                            display:block;
                            margin-bottom:10px;
                            color:var(--text-secondary);
                        ">
                            Stock Produk
                        </label>

                        <input
                            type="number"
                            value="{{ $olehOleh->stock }}"
                            disabled
                            style="
                                width:100%;
                                padding:16px 20px;
                                background:var(--bg-soft);
                                border:1px solid var(--border-gold);
                                border-radius:16px;
                                color:var(--text-muted);
                            "
                        >

                        <small style="
                            color:var(--text-muted);
                            display:block;
                            margin-top:10px;
                        ">
                            Stock tidak dapat diubah melalui halaman edit.
                        </small>

                    </div>

                    <button
                        type="submit"
                        class="btn-primary-travel"
                    >
                        <i class="fas fa-pen-to-square"></i>
                        &nbsp;
                        Update Oleh-Oleh
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<script>

const gambarInput = document.getElementById('gambarInput');
const previewImage = document.getElementById('previewImage');
const fileName = document.getElementById('fileName');

gambarInput.addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){

        fileName.innerText = file.name;

        const reader = new FileReader();

        reader.onload = function(event){

            previewImage.src = event.target.result;
            previewImage.style.display = 'block';

        }

        reader.readAsDataURL(file);

    }

});

</script>

</body>
</html>