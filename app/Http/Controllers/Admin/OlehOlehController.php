<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OlehOleh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OlehOlehController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $olehOleh = OlehOleh::latest()->get();

        return view('admin.oleholeh.index', compact('olehOleh'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.oleholeh.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'jenis'     => 'required|string',
            'stock'     => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nama'      => $request->nama,
            'jenis'     => $request->jenis,
            'stock'     => $request->stock,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request
                ->file('gambar')
                ->store('oleholeh', 'public');
        }

        OlehOleh::create($data);

        return redirect()
            ->route('admin.oleholeh.index')
            ->with('success', 'Data oleh-oleh berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $olehOleh = OlehOleh::findOrFail($id);

        return view('admin.oleholeh.show', compact('olehOleh'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $olehOleh = OlehOleh::findOrFail($id);

        return view('admin.oleholeh.edit', compact('olehOleh'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $olehOleh = OlehOleh::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:255',
            'jenis'     => 'required|string',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nama'      => $request->nama,
            'jenis'     => $request->jenis,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {

            if (
                $olehOleh->gambar &&
                Storage::disk('public')->exists($olehOleh->gambar)
            ) {
                Storage::disk('public')->delete($olehOleh->gambar);
            }

            $data['gambar'] = $request
                ->file('gambar')
                ->store('oleholeh', 'public');
        }

        $olehOleh->update($data);

        return redirect()
            ->route('admin.oleholeh.index')
            ->with('success', 'Data oleh-oleh berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $olehOleh = OlehOleh::findOrFail($id);

        if (
            $olehOleh->gambar &&
            Storage::disk('public')->exists($olehOleh->gambar)
        ) {
            Storage::disk('public')->delete($olehOleh->gambar);
        }

        $olehOleh->delete();

        return redirect()
            ->route('admin.oleholeh.index')
            ->with('success', 'Data oleh-oleh berhasil dihapus.');
    }
}