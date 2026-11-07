<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanans';

    protected $primaryKey = 'id_detail_pesanan';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'id_pesanan',
        'id_menu',
        'id_tiket_wahana',
        'id_oleh_oleh',
        'id_paket_bundling',
        'qty',
        'harga',
        'subtotal',
        'status_item',
        'status_menu_bundling',
        'status_wahana_bundling',
        'status_pembayaran_menu_bundling',
        'status_pembayaran_wahana_bundling',
    ];

    protected $casts = [
        'id_detail_pesanan' => 'integer',
        'id_pesanan'        => 'integer',
        'id_menu'           => 'integer',
        'id_tiket_wahana'   => 'integer',
        'id_oleh_oleh'      => 'integer',
        'id_paket_bundling' => 'integer',
        'qty'               => 'integer',
        'harga'             => 'integer',
        'subtotal'          => 'integer',
    ];

    protected $appends = [
        'formatted_harga',
        'formatted_subtotal',
        'jenis_item',
        'nama_item',
        'status_label',
        'jumlah_item',
        'bundling_memiliki_menu',
        'bundling_memiliki_wahana',
        'bundling_menu_selesai',
        'bundling_wahana_selesai',
        'bundling_selesai',
    ];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(
            Pesanan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(
            Menu::class,
            'id_menu',
            'id_menu'
        );
    }

    public function tiketWahana(): BelongsTo
    {
        return $this->belongsTo(
            TiketWahana::class,
            'id_tiket_wahana',
            'id_tiket_wahana'
        );
    }

    public function olehOleh(): BelongsTo
    {
        return $this->belongsTo(
            OlehOleh::class,
            'id_oleh_oleh',
            'id_oleh_oleh'
        );
    }

    public function paketBundling(): BelongsTo
    {
        return $this->belongsTo(
            PaketBundling::class,
            'id_paket_bundling',
            'id_paket_bundling'
        );
    }

    public function scopeMenu(
        Builder $query
    ): Builder {
        return $query->whereNotNull('id_menu');
    }

    public function scopeTiketWahana(
        Builder $query
    ): Builder {
        return $query->whereNotNull(
            'id_tiket_wahana'
        );
    }

    public function scopeOlehOleh(
        Builder $query
    ): Builder {
        return $query->whereNotNull(
            'id_oleh_oleh'
        );
    }

    public function scopeBundling(
        Builder $query
    ): Builder {
        return $query->whereNotNull(
            'id_paket_bundling'
        );
    }

    public function scopeMenunggu(
        Builder $query
    ): Builder {
        return $query->where(
            'status_item',
            'Menunggu'
        );
    }

    public function scopeDiproses(
        Builder $query
    ): Builder {
        return $query->where(
            'status_item',
            'Diproses'
        );
    }

    public function scopeSelesai(
        Builder $query
    ): Builder {
        return $query->where(
            'status_item',
            'Selesai'
        );
    }

    public function scopePesanan(
        Builder $query,
        int $idPesanan
    ): Builder {
        return $query->where(
            'id_pesanan',
            $idPesanan
        );
    }

    public function scopeUntukKasirMenu(
        Builder $query
    ): Builder {
        return $query->where(function (
            Builder $itemQuery
        ) {

            $itemQuery
                ->whereNotNull('id_menu')
                ->orWhere(function (
                    Builder $bundleQuery
                ) {

                    $bundleQuery
                        ->whereNotNull(
                            'id_paket_bundling'
                        )
                        ->whereHas(
                            'paketBundling.menus'
                        );
                });
        });
    }

    public function scopeUntukKasirWahana(
        Builder $query
    ): Builder {
        return $query->where(function (
            Builder $itemQuery
        ) {

            $itemQuery
                ->whereNotNull(
                    'id_tiket_wahana'
                )
                ->orWhere(function (
                    Builder $bundleQuery
                ) {

                    $bundleQuery
                        ->whereNotNull(
                            'id_paket_bundling'
                        )
                        ->whereHas(
                            'paketBundling.wahanas'
                        );
                });
        });
    }

    public function scopeUntukKasirOlehOleh(
        Builder $query
    ): Builder {
        return $query->whereNotNull(
            'id_oleh_oleh'
        );
    }

    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format(
            (int) ($this->harga ?? 0),
            0,
            ',',
            '.'
        );
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format(
            (int) ($this->subtotal ?? 0),
            0,
            ',',
            '.'
        );
    }

    public function getJenisItemAttribute(): string
    {
        if ($this->isMenu()) {
            return 'Menu';
        }

        if ($this->isTiketWahana()) {
            return 'Tiket Wahana';
        }

        if ($this->isOlehOleh()) {
            return 'Oleh-Oleh';
        }

        if ($this->isPaketBundling()) {
            return 'Paket Bundling';
        }

        return 'Tidak Diketahui';
    }

    public function getNamaItemAttribute(): string
    {
        if ($this->isMenu()) {
            return $this->menu?->nama_menu ?? '-';
        }

        if ($this->isTiketWahana()) {

            $item = $this->tiketWahana;

            if (!$item) {
                return '-';
            }

            return $item->nama_wahana
                ?? $item->nama_tiket
                ?? $item->nama
                ?? '-';
        }

        if ($this->isOlehOleh()) {

            $item = $this->olehOleh;

            if (!$item) {
                return '-';
            }

            return $item->nama
                ?? $item->nama_oleh_oleh
                ?? $item->nama_produk
                ?? '-';
        }

        if ($this->isPaketBundling()) {

            $item = $this->paketBundling;

            if (!$item) {
                return '-';
            }

            return $item->nama_paket
                ?? $item->nama_paket_bundling
                ?? $item->nama
                ?? '-';
        }

        return '-';
    }

    public function isMenu(): bool
    {
        return !is_null(
            $this->id_menu
        );
    }

    public function isTiketWahana(): bool
    {
        return !is_null(
            $this->id_tiket_wahana
        );
    }

    public function isOlehOleh(): bool
    {
        return !is_null(
            $this->id_oleh_oleh
        );
    }

    public function isPaketBundling(): bool
    {
        return !is_null(
            $this->id_paket_bundling
        );
    }

    public function isItemValid(): bool
    {
        $jumlahJenisItem = count(array_filter([
            $this->id_menu,
            $this->id_tiket_wahana,
            $this->id_oleh_oleh,
            $this->id_paket_bundling,
        ], static function ($id) {
            return $id !== null;
        }));

        return $jumlahJenisItem === 1;
    }

    public function isUntukKasirMenu(): bool
    {
        if ($this->isMenu()) {
            return true;
        }

        if (!$this->isPaketBundling()) {
            return false;
        }

        return $this->bundlingMemilikiMenu();
    }

    public function isUntukKasirWahana(): bool
    {
        if ($this->isTiketWahana()) {
            return true;
        }

        if (!$this->isPaketBundling()) {
            return false;
        }

        return $this->bundlingMemilikiWahana();
    }

    public function isUntukKasirOlehOleh(): bool
    {
        return $this->isOlehOleh();
    }

    public function isMenunggu(): bool
    {
        return trim((string) $this->status_item) === 'Menunggu';
    }

    public function isDiproses(): bool
    {
        return trim((string) $this->status_item) === 'Diproses';
    }

    public function isSelesai(): bool
    {
        return trim((string) $this->status_item) === 'Selesai';
    }

    public function isStatus(string $status): bool
    {
        return trim((string) $this->status_item) === trim($status);
    }

    public function bundlingMemilikiMenu(): bool
    {
        if (!$this->isPaketBundling()) {
            return false;
        }

        $paket = $this->paketBundling;

        if (!$paket) {
            return false;
        }

        if (
            $paket->relationLoaded('menus')
        ) {
            return $paket->menus->isNotEmpty();
        }

        return $paket->menus()->exists();
    }

    public function bundlingMemilikiWahana(): bool
    {
        if (!$this->isPaketBundling()) {
            return false;
        }

        $paket = $this->paketBundling;

        if (!$paket) {
            return false;
        }

        if (
            $paket->relationLoaded('wahanas')
        ) {
            return $paket->wahanas->isNotEmpty();
        }

        return $paket->wahanas()->exists();
    }

    public function bundlingMenuSelesai(): bool
    {
        if (!$this->isPaketBundling()) {
            return false;
        }

        if (!$this->bundlingMemilikiMenu()) {
            return true;
        }

        return ($this->status_menu_bundling ?? 'Menunggu') === 'Selesai';
    }

    public function bundlingWahanaSelesai(): bool
    {
        if (!$this->isPaketBundling()) {
            return false;
        }

        if (!$this->bundlingMemilikiWahana()) {
            return true;
        }

        return ($this->status_wahana_bundling ?? 'Menunggu') === 'Selesai';
    }

    public function bundlingSelesai(): bool
    {
        if (!$this->isPaketBundling()) {
            return false;
        }

        $hasMenu = $this->bundlingMemilikiMenu();
        $hasWahana = $this->bundlingMemilikiWahana();

        if (!$hasMenu && !$hasWahana) {
            return false;
        }

        return (!$hasMenu || $this->bundlingMenuSelesai())
            && (!$hasWahana || $this->bundlingWahanaSelesai());
    }

    public function bolehDiproses(): bool
    {
        return $this->isMenunggu();
    }

    public function mulaiDiproses(): bool
    {
        if (!$this->bolehDiproses()) {
            return false;
        }

        $this->status_item = 'Diproses';

        return $this->save();
    }

    public function bolehDiselesaikan(): bool
    {
        return $this->isMenunggu() || $this->isDiproses();
    }

    public function selesaikan(): bool
    {
        if ($this->isPaketBundling()) {
            return $this->sinkronkanStatusBundling();
        }

        if ($this->isSelesai()) {
            return true;
        }

        if (!$this->bolehDiselesaikan()) {
            return false;
        }

        $this->status_item = 'Selesai';

        return $this->save();
    }

    public function mulaiDiprosesKasirMenu(): bool
    {
        if (!$this->isUntukKasirMenu()) {
            return false;
        }

        if (!$this->isPaketBundling()) {
            return $this->mulaiDiproses();
        }

        if (!$this->bundlingMemilikiMenu() || $this->bundlingMenuSelesai()) {
            return false;
        }

        $this->status_menu_bundling = 'Diproses';

        if (!$this->save()) {
            return false;
        }

        return $this->sinkronkanStatusBundling();
    }

    public function selesaikanKasirMenu(): bool
    {
        if (!$this->isUntukKasirMenu()) {
            return false;
        }

        if (!$this->isPaketBundling()) {
            return $this->selesaikan();
        }

        if (!$this->bundlingMemilikiMenu()) {
            return false;
        }

        if ($this->bundlingMenuSelesai()) {
            return $this->sinkronkanStatusBundling();
        }

        $this->status_menu_bundling = 'Selesai';

        if (!$this->save()) {
            return false;
        }

        return $this->sinkronkanStatusBundling();
    }

    public function mulaiDiprosesKasirWahana(): bool
    {
        if (!$this->isUntukKasirWahana()) {
            return false;
        }

        if (!$this->isPaketBundling()) {
            return $this->mulaiDiproses();
        }

        if (!$this->bundlingMemilikiWahana() || $this->bundlingWahanaSelesai()) {
            return false;
        }

        $this->status_wahana_bundling = 'Diproses';

        if (!$this->save()) {
            return false;
        }

        return $this->sinkronkanStatusBundling();
    }

    public function selesaikanKasirWahana(): bool
    {
        if (!$this->isUntukKasirWahana()) {
            return false;
        }

        if (!$this->isPaketBundling()) {
            return $this->selesaikan();
        }

        if (!$this->bundlingMemilikiWahana()) {
            return false;
        }

        if ($this->bundlingWahanaSelesai()) {
            return $this->sinkronkanStatusBundling();
        }

        $this->status_wahana_bundling = 'Selesai';

        if (!$this->save()) {
            return false;
        }

        return $this->sinkronkanStatusBundling();
    }

    public function mulaiDiprosesKasirOlehOleh(): bool
    {
        if (!$this->isUntukKasirOlehOleh()) {
            return false;
        }

        return $this->mulaiDiproses();
    }

    public function selesaikanKasirOlehOleh(): bool
    {
        if (!$this->isUntukKasirOlehOleh()) {
            return false;
        }

        return $this->selesaikan();
    }

    public function sinkronkanStatusBundling(): bool
    {
        if (!$this->isPaketBundling()) {
            return false;
        }

        if ($this->bundlingSelesai()) {
            $targetStatus = 'Selesai';
        } else {
            $menuDiproses = $this->bundlingMemilikiMenu()
                && ($this->status_menu_bundling ?? 'Menunggu') === 'Diproses';

            $wahanaDiproses = $this->bundlingMemilikiWahana()
                && ($this->status_wahana_bundling ?? 'Menunggu') === 'Diproses';

            $targetStatus = ($menuDiproses || $wahanaDiproses)
                ? 'Diproses'
                : 'Menunggu';
        }

        if ($this->status_item !== $targetStatus) {
            $this->status_item = $targetStatus;
        }

        return $this->save();
    }

    public function getBundlingMemilikiMenuAttribute(): bool
    {
        return $this->bundlingMemilikiMenu();
    }

    public function getBundlingMemilikiWahanaAttribute(): bool
    {
        return $this->bundlingMemilikiWahana();
    }

    public function getBundlingMenuSelesaiAttribute(): bool
    {
        return $this->bundlingMenuSelesai();
    }

    public function getBundlingWahanaSelesaiAttribute(): bool
    {
        return $this->bundlingWahanaSelesai();
    }

    public function getBundlingSelesaiAttribute(): bool
    {
        return $this->bundlingSelesai();
    }

    public function getJumlahItemAttribute(): int
    {
        return max(
            0,
            (int) ($this->qty ?? 0)
        );
    }

    public function calculateSubtotal(): int
    {
        return (int) ($this->qty ?? 0)
            * (int) ($this->harga ?? 0);
    }

    public function isSubtotalValid(): bool
    {
        return (int) ($this->subtotal ?? 0)
            === $this->calculateSubtotal();
    }

    public function updateSubtotal(): bool
    {
        $this->subtotal = $this->calculateSubtotal();

        return $this->save();
    }

    public function getTotalAttribute(): int
    {
        return (int) ($this->subtotal ?? 0);
    }

    public function isQtyValid(): bool
    {
        return (int) $this->qty > 0;
    }

    public function isHargaValid(): bool
    {
        return $this->harga !== null
            && is_numeric($this->harga)
            && (int) $this->harga >= 0;
    }

    public function isDetailValid(): bool
    {
        return $this->isItemValid()
            && $this->isQtyValid()
            && $this->isHargaValid()
            && $this->isSubtotalValid();
    }

    public function menuSudahSelesai(): bool
    {
        if ($this->isMenu()) {
            return $this->isSelesai();
        }

        if ($this->isPaketBundling()) {
            return $this->bundlingMenuSelesai();
        }

        return false;
    }

    public function wahanaSudahSelesai(): bool
    {
        if ($this->isTiketWahana()) {
            return $this->isSelesai();
        }

        if ($this->isPaketBundling()) {
            return $this->bundlingWahanaSelesai();
        }

        return false;
    }

    public function olehOlehSudahSelesai(): bool
    {
        return $this->isOlehOleh()
            && $this->isSelesai();
    }

    public function bundlingSudahSelesai(): bool
    {
        return $this->isPaketBundling()
            && $this->bundlingSelesai();
    }

    public function getStatusLabelAttribute(): string
    {
        $status = trim((string) $this->status_item);

        return match ($status) {
            'Menunggu' => 'Menunggu',
            'Diproses' => 'Diproses',
            'Selesai' => 'Selesai',
            default => $status !== '' ? $status : '-',
        };
    }

    public function getJenisSingkatAttribute(): string
    {
        return match ($this->jenis_item) {
            'Tiket Wahana'   => 'Wahana',
            'Paket Bundling' => 'Bundling',
            'Oleh-Oleh'      => 'Oleh-Oleh',
            'Menu'           => 'Menu',
            default          => '-',
        };
    }

    public function toPublicArray(): array
    {
        return [
            'id_detail_pesanan' => $this->id_detail_pesanan,
            'id_pesanan'        => $this->id_pesanan,
            'jenis_item'        => $this->jenis_item,
            'nama_item'         => $this->nama_item,
            'qty'               => (int) $this->qty,
            'harga'             => (int) $this->harga,
            'subtotal'          => (int) $this->subtotal,
            'harga_format'      => $this->formatted_harga,
            'subtotal_format'   => $this->formatted_subtotal,
            'status_item'       => $this->status_item,
            'status_label'      => $this->status_label,
            'status_menu_bundling' => $this->status_menu_bundling,
            'status_wahana_bundling' => $this->status_wahana_bundling,
            'status_pembayaran_menu_bundling' => $this->status_pembayaran_menu_bundling,
            'status_pembayaran_wahana_bundling' => $this->status_pembayaran_wahana_bundling,
            'bundling_memiliki_menu'
                => $this->bundling_memiliki_menu,
            'bundling_memiliki_wahana'
                => $this->bundling_memiliki_wahana,
            'bundling_menu_selesai'
                => $this->bundling_menu_selesai,
            'bundling_wahana_selesai'
                => $this->bundling_wahana_selesai,
            'bundling_selesai'
                => $this->bundling_selesai,
        ];
    }
}
