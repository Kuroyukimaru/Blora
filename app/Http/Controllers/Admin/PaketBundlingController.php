<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketBundling;
use App\Models\Menu;
use App\Models\TiketWahana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketBundlingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paketBundlings = PaketBundling::with([
            'menus',
            'wahanas'
        ])->latest()->get();

        return view(
            'admin.paketbundling.index',
            compact('paketBundlings')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::where(
            'status',
            'Tersedia'
        )->get();

        $wahanas = TiketWahana::all();

        return view(
            'admin.paketbundling.create',
            compact(
                'menus',
                'wahanas'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'untuk' => 'required',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'menu_ids' => 'required|array|min:1',
            'wahana_ids' => 'required|array|min:1',
        ]);

        $data = [
            'nama_paket' => $request->nama_paket,
            'untuk' => $request->untuk,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {

            $data['gambar'] = $request
                ->file('gambar')
                ->store(
                    'paketbundling',
                    'public'
                );
        }

        $paket = PaketBundling::create($data);

        $paket->menus()->sync(
            $request->menu_ids
        );

        $paket->wahanas()->sync(
            $request->wahana_ids
        );

        return redirect()
            ->route('admin.paketbundling.index')
            ->with(
                'success',
                'Paket bundling berhasil ditambahkan.'
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paketBundling = PaketBundling::with([
            'menus',
            'wahanas'
        ])->findOrFail($id);

        $menus = Menu::where(
            'status',
            'Tersedia'
        )->get();

        $wahanas = TiketWahana::all();

        return view(
            'admin.paketbundling.edit',
            compact(
                'paketBundling',
                'menus',
                'wahanas'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        string $id
    )
    {
        $paket = PaketBundling::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'untuk' => 'required',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'menu_ids' => 'required|array|min:1',
            'wahana_ids' => 'required|array|min:1',
        ]);

        $data = [
            'nama_paket' => $request->nama_paket,
            'untuk' => $request->untuk,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {

            if (
                $paket->gambar &&
                Storage::disk('public')
                    ->exists($paket->gambar)
            ) {
                Storage::disk('public')
                    ->delete($paket->gambar);
            }

            $data['gambar'] = $request
                ->file('gambar')
                ->store(
                    'paketbundling',
                    'public'
                );
        }

        $paket->update($data);

        $paket->menus()->sync(
            $request->menu_ids
        );

        $paket->wahanas()->sync(
            $request->wahana_ids
        );

        return redirect()
            ->route('admin.paketbundling.index')
            ->with(
                'success',
                'Paket bundling berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paket = PaketBundling::findOrFail($id);

        if (
            $paket->gambar &&
            Storage::disk('public')
                ->exists($paket->gambar)
        ) {
            Storage::disk('public')
                ->delete($paket->gambar);
        }

        $paket->delete();

        return redirect()
            ->route('admin.paketbundling.index')
            ->with(
                'success',
                'Paket bundling berhasil dihapus.'
            );
    }
}