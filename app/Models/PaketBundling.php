<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class PaketBundling extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'paket_bundlings';

    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id_paket_bundling';

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
        'nama_paket',
        'untuk',
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
        'id_paket_bundling' => 'integer',
        'id_user'           => 'integer',
        'harga'             => 'integer',
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
    | RELATIONSHIP : MENU
    |--------------------------------------------------------------------------
    |
    | Pivot:
    | paket_bundling_menus
    |
    */

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(
            Menu::class,
            'paket_bundling_menus',
            'id_paket_bundling',
            'id_menu'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : TIKET WAHANA
    |--------------------------------------------------------------------------
    |
    | Pivot:
    | paket_bundling_wahanas
    |
    */

    public function wahanas(): BelongsToMany
    {
        return $this->belongsToMany(
            TiketWahana::class,
            'paket_bundling_wahanas',
            'id_paket_bundling',
            'id_tiket_wahana'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : DETAIL PESANAN
    |--------------------------------------------------------------------------
    */

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(
            DetailPesanan::class,
            'id_paket_bundling',
            'id_paket_bundling'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : DETAILS
    |--------------------------------------------------------------------------
    |
    | Alias untuk detailPesanans().
    |
    */

    public function details(): HasMany
    {
        return $this->detailPesanans();
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR : GAMBAR URL
    |--------------------------------------------------------------------------
    */

    public function getGambarUrlAttribute(): string
    {
        /*
        |--------------------------------------------------------------------------
        | Tidak ada gambar
        |--------------------------------------------------------------------------
        */

        if (
            empty($this->gambar) ||
            !is_string($this->gambar)
        ) {
            return asset('images/no-image.png');
        }

        $gambar = trim($this->gambar);

        if ($gambar === '') {
            return asset('images/no-image.png');
        }

        /*
        |--------------------------------------------------------------------------
        | Jika database menyimpan URL lengkap
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
        | Bersihkan slash awal
        |--------------------------------------------------------------------------
        */

        $gambar = ltrim(
            $gambar,
            '/'
        );

        /*
        |--------------------------------------------------------------------------
        | Hapus prefix storage/
        |--------------------------------------------------------------------------
        |
        | storage/paket-bundling/foto.jpg
        | ->
        | paket-bundling/foto.jpg
        |
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
        | Hapus prefix public/
        |--------------------------------------------------------------------------
        |
        | public/paket-bundling/foto.jpg
        | ->
        | paket-bundling/foto.jpg
        |
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
        | Hapus prefix storage/app/public/
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $gambar,
                'storage/app/public/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('storage/app/public/')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cek file pada storage public
        |--------------------------------------------------------------------------
        */

        if (
            Storage::disk('public')->exists($gambar)
        ) {
            return Storage::disk('public')->url(
                $gambar
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        return asset('images/no-image.png');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR : FORMAT HARGA
    |--------------------------------------------------------------------------
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
    */

    public function scopeSearch(
        Builder $query,
        ?string $search
    ): Builder {
        $search = trim(
            (string) $search
        );

        if ($search === '') {
            return $query;
        }

        return $query->where(function (
            Builder $query
        ) use ($search) {

            $query
                ->where(
                    'nama_paket',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'untuk',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'deskripsi',
                    'like',
                    '%' . $search . '%'
                );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : UNTUK
    |--------------------------------------------------------------------------
    */

    public function scopeUntuk(
        Builder $query,
        ?string $untuk
    ): Builder {
        $untuk = trim(
            (string) $untuk
        );

        if ($untuk === '') {
            return $query;
        }

        return $query->where(
            'untuk',
            $untuk
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : NAMA PAKET
    |--------------------------------------------------------------------------
    */

    public function scopeNamaPaket(
        Builder $query,
        ?string $nama
    ): Builder {
        $nama = trim(
            (string) $nama
        );

        if ($nama === '') {
            return $query;
        }

        return $query->where(
            'nama_paket',
            'like',
            '%' . $nama . '%'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : DENGAN MENU
    |--------------------------------------------------------------------------
    */

    public function scopeDenganMenu(
        Builder $query
    ): Builder {
        return $query->whereHas(
            'menus'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : DENGAN WAHANA
    |--------------------------------------------------------------------------
    */

    public function scopeDenganWahana(
        Builder $query
    ): Builder {
        return $query->whereHas(
            'wahanas'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : DENGAN MENU DAN WAHANA
    |--------------------------------------------------------------------------
    */

    public function scopeDenganMenuDanWahana(
        Builder $query
    ): Builder {
        return $query
            ->whereHas('menus')
            ->whereHas('wahanas');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : HANYA MENU
    |--------------------------------------------------------------------------
    */

    public function scopeHanyaMenu(
        Builder $query
    ): Builder {
        return $query
            ->whereHas('menus')
            ->whereDoesntHave('wahanas');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : HANYA WAHANA
    |--------------------------------------------------------------------------
    */

    public function scopeHanyaWahana(
        Builder $query
    ): Builder {
        return $query
            ->whereDoesntHave('menus')
            ->whereHas('wahanas');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : MEMILIKI KOMPONEN
    |--------------------------------------------------------------------------
    */

    public function scopeMemilikiKomponen(
        Builder $query
    ): Builder {
        return $query->where(function (
            Builder $query
        ) {
            $query
                ->whereHas('menus')
                ->orWhereHas('wahanas');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : STATUS
    |--------------------------------------------------------------------------
    */

    public function isTersedia(): bool
    {
        return $this->status === 'Tersedia';
    }

    public function isTidakTersedia(): bool
    {
        return $this->status === 'Tidak Tersedia';
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : GAMBAR
    |--------------------------------------------------------------------------
    */

    public function hasGambar(): bool
    {
        if (
            empty($this->gambar) ||
            !is_string($this->gambar)
        ) {
            return false;
        }

        $gambar = trim(
            $this->gambar
        );

        if ($gambar === '') {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | URL eksternal dianggap valid
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
        | Bersihkan slash
        |--------------------------------------------------------------------------
        */

        $gambar = ltrim(
            $gambar,
            '/'
        );

        /*
        |--------------------------------------------------------------------------
        | Hapus storage/
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
        | Hapus public/
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
        | Hapus storage/app/public/
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $gambar,
                'storage/app/public/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('storage/app/public/')
            );
        }

        return Storage::disk('public')->exists(
            $gambar
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : KOMPONEN
    |--------------------------------------------------------------------------
    */

    public function memilikiMenu(): bool
    {
        if (
            $this->relationLoaded('menus')
        ) {
            return $this->menus->isNotEmpty();
        }

        return $this->menus()->exists();
    }

    public function memilikiWahana(): bool
    {
        if (
            $this->relationLoaded('wahanas')
        ) {
            return $this->wahanas->isNotEmpty();
        }

        return $this->wahanas()->exists();
    }

    public function memilikiMenuDanWahana(): bool
    {
        return $this->memilikiMenu()
            && $this->memilikiWahana();
    }

    public function hanyaMenu(): bool
    {
        return $this->memilikiMenu()
            && !$this->memilikiWahana();
    }

    public function hanyaWahana(): bool
    {
        return !$this->memilikiMenu()
            && $this->memilikiWahana();
    }

    public function memilikiKomponen(): bool
    {
        return $this->memilikiMenu()
            || $this->memilikiWahana();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : JUMLAH KOMPONEN
    |--------------------------------------------------------------------------
    */

    public function jumlahMenu(): int
    {
        if (
            $this->relationLoaded('menus')
        ) {
            return $this->menus->count();
        }

        return $this->menus()->count();
    }

    public function jumlahWahana(): int
    {
        if (
            $this->relationLoaded('wahanas')
        ) {
            return $this->wahanas->count();
        }

        return $this->wahanas()->count();
    }

    public function jumlahKomponen(): int
    {
        return $this->jumlahMenu()
            + $this->jumlahWahana();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : TIPE PAKET
    |--------------------------------------------------------------------------
    */

    public function tipePaket(): string
    {
        $adaMenu = $this->memilikiMenu();
        $adaWahana = $this->memilikiWahana();

        if ($adaMenu && $adaWahana) {
            return 'Menu & Wahana';
        }

        if ($adaMenu) {
            return 'Menu';
        }

        if ($adaWahana) {
            return 'Wahana';
        }

        return 'Kosong';
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : HISTORI PESANAN
    |--------------------------------------------------------------------------
    */

    public function sudahDigunakanDalamPesanan(): bool
    {
        return $this->detailPesanans()->exists();
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
    | HELPER : JUMLAH PESANAN
    |--------------------------------------------------------------------------
    */

    public function jumlahDetailPesanan(): int
    {
        return $this->detailPesanans()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : HARGA
    |--------------------------------------------------------------------------
    */

    public function getHargaInteger(): int
    {
        return (int) $this->harga;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : BISA DIPESAN
    |--------------------------------------------------------------------------
    */

    public function bisaDipesan(): bool
    {
        return $this->isTersedia()
            && $this->memilikiKomponen();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : LABEL STATUS
    |--------------------------------------------------------------------------
    */

    public function getLabelStatus(): string
    {
        return $this->isTersedia()
            ? 'Tersedia'
            : 'Tidak Tersedia';
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : LABEL TIPE PAKET
    |--------------------------------------------------------------------------
    */

    public function getLabelTipe(): string
    {
        return $this->tipePaket();
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER : DATA PUBLIC
    |--------------------------------------------------------------------------
    |
    | Data ringkas yang aman digunakan untuk kebutuhan frontend/API.
    |
    */

    public function toPublicArray(): array
    {
        return [
            'id_paket_bundling' => $this->id_paket_bundling,
            'nama_paket'        => $this->nama_paket,
            'untuk'             => $this->untuk,
            'harga'             => $this->getHargaInteger(),
            'harga_format'      => $this->formatted_harga,
            'deskripsi'         => $this->deskripsi,
            'gambar_url'        => $this->gambar_url,
            'status'            => $this->status,
            'tipe_paket'        => $this->tipePaket(),
            'jumlah_menu'       => $this->jumlahMenu(),
            'jumlah_wahana'     => $this->jumlahWahana(),
            'jumlah_komponen'   => $this->jumlahKomponen(),
        ];
    }
}