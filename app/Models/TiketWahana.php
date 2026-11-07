<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class TiketWahana extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'tiket_wahanas';


    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id_tiket_wahana';

    protected $keyType = 'int';

    public $incrementing = true;


    /*
    |--------------------------------------------------------------------------
    | TIMESTAMPS
    |--------------------------------------------------------------------------
    */

    public $timestamps = true;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'id_user',
        'nama_wahana',
        'harga',
        'ketentuan',
        'gambar',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'id_tiket_wahana' => 'integer',
        'id_user'         => 'integer',
        'harga'           => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | APPENDED ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    protected $appends = [
        'gambar_url',
        'formatted_harga',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : USER / ADMIN
    |--------------------------------------------------------------------------
    |
    | tiket_wahanas.id_user
    |        ↓
    | users.id_user
    |
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            Admin::class,
            'id_user',
            'id_user'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : DETAIL PESANAN
    |--------------------------------------------------------------------------
    |
    | Satu tiket wahana dapat digunakan pada banyak
    | detail pesanan.
    |
    | tiket_wahanas.id_tiket_wahana
    |        ↓
    | detail_pesanans.id_tiket_wahana
    |
    */

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(
            DetailPesanan::class,
            'id_tiket_wahana',
            'id_tiket_wahana'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : DETAILS
    |--------------------------------------------------------------------------
    |
    | Alias dari detailPesanans().
    |
    */

    public function details(): HasMany
    {
        return $this->detailPesanans();
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : PAKET BUNDLING
    |--------------------------------------------------------------------------
    |
    | tiket_wahanas
    |       ↓
    | paket_bundling_wahanas
    |       ↓
    | paket_bundlings
    |
    */

    public function paketBundlings(): BelongsToMany
    {
        return $this->belongsToMany(
            PaketBundling::class,
            'paket_bundling_wahanas',
            'id_tiket_wahana',
            'id_paket_bundling'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSOR : GAMBAR URL
    |--------------------------------------------------------------------------
    |
    | Mendukung:
    |
    | tiket-wahana/foto.jpg
    | storage/tiket-wahana/foto.jpg
    | public/tiket-wahana/foto.jpg
    | /storage/tiket-wahana/foto.jpg
    | URL eksternal
    |
    */

    public function getGambarUrlAttribute(): string
    {
        /*
        |--------------------------------------------------------------------------
        | GAMBAR KOSONG
        |--------------------------------------------------------------------------
        */

        if (
            empty($this->gambar)
            ||
            !is_string($this->gambar)
        ) {
            return asset(
                'images/no-image.png'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN NILAI
        |--------------------------------------------------------------------------
        */

        $gambar = trim(
            $this->gambar
        );


        /*
        |--------------------------------------------------------------------------
        | JIKA SUDAH BERUPA URL
        |--------------------------------------------------------------------------
        */

        if (
            filter_var(
                $gambar,
                FILTER_VALIDATE_URL
            )
        ) {
            return $gambar;
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS SLASH AWAL
        |--------------------------------------------------------------------------
        */

        $gambar = ltrim(
            $gambar,
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | HAPUS PREFIX STORAGE/
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $gambar,
                'storage/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('storage/')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS PREFIX PUBLIC/
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $gambar,
                'public/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('public/')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA FILE TIDAK ADA
        |--------------------------------------------------------------------------
        */

        if (
            !Storage::disk('public')->exists(
                $gambar
            )
        ) {
            return asset(
                'images/no-image.png'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE URL
        |--------------------------------------------------------------------------
        */

        return Storage::disk(
            'public'
        )->url(
            $gambar
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSOR : FORMAT HARGA
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | 5000
    | ↓
    | Rp 5.000
    |
    */

    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format(
            (int) $this->harga,
            0,
            ',',
            '.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : TERSEDIA
    |--------------------------------------------------------------------------
    */

    public function scopeTersedia(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'Tersedia'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : TIDAK TERSEDIA
    |--------------------------------------------------------------------------
    */

    public function scopeTidakTersedia(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'Tidak Tersedia'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : SEARCH
    |--------------------------------------------------------------------------
    |
    | Mencari berdasarkan:
    |
    | - nama wahana
    | - ketentuan
    |
    */

    public function scopeSearch(
        Builder $query,
        ?string $search
    ): Builder {

        $search = trim(
            (string) $search
        );


        if (
            $search === ''
        ) {
            return $query;
        }


        return $query->where(
            function (
                Builder $query
            ) use (
                $search
            ) {

                $keyword =
                    '%' .
                    $search .
                    '%';


                $query

                    ->where(
                        'nama_wahana',
                        'like',
                        $keyword
                    )

                    ->orWhere(
                        'ketentuan',
                        'like',
                        $keyword
                    );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : NAMA WAHANA
    |--------------------------------------------------------------------------
    */

    public function scopeNamaWahana(
        Builder $query,
        ?string $nama
    ): Builder {

        $nama = trim(
            (string) $nama
        );


        if (
            $nama === ''
        ) {
            return $query;
        }


        return $query->where(
            'nama_wahana',
            'like',
            '%' .
            $nama .
            '%'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : CEK TERSEDIA
    |--------------------------------------------------------------------------
    */

    public function isTersedia(): bool
    {
        return $this->status === 'Tersedia';
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : CEK TIDAK TERSEDIA
    |--------------------------------------------------------------------------
    */

    public function isTidakTersedia(): bool
    {
        return $this->status === 'Tidak Tersedia';
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : STATUS AKTIF
    |--------------------------------------------------------------------------
    |
    | Alias untuk pengecekan apakah tiket bisa dipesan.
    |
    */

    public function isAktif(): bool
    {
        return $this->isTersedia();
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : STATUS NONAKTIF
    |--------------------------------------------------------------------------
    */

    public function isNonaktif(): bool
    {
        return $this->isTidakTersedia();
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : CEK GAMBAR
    |--------------------------------------------------------------------------
    */

    public function hasGambar(): bool
    {
        /*
        |--------------------------------------------------------------------------
        | GAMBAR KOSONG
        |--------------------------------------------------------------------------
        */

        if (
            empty($this->gambar)
            ||
            !is_string($this->gambar)
        ) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN PATH
        |--------------------------------------------------------------------------
        */

        $gambar = trim(
            $this->gambar
        );


        /*
        |--------------------------------------------------------------------------
        | URL EKSTERNAL
        |--------------------------------------------------------------------------
        */

        if (
            filter_var(
                $gambar,
                FILTER_VALIDATE_URL
            )
        ) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN SLASH
        |--------------------------------------------------------------------------
        */

        $gambar = ltrim(
            $gambar,
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | HAPUS PREFIX STORAGE/
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $gambar,
                'storage/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('storage/')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS PREFIX PUBLIC/
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $gambar,
                'public/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('public/')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK STORAGE
        |--------------------------------------------------------------------------
        */

        return Storage::disk(
            'public'
        )->exists(
            $gambar
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : HARGA INTEGER
    |--------------------------------------------------------------------------
    */

    public function getHargaInteger(): int
    {
        return (int) $this->harga;
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : SUDAH DIGUNAKAN DALAM PESANAN
    |--------------------------------------------------------------------------
    |
    | Mengecek apakah tiket ini sudah pernah masuk
    | ke dalam detail pesanan.
    |
    */

    public function sudahDigunakanDalamPesanan(): bool
    {
        return $this
            ->detailPesanans()
            ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : BOLEH DIHAPUS
    |--------------------------------------------------------------------------
    |
    | Tiket yang sudah digunakan pada transaksi tidak
    | boleh dihapus agar histori transaksi tetap aman.
    |
    */

    public function bolehDihapus(): bool
    {
        return !$this->sudahDigunakanDalamPesanan();
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : JUMLAH DETAIL PESANAN
    |--------------------------------------------------------------------------
    */

    public function jumlahDetailPesanan(): int
    {
        return $this
            ->detailPesanans()
            ->count();
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : JUMLAH PAKET BUNDLING
    |--------------------------------------------------------------------------
    */

    public function jumlahPaketBundling(): int
    {
        return $this
            ->paketBundlings()
            ->count();
    }
}