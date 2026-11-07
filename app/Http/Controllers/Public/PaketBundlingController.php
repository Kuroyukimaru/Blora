<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PaketBundling;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaketBundlingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    | Menampilkan seluruh paket bundling yang tersedia untuk public.
    |
    | Public hanya dapat melihat data.
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        |
        | Hanya paket bundling dengan status Tersedia
        | yang ditampilkan kepada public.
        |
        | Relasi menu dan wahana ikut diambil agar
        | komponen paket dapat ditampilkan di halaman.
        |
        */

        $query = PaketBundling::query()
            ->where('status', 'Tersedia')
            ->with([
                'menus',
                'wahanas',
            ]);


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        |
        | Public dapat mencari berdasarkan:
        | - nama paket
        | - untuk
        | - deskripsi
        |
        */

        if ($request->filled('search')) {

            $search = trim(
                (string) $request->input('search')
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_paket',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'untuk',
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
        | FILTER UNTUK
        |--------------------------------------------------------------------------
        |
        | Digunakan untuk memfilter paket berdasarkan
        | target/peruntukan paket.
        |
        */

        if ($request->filled('untuk')) {

            $untuk = trim(
                (string) $request->input('untuk')
            );

            $query->where(
                'untuk',
                $untuk
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        |
        | Pilihan:
        | - nama_asc
        | - nama_desc
        | - harga_asc
        | - harga_desc
        | - terbaru
        |
        */

        $sort = $request->input(
            'sort',
            'nama_asc'
        );

        switch ($sort) {

            case 'nama_desc':

                $query->orderBy(
                    'nama_paket',
                    'desc'
                );

                break;


            case 'harga_asc':

                $query->orderBy(
                    'harga',
                    'asc'
                );

                break;


            case 'harga_desc':

                $query->orderBy(
                    'harga',
                    'desc'
                );

                break;


            case 'terbaru':

                $query->orderByDesc(
                    'id_paket_bundling'
                );

                break;


            default:

                $query->orderBy(
                    'nama_paket',
                    'asc'
                );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $paketBundlings = $query->get();


        /*
        |--------------------------------------------------------------------------
        | UNTUK OPTIONS
        |--------------------------------------------------------------------------
        |
        | Mengambil daftar peruntukan paket secara dinamis
        | dari paket bundling yang tersedia.
        |
        */

        $untukOptions = PaketBundling::query()
            ->where('status', 'Tersedia')
            ->whereNotNull('untuk')
            ->where('untuk', '!=', '')
            ->select('untuk')
            ->distinct()
            ->orderBy('untuk', 'asc')
            ->pluck('untuk');


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'public.paketbundling.index',
            compact(
                'paketBundlings',
                'untukOptions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    | Menampilkan detail satu paket bundling.
    |--------------------------------------------------------------------------
    */

    public function show(int $id): View
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL PAKET BUNDLING
        |--------------------------------------------------------------------------
        |
        | Public hanya dapat melihat paket bundling
        | yang statusnya masih Tersedia.
        |
        | Relasi menu dan wahana juga diambil untuk
        | menampilkan isi dari paket.
        |
        */

        $paketBundling = PaketBundling::query()
            ->where('status', 'Tersedia')
            ->with([
                'menus',
                'wahanas',
            ])
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'public.paketbundling.show',
            compact('paketBundling')
        );
    }
}