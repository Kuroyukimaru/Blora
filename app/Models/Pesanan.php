<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';

    protected $primaryKey = 'id_pesanan';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'kode_pesanan',
        'nama_pelanggan',
        'no_wa',
        'metode_pembayaran',
        'total_harga',
        'status',
    ];

    protected $casts = [
        'id_pesanan'  => 'integer',
        'id_user'     => 'integer',
        'total_harga' => 'integer',
    ];

    protected $appends = [
        'formatted_total_harga',
        'status_label',
        'metode_pembayaran_label',
        'kode_pesanan_label',
        'nama_pelanggan_label',
        'no_wa_label',
        'jumlah_item',
        'jumlah_menu',
        'jumlah_wahana',
        'jumlah_oleh_oleh',
        'jumlah_bundling',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    public function details(): HasMany
    {
        return $this->hasMany(
            DetailPesanan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }

    public function detailPesanans(): HasMany
    {
        return $this->details();
    }

    public function scopeMenungguPembayaran(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'Menunggu Pembayaran'
        );
    }

    public function scopeMenungguPengambilan(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'Menunggu Pengambilan'
        );
    }

    public function scopeSelesai(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'Selesai'
        );
    }

    public function scopeBatal(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'Batal'
        );
    }

    public function scopePembayaranGagal(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            'Pembayaran Gagal'
        );
    }

    public function scopeAktif(
        Builder $query
    ): Builder {
        return $query->whereIn(
            'status',
            [
                'Menunggu Pembayaran',
                'Menunggu Pengambilan',
            ]
        );
    }

    public function scopeSudahDibayar(
        Builder $query
    ): Builder {
        return $query->whereIn(
            'status',
            [
                'Lunas',
                'Menunggu Pengambilan',
                'Selesai',
            ]
        );
    }

    public function scopePesananMenu(
        Builder $query
    ): Builder {
        return $query->whereHas(
            'details',
            function (Builder $detailQuery) {
                $detailQuery->whereNotNull(
                    'id_menu'
                );
            }
        );
    }

    public function scopePesananWahana(
        Builder $query
    ): Builder {
        return $query->whereHas(
            'details',
            function (Builder $detailQuery) {
                $detailQuery->whereNotNull(
                    'id_tiket_wahana'
                );
            }
        );
    }

    public function scopePesananOlehOleh(
        Builder $query
    ): Builder {
        return $query->whereHas(
            'details',
            function (Builder $detailQuery) {
                $detailQuery->whereNotNull(
                    'id_oleh_oleh'
                );
            }
        );
    }

    public function scopePesananBundling(
        Builder $query
    ): Builder {
        return $query->whereHas(
            'details',
            function (Builder $detailQuery) {
                $detailQuery->whereNotNull(
                    'id_paket_bundling'
                );
            }
        );
    }

    public function scopeUntukKasirMenu(
        Builder $query
    ): Builder {
        return $query->whereHas(
            'details',
            function (Builder $detailQuery) {

                $detailQuery->where(function (
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
        );
    }

    public function scopeUntukKasirWahana(
        Builder $query
    ): Builder {
        return $query->whereHas(
            'details',
            function (Builder $detailQuery) {

                $detailQuery->where(function (
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
        );
    }

    public function scopeUntukKasirOlehOleh(
        Builder $query
    ): Builder {
        return $query->whereHas(
            'details',
            function (Builder $detailQuery) {
                $detailQuery->whereNotNull(
                    'id_oleh_oleh'
                );
            }
        );
    }

    public function scopeHanyaMenu(
        Builder $query
    ): Builder {
        return $query
            ->whereHas(
                'details',
                function (Builder $detailQuery) {
                    $detailQuery->whereNotNull(
                        'id_menu'
                    );
                }
            )
            ->whereDoesntHave(
                'details',
                function (Builder $detailQuery) {
                    $detailQuery->where(function (
                        Builder $itemQuery
                    ) {

                        $itemQuery
                            ->whereNotNull(
                                'id_tiket_wahana'
                            )
                            ->orWhereNotNull(
                                'id_oleh_oleh'
                            )
                            ->orWhereNotNull(
                                'id_paket_bundling'
                            );
                    });
                }
            );
    }

    public function scopeHanyaWahana(
        Builder $query
    ): Builder {
        return $query
            ->whereHas(
                'details',
                function (Builder $detailQuery) {
                    $detailQuery->whereNotNull(
                        'id_tiket_wahana'
                    );
                }
            )
            ->whereDoesntHave(
                'details',
                function (Builder $detailQuery) {
                    $detailQuery->where(function (
                        Builder $itemQuery
                    ) {

                        $itemQuery
                            ->whereNotNull('id_menu')
                            ->orWhereNotNull(
                                'id_oleh_oleh'
                            )
                            ->orWhereNotNull(
                                'id_paket_bundling'
                            );
                    });
                }
            );
    }

    public function scopeHanyaOlehOleh(
        Builder $query
    ): Builder {
        return $query
            ->whereHas(
                'details',
                function (Builder $detailQuery) {
                    $detailQuery->whereNotNull(
                        'id_oleh_oleh'
                    );
                }
            )
            ->whereDoesntHave(
                'details',
                function (Builder $detailQuery) {
                    $detailQuery->where(function (
                        Builder $itemQuery
                    ) {

                        $itemQuery
                            ->whereNotNull('id_menu')
                            ->orWhereNotNull(
                                'id_tiket_wahana'
                            )
                            ->orWhereNotNull(
                                'id_paket_bundling'
                            );
                    });
                }
            );
    }

    public function scopeHanyaBundling(
        Builder $query
    ): Builder {
        return $query
            ->whereHas(
                'details',
                function (Builder $detailQuery) {
                    $detailQuery->whereNotNull(
                        'id_paket_bundling'
                    );
                }
            )
            ->whereDoesntHave(
                'details',
                function (Builder $detailQuery) {
                    $detailQuery->where(function (
                        Builder $itemQuery
                    ) {

                        $itemQuery
                            ->whereNotNull('id_menu')
                            ->orWhereNotNull(
                                'id_tiket_wahana'
                            )
                            ->orWhereNotNull(
                                'id_oleh_oleh'
                            );
                    });
                }
            );
    }

    public function isMenungguPembayaran(): bool
    {
        return trim((string) $this->status) === 'Menunggu Pembayaran';
    }

    public function isMenungguPengambilan(): bool
    {
        return trim((string) $this->status) === 'Menunggu Pengambilan';
    }

    public function isSelesai(): bool
    {
        return trim((string) $this->status) === 'Selesai';
    }

    public function isBatal(): bool
    {
        return trim((string) $this->status) === 'Batal';
    }

    public function isPembayaranGagal(): bool
    {
        return trim((string) $this->status) === 'Pembayaran Gagal';
    }

    public function isSudahDibayar(): bool
    {
        return in_array(
            trim((string) $this->status),
            [
                'Lunas',
                'Menunggu Pengambilan',
                'Selesai',
            ],
            true
        );
    }

    public function isAktif(): bool
    {
        return in_array(
            $this->status,
            [
                'Menunggu Pembayaran',
                'Menunggu Pengambilan',
            ],
            true
        );
    }

    public function isSiapDiambil(): bool
    {
        return $this->status === 'Menunggu Pengambilan';
    }

    public function isPesananMenu(): bool
    {
        if ($this->relationLoaded('details')) {
            return $this->details->contains(
                function ($detail) {
                    return !is_null(
                        $detail->id_menu
                    );
                }
            );
        }

        return $this->details()
            ->whereNotNull('id_menu')
            ->exists();
    }

    public function isPesananWahana(): bool
    {
        if ($this->relationLoaded('details')) {
            return $this->details->contains(
                function ($detail) {
                    return !is_null(
                        $detail->id_tiket_wahana
                    );
                }
            );
        }

        return $this->details()
            ->whereNotNull('id_tiket_wahana')
            ->exists();
    }

    public function isPesananOlehOleh(): bool
    {
        if ($this->relationLoaded('details')) {
            return $this->details->contains(
                function ($detail) {
                    return !is_null(
                        $detail->id_oleh_oleh
                    );
                }
            );
        }

        return $this->details()
            ->whereNotNull('id_oleh_oleh')
            ->exists();
    }

    public function isPesananBundling(): bool
    {
        if ($this->relationLoaded('details')) {
            return $this->details->contains(
                function ($detail) {
                    return !is_null(
                        $detail->id_paket_bundling
                    );
                }
            );
        }

        return $this->details()
            ->whereNotNull('id_paket_bundling')
            ->exists();
    }

    public function isUntukKasirMenu(): bool
    {
        if ($this->relationLoaded('details')) {

            return $this->details->contains(
                function ($detail) {

                    if ($detail->id_menu) {
                        return true;
                    }

                    if (!$detail->id_paket_bundling) {
                        return false;
                    }

                    $paket = $detail->paketBundling;

                    return $paket
                        && $paket->menus
                        && $paket->menus->isNotEmpty();
                }
            );
        }

        return $this->details()
            ->where(function (
                Builder $query
            ) {

                $query
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
            })
            ->exists();
    }

    public function isUntukKasirWahana(): bool
    {
        if ($this->relationLoaded('details')) {

            return $this->details->contains(
                function ($detail) {

                    if ($detail->id_tiket_wahana) {
                        return true;
                    }

                    if (!$detail->id_paket_bundling) {
                        return false;
                    }

                    $paket = $detail->paketBundling;

                    return $paket
                        && $paket->wahanas
                        && $paket->wahanas->isNotEmpty();
                }
            );
        }

        return $this->details()
            ->where(function (
                Builder $query
            ) {

                $query
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
            })
            ->exists();
    }

    public function isUntukKasirOlehOleh(): bool
    {
        return $this->isPesananOlehOleh();
    }

    public function getMenuDetails()
    {
        if ($this->relationLoaded('details')) {

            return $this->details
                ->filter(
                    function ($detail) {
                        return !is_null(
                            $detail->id_menu
                        );
                    }
                )
                ->values();
        }

        return $this->details()
            ->whereNotNull('id_menu')
            ->get();
    }

    public function getWahanaDetails()
    {
        if ($this->relationLoaded('details')) {

            return $this->details
                ->filter(
                    function ($detail) {
                        return !is_null(
                            $detail->id_tiket_wahana
                        );
                    }
                )
                ->values();
        }

        return $this->details()
            ->whereNotNull('id_tiket_wahana')
            ->get();
    }

    public function getOlehOlehDetails()
    {
        if ($this->relationLoaded('details')) {

            return $this->details
                ->filter(
                    function ($detail) {
                        return !is_null(
                            $detail->id_oleh_oleh
                        );
                    }
                )
                ->values();
        }

        return $this->details()
            ->whereNotNull('id_oleh_oleh')
            ->get();
    }

    public function getBundlingDetails()
    {
        if ($this->relationLoaded('details')) {
            $this->loadMissing([
                'details.paketBundling.menus',
                'details.paketBundling.wahanas',
            ]);

            return $this->details
                ->filter(
                    function ($detail) {
                        return !is_null(
                            $detail->id_paket_bundling
                        );
                    }
                )
                ->values();
        }

        return $this->details()
            ->whereNotNull('id_paket_bundling')
            ->with([
                'paketBundling.menus',
                'paketBundling.wahanas',
            ])
            ->get();
    }

    public function getKasirMenuDetails()
    {
        if ($this->relationLoaded('details')) {
            $this->loadMissing('details.paketBundling.menus');

            return $this->details
                ->filter(
                    function ($detail) {

                        if ($detail->id_menu) {
                            return true;
                        }

                        if (!$detail->id_paket_bundling) {
                            return false;
                        }

                        $paket = $detail->paketBundling;

                        return $paket
                            && $paket->menus
                            && $paket->menus->isNotEmpty();
                    }
                )
                ->values();
        }

        return $this->details()
            ->where(function (
                Builder $query
            ) {

                $query
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
            })
            ->with([
                'paketBundling.menus',
            ])
            ->get();
    }

    public function getKasirWahanaDetails()
    {
        if ($this->relationLoaded('details')) {
            $this->loadMissing('details.paketBundling.wahanas');

            return $this->details
                ->filter(
                    function ($detail) {

                        if ($detail->id_tiket_wahana) {
                            return true;
                        }

                        if (!$detail->id_paket_bundling) {
                            return false;
                        }

                        $paket = $detail->paketBundling;

                        return $paket
                            && $paket->wahanas
                            && $paket->wahanas->isNotEmpty();
                    }
                )
                ->values();
        }

        return $this->details()
            ->where(function (
                Builder $query
            ) {

                $query
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
            })
            ->with([
                'paketBundling.wahanas',
            ])
            ->get();
    }

    public function getBundlingMenuDetails()
    {
        return $this->getBundlingDetails()
            ->filter(
                function ($detail) {

                    $paket = $detail->paketBundling;

                    return $paket
                        && $paket->menus
                        && $paket->menus->isNotEmpty();
                }
            )
            ->values();
    }

    public function getBundlingWahanaDetails()
    {
        return $this->getBundlingDetails()
            ->filter(
                function ($detail) {

                    $paket = $detail->paketBundling;

                    return $paket
                        && $paket->wahanas
                        && $paket->wahanas->isNotEmpty();
                }
            )
            ->values();
    }

    public function getJumlahItemAttribute(): int
    {
        if ($this->relationLoaded('details')) {

            return (int) $this->details->sum(
                function ($detail) {
                    return (int) (
                        $detail->qty ?? 0
                    );
                }
            );
        }

        return (int) $this->details()
            ->sum('qty');
    }

    public function getJumlahMenuAttribute(): int
    {
        if ($this->relationLoaded('details')) {
            return (int) $this->details
                ->whereNotNull('id_menu')
                ->sum('qty');
        }

        return (int) $this->details()
            ->whereNotNull('id_menu')
            ->sum('qty');
    }

    public function getJumlahWahanaAttribute(): int
    {
        if ($this->relationLoaded('details')) {
            return (int) $this->details
                ->whereNotNull('id_tiket_wahana')
                ->sum('qty');
        }

        return (int) $this->details()
            ->whereNotNull('id_tiket_wahana')
            ->sum('qty');
    }

    public function getJumlahOlehOlehAttribute(): int
    {
        if ($this->relationLoaded('details')) {
            return (int) $this->details
                ->whereNotNull('id_oleh_oleh')
                ->sum('qty');
        }

        return (int) $this->details()
            ->whereNotNull('id_oleh_oleh')
            ->sum('qty');
    }

    public function getJumlahBundlingAttribute(): int
    {
        if ($this->relationLoaded('details')) {
            return (int) $this->details
                ->whereNotNull('id_paket_bundling')
                ->sum('qty');
        }

        return (int) $this->details()
            ->whereNotNull('id_paket_bundling')
            ->sum('qty');
    }

    public function bundlingMemilikiMenu(): bool
    {
        return $this->getBundlingMenuDetails()
            ->isNotEmpty();
    }

    public function bundlingMemilikiWahana(): bool
    {
        return $this->getBundlingWahanaDetails()
            ->isNotEmpty();
    }

    private function detailSelesai(
        $detail
    ): bool {
        return $detail->status_item === 'Selesai';
    }

    public function semuaDetailSelesai(): bool
    {
        if (!$this->isSudahDibayar()) {
            return false;
        }

        if ($this->relationLoaded('details')) {

            if ($this->details->isEmpty()) {
                return false;
            }

            return $this->details->every(
                function ($detail) {
                    return $this->detailSelesai(
                        $detail
                    );
                }
            );
        }

        $details = $this->details()
            ->get();

        if ($details->isEmpty()) {
            return false;
        }

        return $details->every(
            function ($detail) {
                return $this->detailSelesai(
                    $detail
                );
            }
        );
    }

    public function semuaItemSelesai(): bool
    {
        return $this->semuaDetailSelesai();
    }

    public function semuaMenuSelesai(): bool
    {
        $details = $this->getKasirMenuDetails();

        if ($details->isEmpty()) {
            return false;
        }

        return $details->every(
            function ($detail) {
                return $detail->status_item === 'Selesai';
            }
        );
    }

    public function semuaWahanaSelesai(): bool
    {
        $details = $this->getKasirWahanaDetails();

        if ($details->isEmpty()) {
            return false;
        }

        return $details->every(
            function ($detail) {
                return $detail->status_item === 'Selesai';
            }
        );
    }

    public function semuaOlehOlehSelesai(): bool
    {
        $details = $this->getOlehOlehDetails();

        if ($details->isEmpty()) {
            return false;
        }

        return $details->every(
            function ($detail) {
                return $detail->status_item === 'Selesai';
            }
        );
    }

    public function semuaBundlingSelesai(): bool
    {
        $details = $this->getBundlingDetails();

        if ($details->isEmpty()) {
            return false;
        }

        return $details->every(
            function ($detail) {
                return $detail->status_item === 'Selesai';
            }
        );
    }

    public function bolehDiverifikasiMenu(): bool
    {
        return $this->isMenungguPengambilan()
            && $this->isUntukKasirMenu();
    }

    public function bolehDiverifikasiWahana(): bool
    {
        return $this->isMenungguPengambilan()
            && $this->isUntukKasirWahana();
    }

    public function bolehDiverifikasiOlehOleh(): bool
    {
        return $this->isMenungguPengambilan()
            && $this->isPesananOlehOleh();
    }

    public function selesaikanMenu(): void
    {
        foreach ($this->getKasirMenuDetails() as $detail) {
            if ($detail->status_item !== 'Selesai') {
                $detail->update([
                    'status_item' => 'Selesai',
                ]);
            }
        }
    }

    public function selesaikanWahana(): void
    {
        foreach ($this->getKasirWahanaDetails() as $detail) {
            if ($detail->status_item !== 'Selesai') {
                $detail->update([
                    'status_item' => 'Selesai',
                ]);
            }
        }
    }

    public function selesaikanOlehOleh(): void
    {
        foreach (
            $this->getOlehOlehDetails() as $detail
        ) {

            if (
                $detail->status_item !== 'Selesai'
            ) {
                $detail->update([
                    'status_item' => 'Selesai',
                ]);
            }
        }
    }

    public function selesaikanBundling(): void
    {
        foreach (
            $this->getBundlingDetails() as $detail
        ) {

            if (
                $detail->status_item !== 'Selesai'
            ) {
                $detail->update([
                    'status_item' => 'Selesai',
                ]);
            }
        }
    }

    public function updateStatusJikaSemuaSelesai(): bool
    {
        if (!$this->semuaDetailSelesai()) {
            return false;
        }

        if ($this->status === 'Selesai') {
            return true;
        }

        $this->status = 'Selesai';

        return $this->save();
    }

    public function getFormattedTotalHargaAttribute(): string
    {
        return 'Rp ' . number_format(
            (int) ($this->total_harga ?? 0),
            0,
            ',',
            '.'
        );
    }

    public function getStatusLabelAttribute(): string
    {
        return match (trim((string) $this->status)) {
            'Menunggu Pembayaran' => 'Menunggu Pembayaran',
            'Menunggu Pengambilan' => 'Menunggu Pengambilan',
            'Pembayaran Gagal' => 'Pembayaran Gagal',
            'Selesai' => 'Selesai',
            'Batal' => 'Batal',
            default => trim((string) $this->status) !== ''
                ? trim((string) $this->status)
                : '-',
        };
    }

    public function getMetodePembayaranLabelAttribute(): string
    {
        return match (strtolower(trim((string) $this->metode_pembayaran))) {
            'cash' => 'Cash',
            'qris' => 'QRIS',
            default => trim((string) $this->metode_pembayaran) !== ''
                ? trim((string) $this->metode_pembayaran)
                : '-',
        };
    }

    public function getKodePesananLabelAttribute(): string
    {
        $kode = trim(
            (string) $this->kode_pesanan
        );

        return $kode !== ''
            ? $kode
            : '-';
    }

    public function getNamaPelangganLabelAttribute(): string
    {
        $nama = trim(
            (string) $this->nama_pelanggan
        );

        return $nama !== ''
            ? $nama
            : '-';
    }

    public function getNoWaLabelAttribute(): string
    {
        $noWa = trim(
            (string) $this->no_wa
        );

        return $noWa !== ''
            ? $noWa
            : '-';
    }

    public function batalkan(): bool
    {

        if ($this->isSelesai()) {
            return false;
        }

        if ($this->isBatal()) {
            return true;
        }

        $this->status = 'Batal';

        return $this->save();
    }

    public function hitungTotalDariDetail(): int
    {
        if ($this->relationLoaded('details')) {

            return (int) $this->details->sum(
                function ($detail) {
                    return (int) (
                        $detail->subtotal ?? 0
                    );
                }
            );
        }

        return (int) $this->details()
            ->sum('subtotal');
    }

    public function totalSesuaiDetail(): bool
    {
        return $this->getTotalHargaInteger()
            === $this->hitungTotalDariDetail();
    }

    public function getTotalHargaInteger(): int
    {
        return (int) (
            $this->total_harga ?? 0
        );
    }

    public function jumlahDetail(): int
    {
        if ($this->relationLoaded('details')) {
            return $this->details->count();
        }

        return $this->details()->count();
    }

    public function memilikiDetail(): bool
    {
        return $this->jumlahDetail() > 0;
    }

    public function tipePesanan(): string
    {
        $menu = $this->isPesananMenu();
        $wahana = $this->isPesananWahana();
        $olehOleh = $this->isPesananOlehOleh();
        $bundling = $this->isPesananBundling();

        $jenis = [];

        if ($menu) {
            $jenis[] = 'Menu';
        }

        if ($wahana) {
            $jenis[] = 'Wahana';
        }

        if ($olehOleh) {
            $jenis[] = 'Oleh-Oleh';
        }

        if ($bundling) {
            $jenis[] = 'Bundling';
        }

        if (empty($jenis)) {
            return '-';
        }

        return implode(' + ', $jenis);
    }

    public function getMetodePembayaranLabel(): string
    {
        return $this->metode_pembayaran_label;
    }

    public function bisaDiambil(): bool
    {
        return $this->isMenungguPengambilan();
    }

    public function bisaDiselesaikan(): bool
    {
        return $this->isMenungguPengambilan()
            && $this->semuaDetailSelesai();
    }
}
