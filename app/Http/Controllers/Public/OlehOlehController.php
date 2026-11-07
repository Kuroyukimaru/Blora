<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\OlehOleh;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OlehOlehController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    | Menampilkan seluruh oleh-oleh yang tersedia untuk public.
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
        | Hanya oleh-oleh dengan status Tersedia
        | yang ditampilkan kepada public.
        |
        */

        $query = OlehOleh::query()
            ->where('status', 'Tersedia');


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        |
        | Public dapat mencari berdasarkan:
        | - nama oleh-oleh
        | - jenis
        | - deskripsi
        |
        */

        if ($request->filled('search')) {

            $search = trim(
                (string) $request->input('search')
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'jenis',
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
        | FILTER JENIS
        |--------------------------------------------------------------------------
        |
        | Public dapat memfilter berdasarkan jenis oleh-oleh.
        |
        */

        if ($request->filled('jenis')) {

            $jenis = trim(
                (string) $request->input('jenis')
            );

            $query->where(
                'jenis',
                $jenis
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
                    'nama',
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
                    'id_oleh_oleh'
                );

                break;


            default:

                $query->orderBy(
                    'nama',
                    'asc'
                );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $olehOleh = $query->get();


        /*
        |--------------------------------------------------------------------------
        | JENIS OPTIONS
        |--------------------------------------------------------------------------
        |
        | Mengambil daftar jenis dari data oleh-oleh
        | yang tersedia agar filter bersifat dinamis.
        |
        */

        $jenisOptions = OlehOleh::query()
            ->where('status', 'Tersedia')
            ->whereNotNull('jenis')
            ->where('jenis', '!=', '')
            ->select('jenis')
            ->distinct()
            ->orderBy('jenis', 'asc')
            ->pluck('jenis');


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'public.oleholeh.index',
            compact(
                'olehOleh',
                'jenisOptions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    | Menampilkan detail satu produk oleh-oleh.
    |--------------------------------------------------------------------------
    */

    public function show(int $id): View
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL OLEH-OLEH
        |--------------------------------------------------------------------------
        |
        | Public hanya dapat melihat produk yang
        | statusnya masih Tersedia.
        |
        */

        $olehOleh = OlehOleh::query()
            ->where(
                'status',
                'Tersedia'
            )
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'public.oleholeh.show',
            compact('olehOleh')
        );
    }
}