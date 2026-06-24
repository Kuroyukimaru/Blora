<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketBundling extends Model
{
    protected $table = 'paket_bundlings';

    protected $fillable = [
        'nama_paket',
        'untuk',
        'harga',
        'deskripsi',
        'gambar'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI MENU
    |--------------------------------------------------------------------------
    */

    public function menus()
    {
        return $this->belongsToMany(
            Menu::class,
            'paket_bundling_menus',
            'paket_bundling_id',
            'menu_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI WAHANA
    |--------------------------------------------------------------------------
    */

    public function wahanas()
    {
        return $this->belongsToMany(
            TiketWahana::class,
            'paket_bundling_wahanas',
            'paket_bundling_id',
            'tiket_wahana_id'
        );
    }
}