<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->get();

        return view(
            'admin.menu.index',
            compact('menus')
        );
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {

        $request->validate([

            'nama_menu' => 'required|string|max:255',

            'kategori' => 'required|in:Minuman,Sambal,Lainnya,Paket',

            'harga' => 'required',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'deskripsi' => 'nullable|string',

            'status' => 'required|in:Tersedia,Habis',

        ]);

        $harga = str_replace(
            '.',
            '',
            $request->harga
        );

        $gambar = null;

        if ($request->hasFile('gambar')) {

            Storage::disk('public')
                ->makeDirectory('menu');

            $gambar = $request
                ->file('gambar')
                ->store(
                    'menu',
                    'public'
                );
        }

        Menu::create([

            'nama_menu' => $request->nama_menu,

            'kategori' => $request->kategori,

            'harga' => $harga,

            'gambar' => $gambar,

            'deskripsi' => $request->deskripsi,

            'status' => $request->status,

        ]);

        return redirect('/admin/menu')
            ->with(
                'success',
                'Menu berhasil ditambahkan'
            );
    }

    public function edit($id)
    {

        $menu = Menu::findOrFail($id);

        return view(
            'admin.menu.edit',
            compact('menu')
        );
    }

    public function update(Request $request, $id)
    {

        $menu = Menu::findOrFail($id);

        $request->validate([

            'nama_menu' => 'required|string|max:255',

            'kategori' => 'required|in:Minuman,Sambal,Lainnya,Paket',

            'harga' => 'required',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'deskripsi' => 'nullable|string',

            'status' => 'required|in:Tersedia,Habis',

        ]);

        $harga = str_replace(
            '.',
            '',
            $request->harga
        );

        $gambar = $menu->gambar;

        if ($request->hasFile('gambar')) {

            if (
                $menu->gambar &&
                Storage::disk('public')
                    ->exists($menu->gambar)
            ) {

                Storage::disk('public')
                    ->delete($menu->gambar);
            }

            Storage::disk('public')
                ->makeDirectory('menu');

            $gambar = $request
                ->file('gambar')
                ->store(
                    'menu',
                    'public'
                );
        }

        $menu->update([

            'nama_menu' => $request->nama_menu,

            'kategori' => $request->kategori,

            'harga' => $harga,

            'gambar' => $gambar,

            'deskripsi' => $request->deskripsi,

            'status' => $request->status,

        ]);

        return redirect('/admin/menu')
            ->with(
                'success',
                'Menu berhasil diupdate'
            );
    }


    public function destroy($id)
    {

        $menu = Menu::findOrFail($id);

        if (
            $menu->gambar &&
            Storage::disk('public')
                ->exists($menu->gambar)
        ) {

            Storage::disk('public')
                ->delete($menu->gambar);
        }

        $menu->delete();

        return redirect('/admin/menu')
            ->with(
                'success',
                'Menu berhasil dihapus'
            );
    }
}