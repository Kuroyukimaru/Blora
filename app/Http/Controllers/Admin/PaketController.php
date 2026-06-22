<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Paket;
use App\Models\PaketItem;
use App\Models\Menu;
use App\Models\TiketWahana;

class PaketController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $pakets = Paket::with(
            [
                'items.menu',
                'items.wahana'
            ]
        )
        ->latest()
        ->get();

        return view(
            'admin.paket.index',
            compact('pakets')
        );

    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {

        $menus = Menu::tersedia()
                    ->get();

        $wahanas = TiketWahana::all();

        return view(
            'admin.paket.create',
            compact(
                'menus',
                'wahanas'
            )
        );

    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([

            'nama_paket'=>'required',

            'harga'=>'required',

            'gambar'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ]);

        /*
        --------------------------------
        FORMAT HARGA
        --------------------------------
        */

        $harga = str_replace(
            '.',
            '',
            $request->harga
        );

        /*
        --------------------------------
        IMAGE
        --------------------------------
        */

        $gambar = null;

        if(
            $request->hasFile(
                'gambar'
            )
        ){

            Storage::disk('public')
            ->makeDirectory(
                'paket'
            );

            $gambar = $request
            ->file('gambar')
            ->store(
                'paket',
                'public'
            );

        }

        /*
        --------------------------------
        CREATE PAKET
        --------------------------------
        */

        $paket = Paket::create([

            'nama_paket'=>$request->nama_paket,

            'harga'=>$harga,

            'gambar'=>$gambar,

            'deskripsi'=>$request->deskripsi,

            'status'=>$request->status
                ?? 'Aktif'

        ]);

        /*
        --------------------------------
        MENU
        --------------------------------
        */

        if(
            $request->menus
        ){

            foreach(
                $request->menus
                as
                $menu
            ){

                PaketItem::create([

                    'paket_id'=>$paket->id,

                    'tipe'=>'menu',

                    'item_id'=>$menu

                ]);

            }

        }

        /*
        --------------------------------
        WAHANA
        --------------------------------
        */

        if(
            $request->wahanas
        ){

            foreach(
                $request->wahanas
                as
                $wahana
            ){

                PaketItem::create([

                    'paket_id'=>$paket->id,

                    'tipe'=>'wahana',

                    'item_id'=>$wahana

                ]);

            }

        }

        return redirect(
            '/admin/paket'
        )
        ->with(
            'success',
            'Paket berhasil ditambahkan'
        );

    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

        $paket = Paket::with(
            'items'
        )->findOrFail($id);

        $menus = Menu::tersedia()
                    ->get();

        $wahanas = TiketWahana::all();

        return view(

            'admin.paket.edit',

            compact(

                'paket',

                'menus',

                'wahanas'

            )

        );

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    )
    {

        $paket = Paket::findOrFail(
            $id
        );

        $harga = str_replace(
            '.',
            '',
            $request->harga
        );

        /*
        IMAGE
        */

        $gambar = $paket->gambar;

        if(
            $request->hasFile(
                'gambar'
            )
        ){

            if(
                $paket->gambar &&
                Storage::disk('public')
                ->exists(
                    $paket->gambar
                )
            ){

                Storage::disk('public')
                ->delete(
                    $paket->gambar
                );

            }

            $gambar = $request
            ->file('gambar')
            ->store(
                'paket',
                'public'
            );

        }

        /*
        UPDATE PAKET
        */

        $paket->update([

            'nama_paket'=>$request->nama_paket,

            'harga'=>$harga,

            'gambar'=>$gambar,

            'deskripsi'=>$request->deskripsi,

            'status'=>$request->status

        ]);

        /*
        RESET ITEM
        */

        PaketItem::where(
            'paket_id',
            $paket->id
        )->delete();

        /*
        MENU
        */

        if(
            $request->menus
        ){

            foreach(
                $request->menus
                as
                $menu
            ){

                PaketItem::create([

                    'paket_id'=>$paket->id,

                    'tipe'=>'menu',

                    'item_id'=>$menu

                ]);

            }

        }

        /*
        WAHANA
        */

        if(
            $request->wahanas
        ){

            foreach(
                $request->wahanas
                as
                $wahana
            ){

                PaketItem::create([

                    'paket_id'=>$paket->id,

                    'tipe'=>'wahana',

                    'item_id'=>$wahana

                ]);

            }

        }

        return redirect(
            '/admin/paket'
        )
        ->with(
            'success',
            'Paket berhasil diupdate'
        );

    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        $id
    )
    {

        $paket = Paket::findOrFail(
            $id
        );

        if(
            $paket->gambar &&
            Storage::disk('public')
            ->exists(
                $paket->gambar
            )
        ){

            Storage::disk('public')
            ->delete(
                $paket->gambar
            );

        }

        $paket->delete();

        return back()
        ->with(
            'success',
            'Paket berhasil dihapus'
        );

    }

}