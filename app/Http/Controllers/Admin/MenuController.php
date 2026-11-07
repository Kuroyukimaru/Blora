<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class MenuController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    | Menampilkan seluruh menu yang dikelola Admin.
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $this->authorizeAdmin();

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Menu::query()
            ->with('user');


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        |
        | Bisa mencari berdasarkan:
        | - nama menu
        | - kategori
        | - deskripsi
        |
        */

        if ($request->filled('search')) {

            $query->search(
                $request->input('search')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kategori')) {

            $query->kategori(
                $request->input('kategori')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $status = trim(
                (string) $request->input('status')
            );

            if (
                in_array(
                    $status,
                    [
                        'Tersedia',
                        'Habis',
                    ],
                    true
                )
            ) {
                $query->where(
                    'status',
                    $status
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */

        $sort = $request->input(
            'sort',
            'terbaru'
        );

        switch ($sort) {

            case 'terlama':

                $query->oldest('id_menu');

                break;


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


            default:

                $query->latest(
                    'id_menu'
                );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $menus = $query->get();


        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $kategoriOptions = [
            'Paket Kenyang',
            'Minuman',
            'Sambal',
            'Lainnya',
        ];

        $statusOptions = [
            'Tersedia',
            'Habis',
        ];


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.menu.index',
            compact(
                'menus',
                'kategoriOptions',
                'statusOptions'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    | Menampilkan halaman tambah menu.
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        $this->authorizeAdmin();

        return view(
            'admin.menu.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    | Menyimpan menu baru.
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {

        $this->authorizeAdmin();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            $this->menuRules(),
            $this->menuMessages()
        );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI HARGA
        |--------------------------------------------------------------------------
        */

        $harga = $this->normalizeHarga(
            $validated['harga']
        );


        if ($harga === null) {

            return back()
                ->withInput()
                ->withErrors([
                    'harga' =>
                        'Harga tidak valid. Contoh: 25000, 25.000, atau Rp 25.000.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | USER LOGIN
        |--------------------------------------------------------------------------
        */

        $user = Auth::guard('admin')->user();


        if (!$user) {

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi login telah berakhir. Silakan login kembali.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ID USER
        |--------------------------------------------------------------------------
        */

        $userId = $user->id_user
            ?? $user->getKey();


        /*
        |--------------------------------------------------------------------------
        | GAMBAR
        |--------------------------------------------------------------------------
        */

        $gambar = null;


        try {

            DB::beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | UPLOAD GAMBAR
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('gambar')) {

                $gambar = $request
                    ->file('gambar')
                    ->store(
                        'menu',
                        'public'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | CREATE MENU
            |--------------------------------------------------------------------------
            */

            Menu::create([
                'id_user' => $userId,

                'nama_menu' =>
                    trim(
                        $validated['nama_menu']
                    ),

                'kategori' =>
                    $validated['kategori'],

                'harga' =>
                    $harga,

                'deskripsi' =>
                    $this->normalizeDeskripsi(
                        $validated['deskripsi']
                        ?? null
                    ),

                'gambar' =>
                    $gambar,

                'status' =>
                    $validated['status'],
            ]);


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'admin.menu.index'
                )
                ->with(
                    'success',
                    'Menu berhasil ditambahkan.'
                );

        } catch (Throwable $e) {

            DB::rollBack();


            /*
            |--------------------------------------------------------------------------
            | HAPUS GAMBAR JIKA DATABASE GAGAL
            |--------------------------------------------------------------------------
            */

            $this->deleteImage(
                $gambar
            );


            report($e);


            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal menambahkan menu. Silakan coba lagi.'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    | Menampilkan detail menu.
    |--------------------------------------------------------------------------
    */

    public function show(
        Menu $menu
    ): View {

        $this->authorizeAdmin();


        /*
        |--------------------------------------------------------------------------
        | LOAD RELATION
        |--------------------------------------------------------------------------
        */

        $menu->load([
            'user',
        ]);


        return view(
            'admin.menu.show',
            compact('menu')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    | Menampilkan halaman edit menu.
    |--------------------------------------------------------------------------
    */

    public function edit(
        Menu $menu
    ): View {

        $this->authorizeAdmin();


        return view(
            'admin.menu.edit',
            compact('menu')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    | Admin dapat memperbarui semua data menu.
    |
    | CATATAN:
    | id_user TIDAK DIUBAH.
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Menu $menu
    ): RedirectResponse {

        $this->authorizeAdmin();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            $this->menuRules(),
            $this->menuMessages()
        );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI HARGA
        |--------------------------------------------------------------------------
        */

        $harga = $this->normalizeHarga(
            $validated['harga']
        );


        if ($harga === null) {

            return back()
                ->withInput()
                ->withErrors([
                    'harga' =>
                        'Harga tidak valid. Contoh: 25000, 25.000, atau Rp 25.000.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | GAMBAR LAMA
        |--------------------------------------------------------------------------
        */

        $oldImage = $menu->gambar;


        /*
        |--------------------------------------------------------------------------
        | GAMBAR BARU
        |--------------------------------------------------------------------------
        */

        $newImage = $oldImage;


        try {

            DB::beginTransaction();


            /*
            |--------------------------------------------------------------------------
            | UPLOAD GAMBAR BARU
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('gambar')) {

                $newImage = $request
                    ->file('gambar')
                    ->store(
                        'menu',
                        'public'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE DATA
            |--------------------------------------------------------------------------
            |
            | id_user sengaja tidak dimasukkan.
            |
            | Jadi admin yang melakukan edit tidak mengubah
            | pemilik/pencatat menu.
            |
            */

            $menu->update([
                'nama_menu' =>
                    trim(
                        $validated['nama_menu']
                    ),

                'kategori' =>
                    $validated['kategori'],

                'harga' =>
                    $harga,

                'deskripsi' =>
                    $this->normalizeDeskripsi(
                        $validated['deskripsi']
                        ?? null
                    ),

                'gambar' =>
                    $newImage,

                'status' =>
                    $validated['status'],
            ]);


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | HAPUS GAMBAR LAMA
            |--------------------------------------------------------------------------
            |
            | Hanya dilakukan jika memang ada gambar baru.
            |
            */

            if (
                $request->hasFile('gambar')
                &&
                $oldImage
                &&
                $oldImage !== $newImage
            ) {

                $this->deleteImage(
                    $oldImage
                );
            }


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'admin.menu.index'
                )
                ->with(
                    'success',
                    'Menu berhasil diperbarui.'
                );

        } catch (Throwable $e) {

            DB::rollBack();


            /*
            |--------------------------------------------------------------------------
            | HAPUS GAMBAR BARU JIKA UPDATE GAGAL
            |--------------------------------------------------------------------------
            */

            if (
                $request->hasFile('gambar')
                &&
                $newImage
                &&
                $newImage !== $oldImage
            ) {

                $this->deleteImage(
                    $newImage
                );
            }


            report($e);


            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal memperbarui menu. Silakan coba lagi.'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    | Menghapus menu.
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Menu $menu
    ): RedirectResponse {

        $this->authorizeAdmin();

        $menuId = $menu->id_menu;
        $gambar = $menu->gambar;

        try {

            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | HAPUS RELASI DETAIL PESANAN
            |--------------------------------------------------------------------------
            |
            | Menu yang sudah pernah masuk pesanan tetap dapat dihapus sesuai
            | permintaan admin. Detail pesanan yang menunjuk menu tersebut
            | dihapus lebih dahulu agar foreign key tidak menghalangi.
            |
            */

            DB::table('detail_pesanans')
                ->where('id_menu', $menuId)
                ->delete();


            /*
            |--------------------------------------------------------------------------
            | HAPUS RELASI PAKET BUNDLING
            |--------------------------------------------------------------------------
            |
            | Menu dapat menjadi komponen paket bundling melalui tabel pivot.
            | Yang dihapus hanya relasinya, bukan paket bundling-nya.
            |
            */

            DB::table('paket_bundling_menus')
                ->where('id_menu', $menuId)
                ->delete();


            /*
            |--------------------------------------------------------------------------
            | HAPUS MENU
            |--------------------------------------------------------------------------
            */

            $menu->delete();

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | HAPUS FILE GAMBAR
            |--------------------------------------------------------------------------
            */

            $this->deleteImage($gambar);


            return redirect()
                ->route('admin.menu.index')
                ->with(
                    'success',
                    'Menu dan seluruh data terkait berhasil dihapus.'
                );

        } catch (Throwable $e) {

            DB::rollBack();

            report($e);

            return redirect()
                ->route('admin.menu.index')
                ->with(
                    'error',
                    'Menu gagal dihapus. Data dikembalikan seperti semula.'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | AUTHORIZE ADMIN
    |--------------------------------------------------------------------------
    |
    | Pengaman tambahan.
    |
    | Route tetap sebaiknya menggunakan:
    |
    | middleware('role:admin')
    |
    |--------------------------------------------------------------------------
    */

    private function authorizeAdmin(): void
    {
        $guard = Auth::guard('admin');


        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | AMBIL USER
        |--------------------------------------------------------------------------
        */

        $user = $guard->user();


        if (!$user) {

            $guard->logout();

            request()
                ->session()
                ->invalidate();

            request()
                ->session()
                ->regenerateToken();

            abort(
                redirect()
                    ->route('admin.login')
                    ->with(
                        'error',
                        'Sesi login tidak valid. Silakan login kembali.'
                    )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK ROLE
        |--------------------------------------------------------------------------
        */

        if (
            trim(
                (string) $user->role
            ) !== 'admin'
        ) {

            abort(
                403,
                'Anda tidak memiliki akses untuk mengelola menu.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION RULES
    |--------------------------------------------------------------------------
    */

    private function menuRules(): array
    {
        return [

            'nama_menu' => [
                'required',
                'string',
                'max:255',
            ],

            'kategori' => [
                'required',
                'string',
                'in:Paket Kenyang,Minuman,Sambal,Lainnya',
            ],

            'harga' => [
                'required',
                'string',
                'max:50',
            ],

            'deskripsi' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'gambar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'status' => [
                'required',
                'string',
                'in:Tersedia,Habis',
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION MESSAGES
    |--------------------------------------------------------------------------
    */

    private function menuMessages(): array
    {
        return [

            'nama_menu.required' =>
                'Nama menu wajib diisi.',

            'nama_menu.string' =>
                'Nama menu harus berupa teks.',

            'nama_menu.max' =>
                'Nama menu maksimal 255 karakter.',


            'kategori.required' =>
                'Kategori menu wajib dipilih.',

            'kategori.in' =>
                'Kategori menu tidak valid.',


            'harga.required' =>
                'Harga menu wajib diisi.',

            'harga.string' =>
                'Harga menu tidak valid.',

            'harga.max' =>
                'Harga menu terlalu panjang.',


            'deskripsi.string' =>
                'Deskripsi harus berupa teks.',

            'deskripsi.max' =>
                'Deskripsi maksimal 5000 karakter.',


            'gambar.image' =>
                'File yang dipilih harus berupa gambar.',

            'gambar.mimes' =>
                'Format gambar harus JPG, JPEG, PNG, atau WEBP.',

            'gambar.max' =>
                'Ukuran gambar maksimal 2 MB.',


            'status.required' =>
                'Status menu wajib dipilih.',

            'status.in' =>
                'Status menu tidak valid.',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE DESKRIPSI
    |--------------------------------------------------------------------------
    */

    private function normalizeDeskripsi(
        ?string $deskripsi
    ): ?string {

        if ($deskripsi === null) {
            return null;
        }


        $deskripsi = trim(
            $deskripsi
        );


        return $deskripsi === ''
            ? null
            : $deskripsi;
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE HARGA
    |--------------------------------------------------------------------------
    |
    | Mendukung:
    |
    | 25000
    | 25.000
    | 25,000
    | Rp 25.000
    | Rp25.000
    | rp25.000
    |
    |--------------------------------------------------------------------------
    */

    private function normalizeHarga(
        string $harga
    ): ?int {

        /*
        |--------------------------------------------------------------------------
        | TRIM
        |--------------------------------------------------------------------------
        */

        $harga = trim(
            $harga
        );


        if ($harga === '') {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS RP
        |--------------------------------------------------------------------------
        */

        $harga = preg_replace(
            '/^rp\s*/i',
            '',
            $harga
        );


        /*
        |--------------------------------------------------------------------------
        | HAPUS SPASI
        |--------------------------------------------------------------------------
        */

        $harga = str_replace(
            ' ',
            '',
            $harga
        );


        /*
        |--------------------------------------------------------------------------
        | HAPUS PEMISAH RIBUAN
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | 25.000
        | 25,000
        |
        */

        $harga = str_replace(
            [
                '.',
                ',',
            ],
            '',
            $harga
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI DIGIT
        |--------------------------------------------------------------------------
        */

        if (
            $harga === ''
            ||
            !ctype_digit($harga)
        ) {

            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | CONVERT INTEGER
        |--------------------------------------------------------------------------
        */

        $harga = (int) $harga;


        /*
        |--------------------------------------------------------------------------
        | HARGA MINIMAL
        |--------------------------------------------------------------------------
        */

        if ($harga <= 0) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | BATAS INTEGER DATABASE
        |--------------------------------------------------------------------------
        |
        | Migration menggunakan unsignedInteger.
        |
        */

        if (
            $harga > 4294967295
        ) {
            return null;
        }


        return $harga;
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE IMAGE
    |--------------------------------------------------------------------------
    |
    | Menghapus gambar dari storage public.
    |--------------------------------------------------------------------------
    */

    private function deleteImage(
        ?string $path
    ): void {

        if (
            empty($path)
            ||
            !is_string($path)
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI PATH
        |--------------------------------------------------------------------------
        */

        $path = trim(
            $path
        );

        $path = ltrim(
            $path,
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | HANDLE PREFIX STORAGE
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $path,
                'storage/'
            )
        ) {

            $path = substr(
                $path,
                strlen('storage/')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | HANDLE PREFIX PUBLIC
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $path,
                'public/'
            )
        ) {

            $path = substr(
                $path,
                strlen('public/')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        try {

            if (
                Storage::disk('public')
                    ->exists($path)
            ) {

                Storage::disk('public')
                    ->delete($path);
            }

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Jangan membuat proses utama gagal hanya karena
            | file gambar gagal dihapus.
            |--------------------------------------------------------------------------
            */

            report($e);
        }
    }
}