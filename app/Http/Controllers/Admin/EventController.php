<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Throwable;

class EventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI UPLOAD
    |--------------------------------------------------------------------------
    */

    private const UPLOAD_DIRECTORY = 'uploads/event';


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    | Menampilkan event yang akan datang.
    |
    | Event hari ini tetap ditampilkan.
    | Event yang sudah lewat tidak ditampilkan.
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $this->authorizeAdmin();

        $events = Event::query()
            ->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal', 'asc')
            ->orderBy('id_event', 'asc')
            ->get();

        return view(
            'admin.event.index',
            compact('events')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    | Form tambah event.
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.event.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    | Menyimpan event baru.
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'judul' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'tanggal' => [
                    'required',
                    'date',
                    'after_or_equal:today',
                ],

                'deskripsi' => [
                    'nullable',
                    'string',
                ],

                'gambar' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],
            ],
            [
                'judul.required' =>
                    'Judul event wajib diisi.',

                'judul.max' =>
                    'Judul event maksimal 255 karakter.',

                'tanggal.required' =>
                    'Tanggal event wajib diisi.',

                'tanggal.date' =>
                    'Format tanggal event tidak valid.',

                'tanggal.after_or_equal' =>
                    'Tanggal event harus hari ini atau tanggal setelahnya.',

                'deskripsi.string' =>
                    'Deskripsi event harus berupa teks.',

                'gambar.image' =>
                    'File yang diupload harus berupa gambar.',

                'gambar.mimes' =>
                    'Format gambar harus JPG, JPEG, PNG, atau WEBP.',

                'gambar.max' =>
                    'Ukuran gambar maksimal 2 MB.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | USER LOGIN
        |--------------------------------------------------------------------------
        */

        $userId = Auth::guard('admin')->id();

        if (!$userId) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi login telah berakhir. Silakan login kembali.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SIAPKAN UPLOAD
        |--------------------------------------------------------------------------
        */

        $uploadPath = $this->getUploadPath();

        $namaGambar = null;

        $gambarBaruPath = null;


        /*
        |--------------------------------------------------------------------------
        | DATABASE TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | UPLOAD GAMBAR
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('gambar')) {

                $namaGambar = $this->generateImageName(
                    $request->file('gambar')
                );

                $request
                    ->file('gambar')
                    ->move(
                        $uploadPath,
                        $namaGambar
                    );

                $gambarBaruPath =
                    $uploadPath .
                    DIRECTORY_SEPARATOR .
                    $namaGambar;
            }


            /*
            |--------------------------------------------------------------------------
            | CREATE EVENT
            |--------------------------------------------------------------------------
            */

            Event::create([
                'id_user'   => $userId,
                'judul'     => trim($validated['judul']),
                'tanggal'   => $validated['tanggal'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'gambar'    => $namaGambar,
            ]);


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            DB::commit();


            return redirect()
                ->route('admin.event.index')
                ->with(
                    'success',
                    'Event berhasil ditambahkan.'
                );


        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | ROLLBACK
            |--------------------------------------------------------------------------
            */

            DB::rollBack();


            /*
            |--------------------------------------------------------------------------
            | HAPUS GAMBAR JIKA DATABASE GAGAL
            |--------------------------------------------------------------------------
            */

            if (
                $gambarBaruPath &&
                File::exists($gambarBaruPath)
            ) {
                File::delete($gambarBaruPath);
            }


            /*
            |--------------------------------------------------------------------------
            | CATAT ERROR
            |--------------------------------------------------------------------------
            */

            report($e);


            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal menambahkan event. Silakan coba kembali.'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    | Hanya event hari ini dan event yang akan datang.
    |--------------------------------------------------------------------------
    */

    public function edit(int $id)
    {
        $this->authorizeAdmin();

        $event = $this->findUpcomingEvent($id);

        return view(
            'admin.event.edit',
            compact('event')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        int $id
    ): RedirectResponse {

        $this->authorizeAdmin();

        $event = $this->findUpcomingEvent($id);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'judul' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'tanggal' => [
                    'required',
                    'date',
                    'after_or_equal:today',
                ],

                'deskripsi' => [
                    'nullable',
                    'string',
                ],

                'gambar' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:2048',
                ],
            ],
            [
                'judul.required' =>
                    'Judul event wajib diisi.',

                'judul.max' =>
                    'Judul event maksimal 255 karakter.',

                'tanggal.required' =>
                    'Tanggal event wajib diisi.',

                'tanggal.date' =>
                    'Format tanggal event tidak valid.',

                'tanggal.after_or_equal' =>
                    'Tanggal event harus hari ini atau tanggal setelahnya.',

                'deskripsi.string' =>
                    'Deskripsi event harus berupa teks.',

                'gambar.image' =>
                    'File yang diupload harus berupa gambar.',

                'gambar.mimes' =>
                    'Format gambar harus JPG, JPEG, PNG, atau WEBP.',

                'gambar.max' =>
                    'Ukuran gambar maksimal 2 MB.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | DATA GAMBAR
        |--------------------------------------------------------------------------
        */

        $uploadPath = $this->getUploadPath();

        $gambarLama = $event->gambar;

        $gambarBaru = $gambarLama;

        $gambarBaruPath = null;


        /*
        |--------------------------------------------------------------------------
        | DATABASE TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | UPLOAD GAMBAR BARU
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('gambar')) {

                $gambarBaru = $this->generateImageName(
                    $request->file('gambar')
                );

                $request
                    ->file('gambar')
                    ->move(
                        $uploadPath,
                        $gambarBaru
                    );

                $gambarBaruPath =
                    $uploadPath .
                    DIRECTORY_SEPARATOR .
                    $gambarBaru;
            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE EVENT
            |--------------------------------------------------------------------------
            */

            $event->update([
                'judul'     => trim($validated['judul']),
                'tanggal'   => $validated['tanggal'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'gambar'    => $gambarBaru,
            ]);


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | HAPUS GAMBAR LAMA
            |--------------------------------------------------------------------------
            */

            if (
                $request->hasFile('gambar') &&
                $gambarLama &&
                $gambarLama !== $gambarBaru
            ) {
                $this->deleteImage($gambarLama);
            }


            return redirect()
                ->route('admin.event.index')
                ->with(
                    'success',
                    'Event berhasil diperbarui.'
                );


        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | ROLLBACK
            |--------------------------------------------------------------------------
            */

            DB::rollBack();


            /*
            |--------------------------------------------------------------------------
            | HAPUS GAMBAR BARU
            |--------------------------------------------------------------------------
            */

            if (
                $gambarBaruPath &&
                File::exists($gambarBaruPath)
            ) {
                File::delete($gambarBaruPath);
            }


            report($e);


            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal memperbarui event. Silakan coba kembali.'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    | Menghapus event hari ini / event yang akan datang.
    |--------------------------------------------------------------------------
    */

    public function destroy(int $id): RedirectResponse
    {
        $this->authorizeAdmin();

        $event = $this->findUpcomingEvent($id);

        $namaGambar = $event->gambar;


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | HAPUS DATA EVENT
            |--------------------------------------------------------------------------
            */

            $event->delete();


            /*
            |--------------------------------------------------------------------------
            | COMMIT
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | HAPUS FILE GAMBAR
            |--------------------------------------------------------------------------
            */

            if ($namaGambar) {
                $this->deleteImage($namaGambar);
            }


            return redirect()
                ->route('admin.event.index')
                ->with(
                    'success',
                    'Event berhasil dihapus.'
                );


        } catch (Throwable $e) {

            DB::rollBack();

            report($e);


            return redirect()
                ->route('admin.event.index')
                ->with(
                    'error',
                    'Gagal menghapus event. Silakan coba kembali.'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | AUTHORIZE ADMIN
    |--------------------------------------------------------------------------
    */

    private function authorizeAdmin(): void
    {
        $guard = Auth::guard('admin');

        if (!$guard->check()) {

            abort(
                redirect()
                    ->route('admin.login')
                    ->with(
                        'error',
                        'Silakan login terlebih dahulu.'
                    )
            );
        }


        $user = $guard->user();

        if (!$user || $user->role !== 'admin') {
            abort(
                403,
                'Anda tidak memiliki akses ke halaman event.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | FIND UPCOMING EVENT
    |--------------------------------------------------------------------------
    | Hanya event hari ini atau event mendatang yang dapat dikelola.
    |--------------------------------------------------------------------------
    */

    private function findUpcomingEvent(int $id): Event
    {
        return Event::query()
            ->where('id_event', $id)
            ->whereDate('tanggal', '>=', today())
            ->firstOrFail();
    }


    /*
    |--------------------------------------------------------------------------
    | GET UPLOAD PATH
    |--------------------------------------------------------------------------
    */

    private function getUploadPath(): string
    {
        $path = public_path(
            self::UPLOAD_DIRECTORY
        );


        if (!File::exists($path)) {

            File::makeDirectory(
                $path,
                0755,
                true
            );
        }


        return $path;
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE IMAGE NAME
    |--------------------------------------------------------------------------
    */

    private function generateImageName($file): string
    {
        $extension = strtolower(
            $file->getClientOriginalExtension()
        );


        $originalName = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );


        $safeName = Str::slug(
            $originalName
        );


        if (!$safeName) {
            $safeName = 'event';
        }


        return $safeName
            . '_'
            . now()->format('YmdHis')
            . '_'
            . Str::random(8)
            . '.'
            . $extension;
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE IMAGE
    |--------------------------------------------------------------------------
    */

    private function deleteImage(
        ?string $filename
    ): void {

        if (!$filename) {
            return;
        }


        $path = public_path(
            self::UPLOAD_DIRECTORY .
            DIRECTORY_SEPARATOR .
            $filename
        );


        if (File::exists($path)) {
            File::delete($path);
        }
    }
}