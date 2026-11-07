<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class OlehOleh extends Model
{
    use HasFactory;

    protected $table = 'oleh_olehs';

    protected $primaryKey = 'id_oleh_oleh';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'nama',
        'jenis',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
        'status',
    ];

    protected $casts = [
        'id_oleh_oleh' => 'integer',
        'id_user'      => 'integer',
        'harga'        => 'integer',
        'stok'         => 'integer',
    ];

    protected $appends = [
        'gambar_url',
        'formatted_harga',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            Admin::class,
            'id_user',
            'id_user'
        );
    }

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(
            DetailPesanan::class,
            'id_oleh_oleh',
            'id_oleh_oleh'
        );
    }

    public function details(): HasMany
    {
        return $this->detailPesanans();
    }

    public function getGambarUrlAttribute(): string
    {
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

        if (
            filter_var($gambar, FILTER_VALIDATE_URL)
        ) {
            return $gambar;
        }

        $gambar = ltrim($gambar, '/');

        if (str_starts_with($gambar, 'storage/app/public/')) {
            $gambar = substr(
                $gambar,
                strlen('storage/app/public/')
            );
        }

        if (str_starts_with($gambar, 'storage/')) {
            $gambar = substr(
                $gambar,
                strlen('storage/')
            );
        }

        if (str_starts_with($gambar, 'public/')) {
            $gambar = substr(
                $gambar,
                strlen('public/')
            );
        }

        if (
            Storage::disk('public')->exists($gambar)
        ) {
            return Storage::disk('public')->url($gambar);
        }

        return asset('images/no-image.png');
    }

    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format(
            (int) $this->harga,
            0,
            ',',
            '.'
        );
    }

    public function scopeTersedia(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'Tersedia'
        );
    }

    public function scopeTidakTersedia(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            '!=',
            'Tersedia'
        );
    }

    public function scopeAdaStok(
        Builder $query
    ): Builder {
        return $query->where(
            'stok',
            '>',
            0
        );
    }

    public function scopeStokHabis(
        Builder $query
    ): Builder {
        return $query->where(
            'stok',
            '<=',
            0
        );
    }

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
                    'nama',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'jenis',
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

    public function scopeJenis(
        Builder $query,
        ?string $jenis
    ): Builder {
        $jenis = trim(
            (string) $jenis
        );

        if ($jenis === '') {
            return $query;
        }

        return $query->where(
            'jenis',
            $jenis
        );
    }

    public function scopeNama(
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
            'nama',
            'like',
            '%' . $nama . '%'
        );
    }

    public function scopeHargaMinimum(
        Builder $query,
        ?int $harga
    ): Builder {
        if ($harga === null) {
            return $query;
        }

        return $query->where(
            'harga',
            '>=',
            $harga
        );
    }

    public function scopeHargaMaksimum(
        Builder $query,
        ?int $harga
    ): Builder {
        if ($harga === null) {
            return $query;
        }

        return $query->where(
            'harga',
            '<=',
            $harga
        );
    }

    public function isTersedia(): bool
    {
        return $this->status === 'Tersedia';
    }

    public function isTidakTersedia(): bool
    {
        return $this->status !== 'Tersedia';
    }

    public function memilikiStok(
        int $jumlah = 1
    ): bool {
        if ($jumlah < 1) {
            return false;
        }

        return (int) $this->stok >= $jumlah;
    }

    public function stokHabis(): bool
    {
        return (int) $this->stok <= 0;
    }

    public function stokTersedia(): bool
    {
        return (int) $this->stok > 0;
    }

    public function statusBerdasarkanStok(): string
    {
        return $this->stokTersedia()
            ? 'Tersedia'
            : 'Tidak Tersedia';
    }

    public function syncStatusDenganStok(
        bool $save = true
    ): string {
        $status = $this->statusBerdasarkanStok();

        $this->status = $status;

        if ($save) {
            $this->save();
        }

        return $status;
    }

    public function hasGambar(): bool
    {
        if (
            empty($this->gambar) ||
            !is_string($this->gambar)
        ) {
            return false;
        }

        $gambar = trim($this->gambar);

        if ($gambar === '') {
            return false;
        }

        if (
            filter_var(
                $gambar,
                FILTER_VALIDATE_URL
            )
        ) {
            return true;
        }

        $gambar = ltrim(
            $gambar,
            '/'
        );

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

    public function getHargaInteger(): int
    {
        return (int) $this->harga;
    }

    public function sudahDigunakanDalamPesanan(): bool
    {
        return $this->detailPesanans()->exists();
    }

    public function bolehDihapus(): bool
    {
        return !$this->sudahDigunakanDalamPesanan();
    }

    public function jumlahDetailPesanan(): int
    {
        return $this->detailPesanans()->count();
    }

    public function jumlahTerjual(): int
    {
        return (int) $this->detailPesanans()->sum('qty');
    }

    public function bisaDipesan(
        int $qty = 1
    ): bool {
        if ($qty < 1) {
            return false;
        }

        return $this->isTersedia()
            && $this->memilikiStok($qty);
    }

    public function getLabelStok(): string
    {
        if ($this->stokHabis()) {
            return 'Stok Habis';
        }

        if ($this->stok <= 5) {
            return 'Stok Terbatas';
        }

        return 'Tersedia';
    }

    public function getLabelStatus(): string
    {
        return $this->isTersedia()
            ? 'Tersedia'
            : 'Tidak Tersedia';
    }

    public function toPublicArray(): array
    {
        return [
            'id_oleh_oleh' => $this->id_oleh_oleh,
            'nama'         => $this->nama,
            'jenis'        => $this->jenis,
            'harga'        => $this->getHargaInteger(),
            'harga_format' => $this->formatted_harga,
            'stok'         => (int) $this->stok,
            'status'       => $this->status,
            'gambar_url'   => $this->gambar_url,
            'deskripsi'    => $this->deskripsi,
        ];
    }
}
