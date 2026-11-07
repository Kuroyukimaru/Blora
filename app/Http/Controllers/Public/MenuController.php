<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{


    public function index(Request $request): View
    {

        $query = Menu::query()
            ->where('status', 'Tersedia');

        if ($request->filled('search')) {

            $search = trim(
                (string) $request->input('search')
            );

            if ($search !== '') {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'nama_menu',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'kategori',
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
        }


        if ($request->filled('kategori')) {

            $kategori = trim(
                (string) $request->input('kategori')
            );

            if ($kategori !== '') {

                $query->where(
                    'kategori',
                    $kategori
                );
            }
        }


        $sort = $request->input(
            'sort',
            'nama_asc'
        );

        switch ($sort) {

            case 'nama_asc':

                $query->orderBy(
                    'nama_menu',
                    'asc'
                );

                break;

            case 'nama_desc':

                $query->orderBy(
                    'nama_menu',
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
                    'id_menu'
                );

                break;

            default:

                $query->orderBy(
                    'nama_menu',
                    'asc'
                );

                break;
        }


        $menus = $query->get();

        $categories = [
            'Paket Kenyang',
            'Minuman',
            'Sambal',
            'Lainnya',
        ];

        return view(
            'public.menu.index',
            compact(
                'menus',
                'categories'
            )
        );
    }

    public function show(int $id): View
    {

        $menu = Menu::query()
            ->where(
                'status',
                'Tersedia'
            )
            ->findOrFail($id);

        return view(
            'public.menu.show',
            compact('menu')
        );
    }
}