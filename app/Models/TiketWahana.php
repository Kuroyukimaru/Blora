<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketWahana extends Model
{
    use HasFactory;

    protected $table = 'tiket_wahanas';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'wahana',
        'ketentuan',
        'harga'
    ];

    protected $casts = [
        'harga' => 'integer'
    ];

    protected $appends = [
        'formatted_harga'
    ];

    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format(
            $this->harga,
            0,
            ',',
            '.'
        );
    }

    public function paketItems()
    {
        return $this->hasMany(
            PaketItem::class,
            'item_id'
        )->where(
            'tipe',
            'wahana'
        );
    }
}