<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;

class Event extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'events';


    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id_event';

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
        'judul',
        'tanggal',
        'deskripsi',
        'gambar',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'id_event' => 'integer',
        'id_user'  => 'integer',
        'tanggal'  => 'date',
    ];


    /*
    |--------------------------------------------------------------------------
    | APPENDED ATTRIBUTES
    |--------------------------------------------------------------------------
    |
    | Attribute berikut otomatis tersedia ketika model
    | dikonversi menjadi array atau JSON.
    |
    */

    protected $appends = [
        'gambar_url',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP : USER / ADMIN
    |--------------------------------------------------------------------------
    |
    | events.id_user
    |        ↓
    | users.id_user
    |
    | Event menyimpan ID Admin yang membuat event.
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
    | ACCESSOR : GAMBAR URL
    |--------------------------------------------------------------------------
    |
    | Gambar event disimpan pada:
    |
    | public/uploads/event/
    |
    | Contoh nilai database:
    |
    | event_20260921.jpg
    |
    | URL:
    |
    | /uploads/event/event_20260921.jpg
    |
    | Jika gambar tidak tersedia, gunakan gambar default.
    |
    */

    public function getGambarUrlAttribute(): string
    {
        /*
        |--------------------------------------------------------------------------
        | CEK DATA GAMBAR
        |--------------------------------------------------------------------------
        */

        if (
            empty($this->gambar) ||
            !is_string($this->gambar)
        ) {
            return asset('images/no-image.png');
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN PATH
        |--------------------------------------------------------------------------
        */

        $gambar = trim(
            $this->gambar
        );

        $gambar = ltrim(
            $gambar,
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | HAPUS PREFIX UPLOADS/EVENT
        |--------------------------------------------------------------------------
        |
        | Jika database menyimpan:
        |
        | uploads/event/foto.jpg
        |
        | maka cukup gunakan:
        |
        | foto.jpg
        |
        */

        if (
            str_starts_with(
                $gambar,
                'uploads/event/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('uploads/event/')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS PREFIX PUBLIC
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | public/uploads/event/foto.jpg
        |
        */

        if (
            str_starts_with(
                $gambar,
                'public/uploads/event/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('public/uploads/event/')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS PREFIX STORAGE
        |--------------------------------------------------------------------------
        |
        | Jika suatu saat data disimpan sebagai:
        |
        | storage/event/foto.jpg
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
        | PATH FILE
        |--------------------------------------------------------------------------
        */

        $path = public_path(
            'uploads/event/' . $gambar
        );


        /*
        |--------------------------------------------------------------------------
        | CEK FILE
        |--------------------------------------------------------------------------
        */

        if (!File::exists($path)) {
            return asset('images/no-image.png');
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE URL
        |--------------------------------------------------------------------------
        */

        return asset(
            'uploads/event/' . $gambar
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : EVENT AKAN DATANG
    |--------------------------------------------------------------------------
    |
    | Mengambil event:
    |
    | - hari ini
    | - tanggal setelah hari ini
    |
    | Contoh:
    |
    | Event::akanDatang()->get();
    |
    */

    public function scopeAkanDatang(
        Builder $query
    ): Builder {
        return $query
            ->whereDate(
                'tanggal',
                '>=',
                today()
            )
            ->orderBy(
                'tanggal',
                'asc'
            )
            ->orderBy(
                'id_event',
                'asc'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : EVENT SUDAH LEWAT
    |--------------------------------------------------------------------------
    |
    | Mengambil event yang tanggalnya sudah lewat.
    |
    | Contoh:
    |
    | Event::sudahLewat()->get();
    |
    */

    public function scopeSudahLewat(
        Builder $query
    ): Builder {
        return $query
            ->whereDate(
                'tanggal',
                '<',
                today()
            )
            ->orderByDesc(
                'tanggal'
            )
            ->orderByDesc(
                'id_event'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : EVENT HARI INI
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | Event::hariIni()->get();
    |
    */

    public function scopeHariIni(
        Builder $query
    ): Builder {
        return $query
            ->whereDate(
                'tanggal',
                today()
            )
            ->orderBy(
                'id_event',
                'asc'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : EVENT TERBARU
    |--------------------------------------------------------------------------
    |
    | Event terbaru berdasarkan waktu pembuatan data.
    |
    | Contoh:
    |
    | Event::terbaru()->get();
    |
    */

    public function scopeTerbaru(
        Builder $query
    ): Builder {
        return $query
            ->orderByDesc(
                'created_at'
            )
            ->orderByDesc(
                'id_event'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : BERDASARKAN TANGGAL
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | Event::tanggal('2026-09-21')->get();
    |
    */

    public function scopeTanggal(
        Builder $query,
        string|Carbon $tanggal
    ): Builder {
        return $query->whereDate(
            'tanggal',
            $tanggal
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : BERDASARKAN BULAN
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | Event::bulan(9, 2026)->get();
    |
    */

    public function scopeBulan(
        Builder $query,
        int $bulan,
        int $tahun
    ): Builder {
        return $query
            ->whereMonth(
                'tanggal',
                $bulan
            )
            ->whereYear(
                'tanggal',
                $tahun
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPE : SEARCH
    |--------------------------------------------------------------------------
    |
    | Mencari event berdasarkan:
    |
    | - judul
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

        if ($search === '') {
            return $query;
        }

        return $query->where(function (Builder $query) use ($search) {

            $query
                ->where(
                    'judul',
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
    | HELPER : MEMILIKI GAMBAR
    |--------------------------------------------------------------------------
    |
    | Mengecek apakah file gambar event benar-benar
    | tersedia pada public/uploads/event/.
    |
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

        $gambar = ltrim(
            $gambar,
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN PREFIX
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $gambar,
                'uploads/event/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('uploads/event/')
            );
        }

        if (
            str_starts_with(
                $gambar,
                'public/uploads/event/'
            )
        ) {
            $gambar = substr(
                $gambar,
                strlen('public/uploads/event/')
            );
        }

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
        | CEK FILE
        |--------------------------------------------------------------------------
        */

        return File::exists(
            public_path(
                'uploads/event/' . $gambar
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : EVENT SUDAH BERLALU
    |--------------------------------------------------------------------------
    */

    public function sudahBerlalu(): bool
    {
        if (!$this->tanggal) {
            return false;
        }

        return $this->tanggal->isBefore(
            today()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : EVENT HARI INI
    |--------------------------------------------------------------------------
    */

    public function hariIni(): bool
    {
        if (!$this->tanggal) {
            return false;
        }

        return $this->tanggal->isToday();
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : EVENT AKAN DATANG
    |--------------------------------------------------------------------------
    |
    | Hari ini dianggap sebagai event yang masih aktif.
    |
    */

    public function akanDatang(): bool
    {
        if (!$this->tanggal) {
            return false;
        }

        return $this->tanggal->greaterThanOrEqualTo(
            today()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : EVENT AKAN DATANG / AKTIF
    |--------------------------------------------------------------------------
    */

    public function isAkanDatang(): bool
    {
        return $this->akanDatang();
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : EVENT SUDAH LEWAT
    |--------------------------------------------------------------------------
    */

    public function isSudahLewat(): bool
    {
        return $this->sudahBerlalu();
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER : EVENT HARI INI
    |--------------------------------------------------------------------------
    */

    public function isHariIni(): bool
    {
        return $this->hariIni();
    }
}