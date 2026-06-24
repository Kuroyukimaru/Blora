<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OlehOleh extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'stock',
        'deskripsi',
        'gambar'
    ];
}