<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    | Menampilkan seluruh event yang akan datang untuk public.
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
        | Hanya event dengan tanggal hari ini atau setelah hari ini
        | yang ditampilkan kepada public.
        |
        */

        $query = Event::query()
            ->whereDate('tanggal', '>=', today());


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        |
        | Public dapat mencari berdasarkan:
        | - judul event
        | - deskripsi
        |
        */

        if ($request->filled('search')) {

            $search = trim(
                (string) $request->input('search')
            );

            $query->where(function ($q) use ($search) {

                $q->where(
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
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        |
        | Public dapat memfilter event berdasarkan:
        | - semua
        | - hari ini
        | - mendatang
        |
        */

        $filter = $request->input(
            'filter',
            'semua'
        );

        switch ($filter) {

            case 'hari_ini':

                $query->whereDate(
                    'tanggal',
                    today()
                );

                break;


            case 'mendatang':

                $query->whereDate(
                    'tanggal',
                    '>',
                    today()
                );

                break;


            default:

                $query->whereDate(
                    'tanggal',
                    '>=',
                    today()
                );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        |
        | Pilihan:
        | - tanggal_asc
        | - tanggal_desc
        | - terbaru
        |
        */

        $sort = $request->input(
            'sort',
            'tanggal_asc'
        );

        switch ($sort) {

            case 'tanggal_desc':

                $query->orderBy(
                    'tanggal',
                    'desc'
                );

                break;


            case 'terbaru':

                $query->orderByDesc(
                    'id_event'
                );

                break;


            default:

                $query->orderBy(
                    'tanggal',
                    'asc'
                );

                $query->orderBy(
                    'id_event',
                    'asc'
                );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $events = $query->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'public.event.index',
            compact('events')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    | Menampilkan detail satu event.
    |--------------------------------------------------------------------------
    */

    public function show(int $id): View
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL EVENT
        |--------------------------------------------------------------------------
        |
        | Public hanya dapat melihat event yang tanggalnya
        | hari ini atau masih akan datang.
        |
        */

        $event = Event::query()
            ->whereDate(
                'tanggal',
                '>=',
                today()
            )
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'public.event.show',
            compact('event')
        );
    }
}