<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\PaketBundling;
use App\Models\TiketWahana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class PaketBundlingController extends Controller
{
    public function index(): View
    {
        $paketBundlings = PaketBundling::query()
            ->with(['menus', 'wahanas'])
            ->latest('created_at')
            ->get();

        return view('admin.paketbundling.index', compact('paketBundlings'));
    }

    public function create(): View
    {
        $menus = Menu::query()
            ->where('status', 'Tersedia')
            ->orderBy('nama_menu')
            ->get();

        $wahanas = TiketWahana::query()
            ->where('status', 'Tersedia')
            ->orderBy('nama_wahana')
            ->get();

        return view('admin.paketbundling.create', compact('menus', 'wahanas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $menuIds = $this->normalizeIds($validated['menu_ids']);
        $wahanaIds = $this->normalizeIds($validated['wahana_ids']);

        if (!$this->allMenusAvailable($menuIds)) {
            return back()->withInput()->with('error',
                'Ada menu yang dipilih tetapi sudah tidak tersedia.');
        }

        if (!$this->allWahanasAvailable($wahanaIds)) {
            return back()->withInput()->with('error',
                'Ada wahana yang dipilih tetapi sudah tidak tersedia.');
        }

        $gambar = null;

        try {
            DB::beginTransaction();

            if ($request->hasFile('gambar')) {
                Storage::disk('public')->makeDirectory('paketbundling');

                $gambar = $request->file('gambar')
                    ->store('paketbundling', 'public');
            }

            $paket = PaketBundling::query()->create([
                'id_user' => Auth::guard('admin')->id(),
                'nama_paket' => $validated['nama_paket'],
                'untuk' => $validated['untuk'],
                'harga' => $this->normalizePrice($validated['harga']),
                'deskripsi' => $validated['deskripsi'] ?? null,
                'gambar' => $gambar,
                'status' => $validated['status'],
            ]);

            $paket->menus()->sync($menuIds);
            $paket->wahanas()->sync($wahanaIds);

            DB::commit();

            return redirect()
                ->route('admin.paketbundling.index')
                ->with('success', 'Paket bundling berhasil ditambahkan.');
        } catch (Throwable $e) {
            DB::rollBack();

            if ($gambar && Storage::disk('public')->exists($gambar)) {
                Storage::disk('public')->delete($gambar);
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'Paket bundling gagal ditambahkan. Silakan coba lagi.');
        }
    }

    public function edit(int $id): View
    {
        $paketBundling = PaketBundling::query()
            ->with(['menus', 'wahanas'])
            ->findOrFail($id);

        /*
         * Item yang sedang dipakai paket tetap ditampilkan ketika edit,
         * walaupun status master-nya sudah berubah. Item baru harus tersedia.
         */
        $selectedMenuIds = $paketBundling->menus
            ->pluck('id_menu')
            ->map(fn ($id) => (int) $id);

        $menus = Menu::query()
            ->where(function ($query) use ($selectedMenuIds) {
                $query->where('status', 'Tersedia')
                    ->orWhereIn('id_menu', $selectedMenuIds);
            })
            ->orderBy('nama_menu')
            ->get();

        $selectedWahanaIds = $paketBundling->wahanas
            ->pluck('id_tiket_wahana')
            ->map(fn ($id) => (int) $id);

        $wahanas = TiketWahana::query()
            ->where(function ($query) use ($selectedWahanaIds) {
                $query->where('status', 'Tersedia')
                    ->orWhereIn('id_tiket_wahana', $selectedWahanaIds);
            })
            ->orderBy('nama_wahana')
            ->get();

        return view(
            'admin.paketbundling.edit',
            compact('paketBundling', 'menus', 'wahanas')
        );
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $paket = PaketBundling::query()
            ->with(['menus', 'wahanas'])
            ->findOrFail($id);

        $validated = $this->validateData($request);

        $menuIds = $this->normalizeIds($validated['menu_ids']);
        $wahanaIds = $this->normalizeIds($validated['wahana_ids']);

        /*
         * Item yang sudah menjadi bagian paket boleh dipertahankan.
         * Hanya item baru yang wajib berstatus Tersedia.
         */
        $oldMenuIds = $paket->menus
            ->pluck('id_menu')
            ->map(fn ($id) => (int) $id)
            ->all();

        $newMenuIds = array_values(array_diff($menuIds, $oldMenuIds));

        if (!empty($newMenuIds) && !$this->allMenusAvailable($newMenuIds)) {
            return back()->withInput()->with('error',
                'Ada menu baru yang dipilih tetapi sudah tidak tersedia.');
        }

        $oldWahanaIds = $paket->wahanas
            ->pluck('id_tiket_wahana')
            ->map(fn ($id) => (int) $id)
            ->all();

        $newWahanaIds = array_values(array_diff($wahanaIds, $oldWahanaIds));

        if (!empty($newWahanaIds) && !$this->allWahanasAvailable($newWahanaIds)) {
            return back()->withInput()->with('error',
                'Ada wahana baru yang dipilih tetapi sudah tidak tersedia.');
        }

        $gambarLama = $paket->gambar;
        $gambarBaru = $gambarLama;

        try {
            DB::beginTransaction();

            if ($request->hasFile('gambar')) {
                Storage::disk('public')->makeDirectory('paketbundling');

                $gambarBaru = $request->file('gambar')
                    ->store('paketbundling', 'public');
            }

            $paket->update([
                'nama_paket' => $validated['nama_paket'],
                'untuk' => $validated['untuk'],
                'harga' => $this->normalizePrice($validated['harga']),
                'deskripsi' => $validated['deskripsi'] ?? null,
                'gambar' => $gambarBaru,
                'status' => $validated['status'],
            ]);

            $paket->menus()->sync($menuIds);
            $paket->wahanas()->sync($wahanaIds);

            DB::commit();

            if (
                $gambarBaru !== $gambarLama &&
                $gambarLama &&
                Storage::disk('public')->exists($gambarLama)
            ) {
                Storage::disk('public')->delete($gambarLama);
            }

            return redirect()
                ->route('admin.paketbundling.index')
                ->with('success', 'Paket bundling berhasil diperbarui.');
        } catch (Throwable $e) {
            DB::rollBack();

            if (
                $gambarBaru !== $gambarLama &&
                $gambarBaru &&
                Storage::disk('public')->exists($gambarBaru)
            ) {
                Storage::disk('public')->delete($gambarBaru);
            }

            report($e);

            return back()
                ->withInput()
                ->with('error', 'Paket bundling gagal diperbarui. Silakan coba lagi.');
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        $paket = PaketBundling::query()->findOrFail($id);
        $gambar = $paket->gambar;

        try {
            DB::beginTransaction();

            $paket->menus()->detach();
            $paket->wahanas()->detach();
            $paket->delete();

            DB::commit();

            if ($gambar && Storage::disk('public')->exists($gambar)) {
                Storage::disk('public')->delete($gambar);
            }

            return redirect()
                ->route('admin.paketbundling.index')
                ->with('success', 'Paket bundling berhasil dihapus.');
        } catch (Throwable $e) {
            DB::rollBack();
            report($e);

            return back()
                ->with('error', 'Paket bundling gagal dihapus. Silakan coba lagi.');
        }
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama_paket' => ['required', 'string', 'max:255'],
            'untuk' => ['required', 'in:Anak-anak,Dewasa'],
            'harga' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:Tersedia,Tidak Tersedia'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'menu_ids' => ['required', 'array', 'min:1'],
            'menu_ids.*' => ['integer', 'distinct', 'exists:menus,id_menu'],

            'wahana_ids' => ['required', 'array', 'min:1'],
            'wahana_ids.*' => ['integer', 'distinct', 'exists:tiket_wahanas,id_tiket_wahana'],
        ], [
            'nama_paket.required' => 'Nama paket wajib diisi.',
            'untuk.required' => 'Kategori pengunjung wajib dipilih.',
            'harga.required' => 'Harga paket wajib diisi.',
            'harga.numeric' => 'Harga paket harus berupa angka.',
            'harga.min' => 'Harga paket tidak boleh kurang dari 0.',
            'status.required' => 'Status paket wajib dipilih.',

            'menu_ids.required' => 'Minimal pilih 1 menu untuk paket bundling.',
            'menu_ids.min' => 'Minimal pilih 1 menu untuk paket bundling.',
            'menu_ids.*.exists' => 'Menu yang dipilih tidak ditemukan.',

            'wahana_ids.required' => 'Minimal pilih 1 wahana untuk paket bundling.',
            'wahana_ids.min' => 'Minimal pilih 1 wahana untuk paket bundling.',
            'wahana_ids.*.exists' => 'Wahana yang dipilih tidak ditemukan.',

            'gambar.image' => 'File gambar harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);
    }

    private function normalizeIds(array $ids): array
    {
        return collect($ids)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    private function allMenusAvailable(array $ids): bool
    {
        if (empty($ids)) {
            return false;
        }

        return Menu::query()
            ->whereIn('id_menu', $ids)
            ->where('status', 'Tersedia')
            ->count() === count($ids);
    }

    private function allWahanasAvailable(array $ids): bool
    {
        if (empty($ids)) {
            return false;
        }

        return TiketWahana::query()
            ->whereIn('id_tiket_wahana', $ids)
            ->where('status', 'Tersedia')
            ->count() === count($ids);
    }

    private function normalizePrice(mixed $value): int
    {
        $value = trim((string) $value);
        $value = preg_replace('/^Rp\\s*/i', '', $value);
        $value = str_replace([' ', '.', ','], '', $value);

        return max(0, (int) $value);
    }
}
