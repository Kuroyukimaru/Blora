<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'menus';


    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id_menu';

    public $incrementing = true;

    protected $keyType = 'int';


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
        'nama_menu',
        'kategori',
        'harga',
        'deskripsi',
        'gambar',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'id_menu' => 'integer',
        'id_user' => 'integer',
        'harga'   => 'integer',
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
    | menus.id_user -> users.id_user
    |
    | Project menggunakan model Admin untuk akun yang berada
    | pada tabel users.
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
    | Satu Menu dapat digunakan pada banyak detail pesanan.
    |
    */

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(
            DetailPesanan::class,
            'id_menu',
            'id_menu'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : DETAILS
    |--------------------------------------------------------------------------
    |
    | Alias dari detailPesanans().
    |
    | Bisa digunakan jika controller lain memakai:
    |
    | $menu->details
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
    | menus
    |   ↓
    | paket_bundling_menus
    |   ↓
    | paket_bundlings
    |
    */

    public function paketBundlings(): BelongsToMany
    {
        return $this->belongsToMany(
            PaketBundling::class,
            'paket_bundling_menus',
            'id_menu',
            'id_paket_bundling'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSOR : GAMBAR URL
    |--------------------------------------------------------------------------
    |
    | Database dapat menyimpan:
    |
    | menu/foto.jpg
    | storage/menu/foto.jpg
    | public/menu/foto.jpg
    | /storage/menu/foto.jpg
    | https://domain.com/storage/menu/foto.jpg
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
        | BERSIHKAN PATH
        |--------------------------------------------------------------------------
        */

        $gambar = trim(
            $this->gambar
        );


        /*
        |--------------------------------------------------------------------------
        | JIKA SUDAH URL
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
        | HAPUS PREFIX ASSET STORAGE
        |--------------------------------------------------------------------------
        |
        | Jika database berisi:
        |
        | asset/storage/menu/foto.jpg
        |
        | bagian ini mencegah URL menjadi ganda.
        |
        */

        if (
            str_starts_with(
                $gambar,
                'asset/storage/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('asset/storage/')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE URL
        |--------------------------------------------------------------------------
        */

        return asset(
            'storage/' . $gambar
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSOR : FORMAT HARGA
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | 15000
    | menjadi:
    | Rp 15.000
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
    | SCOPE : HABIS
    |--------------------------------------------------------------------------
    */

    public function scopeHabis(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'Habis'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : KATEGORI
    |--------------------------------------------------------------------------
    */

    public function scopeKategori(
        Builder $query,
        ?string $kategori
    ): Builder {

        $kategori = trim(
            (string) $kategori
        );


        if (
            $kategori === ''
        ) {
            return $query;
        }


        return $query->where(
            'kategori',
            $kategori
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : SEARCH
    |--------------------------------------------------------------------------
    |
    | Mencari berdasarkan:
    |
    | - nama menu
    | - kategori
    | - deskripsi
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
                        'nama_menu',
                        'like',
                        $keyword
                    )

                    ->orWhere(
                        'kategori',
                        'like',
                        $keyword
                    )

                    ->orWhere(
                        'deskripsi',
                        'like',
                        $keyword
                    );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : NAMA MENU
    |--------------------------------------------------------------------------
    */

    public function scopeNamaMenu(
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
            'nama_menu',
            'like',
            '%' .
            $nama .
            '%'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : MAKANAN
    |--------------------------------------------------------------------------
    */

    public function scopeMakanan(
        Builder $query
    ): Builder {
        return $query->where(
            'kategori',
            'Makanan'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : MINUMAN
    |--------------------------------------------------------------------------
    */

    public function scopeMinuman(
        Builder $query
    ): Builder {
        return $query->where(
            'kategori',
            'Minuman'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : SAMBAL
    |--------------------------------------------------------------------------
    */

    public function scopeSambal(
        Builder $query
    ): Builder {
        return $query->where(
            'kategori',
            'Sambal'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : LAINNYA
    |--------------------------------------------------------------------------
    */

    public function scopeLainnya(
        Builder $query
    ): Builder {
        return $query->where(
            'kategori',
            'Lainnya'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : STATUS TERSEDIA
    |--------------------------------------------------------------------------
    */

    public function isTersedia(): bool
    {
        return $this->status === 'Tersedia';
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : STATUS HABIS
    |--------------------------------------------------------------------------
    */

    public function isHabis(): bool
    {
        return $this->status === 'Habis';
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : KATEGORI
    |--------------------------------------------------------------------------
    */

    public function isKategori(
        string $kategori
    ): bool {
        return $this->kategori === $kategori;
    }


    public function isMakanan(): bool
    {
        return $this->kategori === 'Makanan';
    }


    public function isMinuman(): bool
    {
        return $this->kategori === 'Minuman';
    }


    public function isSambal(): bool
    {
        return $this->kategori === 'Sambal';
    }


    public function isLainnya(): bool
    {
        return $this->kategori === 'Lainnya';
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : SUDAH DIGUNAKAN DALAM PESANAN
    |--------------------------------------------------------------------------
    |
    | Menu yang sudah pernah masuk transaksi tidak boleh
    | dihapus sembarangan karena akan merusak histori.
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
    | HELPER : JUMLAH PESANAN SEBAGAI DETAIL
    |--------------------------------------------------------------------------
    |
    | Alias yang lebih mudah dibaca di beberapa Blade/controller.
    |
    */

    public function jumlahPesanan(): int
    {
        return $this->jumlahDetailPesanan();
    }
}