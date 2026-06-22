<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $primaryKey = 'id';

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
        'nama_menu',
        'kategori',
        'harga',
        'deskripsi',
        'gambar',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'harga' => 'integer'
    ];

    /*
    |--------------------------------------------------------------------------
    | APPENDS
    |--------------------------------------------------------------------------
    */

    protected $appends = [
        'gambar_url',
        'formatted_harga'
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR : GAMBAR URL
    |--------------------------------------------------------------------------
    */

    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }

        return asset('images/no-image.png');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR : FORMAT HARGA
    |--------------------------------------------------------------------------
    */

    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format(
            $this->harga,
            0,
            ',',
            '.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION : PAKET ITEMS
    |--------------------------------------------------------------------------
    */

    public function paketItems()
    {
        return $this->hasMany(
            PaketItem::class,
            'item_id'
        )->where(
            'tipe',
            'menu'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : MENU TERSEDIA
    |--------------------------------------------------------------------------
    */

    public function scopeTersedia($query)
    {
        return $query->where(
            'status',
            'Tersedia'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE : FILTER KATEGORI
    |--------------------------------------------------------------------------
    */

    public function scopeKategori($query, $kategori)
    {
        return $query->where(
            'kategori',
            $kategori
        );
    }
}