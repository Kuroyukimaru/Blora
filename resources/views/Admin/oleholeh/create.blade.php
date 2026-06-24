<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Oleh-Oleh</title>

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
            Admin Panel / Creation
        </p>

        <h1 class="text-gradient"
            style="
                font-size:3rem;
                font-weight:800;
            ">
            Tambah Oleh-Oleh Baru
        </h1>

        <p style="
            color:var(--text-secondary);
            margin-top:10px;
        ">
            Tambahkan produk oleh-oleh khas Blora untuk wisatawan.
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
            action="{{ route('admin.oleholeh.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

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
                            value="{{ old('nama') }}"
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
                        >{{ old('deskripsi') }}</textarea>

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
                                style="
                                    max-width:100%;
                                    max-height:250px;
                                    border-radius:20px;
                                    display:none;
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
                                Belum ada gambar dipilih
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
                            <option value="">Pilih Jenis</option>
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

                    <div style="margin-bottom:35px;">

                        <label style="
                            display:block;
                            margin-bottom:10px;
                            color:var(--text-secondary);
                        ">
                            Stock
                        </label>

                        <input
                            type="number"
                            name="stock"
                            min="0"
                            value="{{ old('stock') }}"
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

                    <button
                        type="submit"
                        class="btn-primary-travel"
                    >
                        <i class="fas fa-floppy-disk"></i>
                        &nbsp;
                        Simpan Oleh-Oleh
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