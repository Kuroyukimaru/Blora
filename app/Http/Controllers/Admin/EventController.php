<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();

        return view('Admin.event.index', compact('events'));
    }

    public function create()
    {
        return view('Admin.event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required',
            'tanggal'   => 'required|date',
            'deskripsi' => 'required',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $namaGambar = null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/event'), $namaGambar);
        }

        Event::create([
            'judul'     => $request->judul,
            'tanggal'   => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $namaGambar,
        ]);

        return redirect()->route('event.index')
            ->with('success', 'Event berhasil ditambahkan');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        return view('Admin.event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'judul'     => 'required',
            'tanggal'   => 'required|date',
            'deskripsi' => 'required',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $namaGambar = $event->gambar;

        if ($request->hasFile('gambar')) {

            if ($event->gambar && File::exists(public_path('uploads/event/' . $event->gambar))) {
                File::delete(public_path('uploads/event/' . $event->gambar));
            }

            $file = $request->file('gambar');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/event'), $namaGambar);
        }

        $event->update([
            'judul'     => $request->judul,
            'tanggal'   => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $namaGambar,
        ]);

        return redirect()->route('event.index')
            ->with('success', 'Event berhasil diupdate');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->gambar && File::exists(public_path('uploads/event/' . $event->gambar))) {
            File::delete(public_path('uploads/event/' . $event->gambar));
        }

        $event->delete();

        return redirect()->route('event.index')
            ->with('success', 'Event berhasil dihapus');
    }
}