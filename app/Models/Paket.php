<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketItem extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table='paket_items';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable=[

        'paket_id',

        'tipe',

        'item_id'

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function paket()
    {
        return $this->belongsTo(
            Paket::class,
            'paket_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET MENU
    |--------------------------------------------------------------------------
    */

    public function menu()
    {
        return $this->belongsTo(
            Menu::class,
            'item_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET WAHANA
    |--------------------------------------------------------------------------
    */

    public function wahana()
    {
        return $this->belongsTo(
            TiketWahana::class,
            'item_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO GET ITEM
    |--------------------------------------------------------------------------
    */

    public function getItemAttribute()
    {

        if(
            $this->tipe==='menu'
        ){

            return $this->menu;

        }

        return $this->wahana;

    }

}