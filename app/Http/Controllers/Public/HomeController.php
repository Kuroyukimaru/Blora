<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Menu;
use App\Models\OlehOleh;
use App\Models\PaketBundling;
use App\Models\TiketWahana;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Halaman utama Public.
     *
     * Public hanya dapat melihat data:
     * - Menu
     * - Tiket Wahana
     * - Oleh-Oleh
     * - Paket Bundling
     * - Event
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        |
        | Hanya menu dengan status Tersedia
        | yang ditampilkan kepada public.
        |
        */

        $menus = Menu::query()
            ->where('status', 'Tersedia')
            ->orderBy('nama_menu', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TIKET WAHANA
        |--------------------------------------------------------------------------
        |
        | Hanya tiket wahana yang tersedia.
        |
        */

        $tiketWahanas = TiketWahana::query()
            ->where('status', 'Tersedia')
            ->orderBy('nama_wahana', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | OLEH-OLEH
        |--------------------------------------------------------------------------
        |
        | Hanya oleh-oleh dengan status Tersedia.
        |
        */

        $olehOleh = OlehOleh::query()
            ->where('status', 'Tersedia')
            ->orderBy('nama', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PAKET BUNDLING
        |--------------------------------------------------------------------------
        |
        | Hanya paket bundling yang tersedia.
        |
        | Relasi:
        | - menus
        | - wahanas
        |
        | ikut diambil agar isi paket dapat langsung
        | digunakan pada halaman Home.
        |
        */

        $paketBundlings = PaketBundling::query()
            ->where('status', 'Tersedia')
            ->with([
                'menus',
                'wahanas',
            ])
            ->orderBy('nama_paket', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        |
        | Event yang ditampilkan:
        | - Event hari ini
        | - Event yang akan datang
        |
        | Event yang sudah lewat tidak ditampilkan.
        |
        */

        $events = Event::query()
            ->whereDate(
                'tanggal',
                '>=',
                today()
            )
            ->orderBy('tanggal', 'asc')
            ->orderBy('id_event', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        |
        | Semua data dikirim ke:
        |
        | resources/views/public/home.blade.php
        |
        */

        return view(
            'public.home',
            compact(
                'menus',
                'tiketWahanas',
                'olehOleh',
                'paketBundlings',
                'events'
            )
        );
    }
}