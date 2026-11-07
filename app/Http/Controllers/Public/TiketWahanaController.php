<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\TiketWahana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TiketWahanaController extends Controller
{
    public function index(Request $request): View
    {
        $searchInput = $request->query('search', '');
        $search = is_string($searchInput) ? trim($searchInput) : '';

        $sortInput = $request->query('sort', 'name_asc');
        $allowedSorts = ['name_asc', 'name_desc', 'price_asc', 'price_desc', 'newest'];
        $sort = is_string($sortInput) && in_array($sortInput, $allowedSorts, true)
            ? $sortInput
            : 'name_asc';

        $query = TiketWahana::query()
            ->whereRaw("LOWER(TRIM(COALESCE(status, ''))) = ?", ['tersedia']);

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('nama_wahana', 'like', '%' . $search . '%')
                    ->orWhere('ketentuan', 'like', '%' . $search . '%');
            });
        }

        switch ($sort) {
            case 'name_desc':
                $query->orderBy('nama_wahana', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('harga', 'asc')->orderBy('nama_wahana', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('harga', 'desc')->orderBy('nama_wahana', 'asc');
                break;
            case 'newest':
                $query->orderByDesc('id_tiket_wahana');
                break;
            default:
                $query->orderBy('nama_wahana', 'asc');
                break;
        }

        $tiketWahanas = $query->get();

        $tiketWahanas->each(function (TiketWahana $wahana): void {
            $wahana->setAttribute('gambar_url', $this->resolveImageUrl($wahana->gambar));
        });

        return view('public.tiket-wahana.index', [
            'tiketWahanas' => $tiketWahanas,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function show(int $id): View
    {
        $tiketWahana = TiketWahana::query()
            ->where('id_tiket_wahana', $id)
            ->whereRaw("LOWER(TRIM(COALESCE(status, ''))) = ?", ['tersedia'])
            ->firstOrFail();

        $tiketWahana->setAttribute(
            'gambar_url',
            $this->resolveImageUrl($tiketWahana->gambar)
        );

        return view('public.tiket-wahana.show', [
            'tiketWahana' => $tiketWahana,
            'wahana' => $tiketWahana,
        ]);
    }

    private function resolveImageUrl(mixed $gambar): ?string
    {
        if (!is_string($gambar) || trim($gambar) === '') {
            return null;
        }

        $gambar = trim($gambar);

        if (filter_var($gambar, FILTER_VALIDATE_URL)) {
            return $gambar;
        }

        $gambar = str_replace('\\', '/', $gambar);
        $gambar = ltrim($gambar, '/');

        if (str_starts_with($gambar, 'storage/')) {
            return asset($gambar);
        }

        if (str_starts_with($gambar, 'public/')) {
            $gambar = substr($gambar, strlen('public/'));
        }

        if (str_starts_with($gambar, 'images/')) {
            return asset($gambar);
        }

        return Storage::disk('public')->url($gambar);
    }
}
