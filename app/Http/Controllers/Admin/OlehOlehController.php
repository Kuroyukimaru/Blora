<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OlehOleh;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class OlehOlehController extends Controller
{

    public function index(): View
    {
        $this->authorizeAdmin();

        $olehOleh = OlehOleh::query()
            ->latest('id_oleh_oleh')
            ->get();

        return view(
            'admin.oleholeh.index',
            compact('olehOleh')
        );
    }

    public function create(): View
    {
        $this->authorizeAdmin();

        return view(
            'admin.oleholeh.create'
        );
    }

    public function store(
        Request $request
    ): RedirectResponse {

        $this->authorizeAdmin();

        $validated = $request->validate(
            $this->olehOlehRules(),
            $this->olehOlehMessages()
        );

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

        $admin = Auth::guard('admin')->user();

        if (!$admin) {

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi admin tidak ditemukan. Silakan login kembali.'
                );
        }

        $gambar = null;

        try {

            DB::beginTransaction();

            if ($request->hasFile('gambar')) {

                $gambar = $request
                    ->file('gambar')
                    ->store(
                        'oleholeh',
                        'public'
                    );
            }

            OlehOleh::create([

                'id_user' =>
                    $admin->id_user,

                'nama' =>
                    trim(
                        $validated['nama']
                    ),

                'jenis' =>
                    $validated['jenis'],

                'harga' =>
                    $harga,

                'deskripsi' =>
                    $this->normalizeDeskripsi(
                        $validated['deskripsi'] ?? null
                    ),

                'gambar' =>
                    $gambar,

                'status' =>
                    $validated['status'],

            ]);

            DB::commit();

            return redirect()
                ->route(
                    'admin.oleholeh.index'
                )
                ->with(
                    'success',
                    'Data oleh-oleh berhasil ditambahkan.'
                );

        } catch (Throwable $e) {

            DB::rollBack();

            if (
                $gambar &&
                Storage::disk('public')->exists($gambar)
            ) {

                Storage::disk('public')->delete(
                    $gambar
                );
            }

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data oleh-oleh gagal ditambahkan. Silakan coba lagi.'
                );
        }
    }

    public function show($id): View
    {
        $this->authorizeAdmin();

        $olehOleh = OlehOleh::findOrFail(
            $id
        );

        return view(
            'admin.oleholeh.show',
            compact('olehOleh')
        );
    }

    public function edit($id): View
    {
        $this->authorizeAdmin();

        $olehOleh = OlehOleh::findOrFail(
            $id
        );

        return view(
            'admin.oleholeh.edit',
            compact('olehOleh')
        );
    }

    public function update(
        Request $request,
        $id
    ): RedirectResponse {

        $this->authorizeAdmin();

        $olehOleh = OlehOleh::findOrFail(
            $id
        );

        $validated = $request->validate(
            $this->olehOlehRules(),
            $this->olehOlehMessages()
        );

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

        $oldImage =
            $olehOleh->gambar;

        $newImage =
            $oldImage;

        try {

            DB::beginTransaction();

            if ($request->hasFile('gambar')) {

                $newImage = $request
                    ->file('gambar')
                    ->store(
                        'oleholeh',
                        'public'
                    );
            }

            $olehOleh->update([

                'nama' =>
                    trim(
                        $validated['nama']
                    ),

                'jenis' =>
                    $validated['jenis'],

                'harga' =>
                    $harga,

                'deskripsi' =>
                    $this->normalizeDeskripsi(
                        $validated['deskripsi'] ?? null
                    ),

                'gambar' =>
                    $newImage,

                'status' =>
                    $validated['status'],

            ]);

            DB::commit();

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

            return redirect()
                ->route(
                    'admin.oleholeh.index'
                )
                ->with(
                    'success',
                    'Data oleh-oleh berhasil diperbarui.'
                );

        } catch (Throwable $e) {

            DB::rollBack();

            if (
                $newImage &&
                $newImage !== $oldImage &&
                Storage::disk('public')->exists($newImage)
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
                    'Data oleh-oleh gagal diperbarui. Silakan coba lagi.'
                );
        }
    }

    public function destroy(
        $id
    ): RedirectResponse {

        $this->authorizeAdmin();

        $olehOleh = OlehOleh::findOrFail(
            $id
        );

        $gambar =
            $olehOleh->gambar;

        try {

            DB::beginTransaction();

            $olehOleh->delete();

            DB::commit();

            if ($gambar) {

                $this->deleteImage(
                    $gambar
                );
            }

            return redirect()
                ->route(
                    'admin.oleholeh.index'
                )
                ->with(
                    'success',
                    'Data oleh-oleh berhasil dihapus.'
                );

        } catch (Throwable $e) {

            DB::rollBack();

            report($e);

            return back()
                ->with(
                    'error',
                    'Data oleh-oleh gagal dihapus. Silakan coba lagi.'
                );
        }
    }

    private function authorizeAdmin(): void
    {
        $guard =
            Auth::guard('admin');

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

        $user =
            $guard->user();

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

        if (
            trim(
                (string) $user->role
            ) !== 'admin'
        ) {

            abort(
                403,
                'Anda tidak memiliki akses untuk mengelola oleh-oleh.'
            );
        }
    }

    private function olehOlehRules(): array
    {
        return [

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'jenis' => [
                'required',
                'string',
                'in:Totebag,Baju,Celana,Topi,Gantungan Kunci,Ikat Rambut,Kacamata,Daster,Sandal,Pajangan Tumbuhan,Barongan',
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
                'in:Tersedia,Tidak Tersedia',
            ],

        ];
    }

    private function olehOlehMessages(): array
    {
        return [

            'nama.required' =>
                'Nama oleh-oleh wajib diisi.',

            'nama.max' =>
                'Nama oleh-oleh maksimal 255 karakter.',

            'jenis.required' =>
                'Jenis oleh-oleh wajib dipilih.',

            'jenis.in' =>
                'Jenis oleh-oleh tidak valid.',

            'harga.required' =>
                'Harga oleh-oleh wajib diisi.',

            'deskripsi.max' =>
                'Deskripsi maksimal 5000 karakter.',

            'gambar.image' =>
                'File yang dipilih harus berupa gambar.',

            'gambar.mimes' =>
                'Format gambar harus JPG, JPEG, PNG, atau WEBP.',

            'gambar.max' =>
                'Ukuran gambar maksimal 2 MB.',

            'status.required' =>
                'Status wajib dipilih.',

            'status.in' =>
                'Status tidak valid.',

        ];
    }

    private function normalizeHarga(
        mixed $harga
    ): ?int {

        if (
            $harga === null ||
            $harga === ''
        ) {
            return null;
        }

        $harga = preg_replace(
            '/\D/',
            '',
            (string) $harga
        );

        if (
            $harga === null ||
            $harga === ''
        ) {
            return null;
        }

        $harga = (int) $harga;

        if ($harga <= 0) {
            return null;
        }

        return $harga;
    }

    private function normalizeDeskripsi(
        ?string $deskripsi
    ): ?string {

        if ($deskripsi === null) {
            return null;
        }

        $deskripsi =
            trim($deskripsi);

        return $deskripsi === ''
            ? null
            : $deskripsi;
    }

    private function deleteImage(
        ?string $path
    ): void {

        if (!$path) {
            return;
        }

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

        try {

            if (
                Storage::disk('public')
                    ->exists($path)
            ) {

                Storage::disk('public')
                    ->delete($path);
            }

        } catch (Throwable $e) {

            report($e);
        }
    }
}
