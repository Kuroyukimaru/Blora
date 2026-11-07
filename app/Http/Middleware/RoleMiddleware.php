<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Penggunaan:
     *
     * middleware('role:admin')
     * middleware('role:kasir_menu')
     * middleware('role:kasir_wahana')
     * middleware('role:kasir_oleholeh')
     *
     * Bisa juga beberapa role:
     *
     * middleware('role:admin,kasir_menu')
     * middleware('role:kasir_menu,kasir_wahana')
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | GUARD ADMIN
        |--------------------------------------------------------------------------
        |
        | Semua akun:
        |
        | - admin
        | - kasir_menu
        | - kasir_wahana
        | - kasir_oleholeh
        |
        | login menggunakan guard "admin".
        |
        */

        $guard = auth('admin');


        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        |
        | Kalau belum login, jangan izinkan akses ke route
        | yang menggunakan RoleMiddleware.
        |
        */

        if (!$guard->check()) {

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL USER
        |--------------------------------------------------------------------------
        */

        $user = $guard->user();


        /*
        |--------------------------------------------------------------------------
        | CEK USER
        |--------------------------------------------------------------------------
        |
        | Secara normal check() sudah memastikan user tersedia.
        | Tetapi pengecekan ini tetap dipertahankan sebagai
        | pengaman tambahan.
        |
        */

        if (!$user) {

            $guard->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Sesi login tidak valid. Silakan login kembali.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK ROLE YANG DIBUTUHKAN ROUTE
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | role:admin
        |
        | menghasilkan:
        |
        | ['admin']
        |
        | Sedangkan:
        |
        | role:admin,kasir_menu
        |
        | menghasilkan:
        |
        | ['admin', 'kasir_menu']
        |
        */

        if (empty($roles)) {

            abort(
                403,
                'Role akses belum ditentukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN ROLE
        |--------------------------------------------------------------------------
        |
        | Hilangkan spasi yang tidak sengaja ditulis pada route.
        |
        | Contoh:
        |
        | role:admin, kasir_menu
        |
        | akan dibaca sebagai:
        |
        | admin
        | kasir_menu
        |
        */

        $roles = array_map(
            fn ($role) => trim($role),
            $roles
        );


        /*
        |--------------------------------------------------------------------------
        | ROLE USER
        |--------------------------------------------------------------------------
        */

        $userRole = trim(
            (string) $user->role
        );


        /*
        |--------------------------------------------------------------------------
        | CEK ROLE USER
        |--------------------------------------------------------------------------
        |
        | User hanya boleh melanjutkan request kalau role
        | yang dimilikinya termasuk role yang diizinkan route.
        |
        */

        if (!in_array(
            $userRole,
            $roles,
            true
        )) {

            abort(
                403,
                'Anda tidak memiliki akses ke halaman ini.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE SESUAI
        |--------------------------------------------------------------------------
        |
        | User memiliki role yang diperbolehkan.
        | Request boleh dilanjutkan.
        |
        */

        return $next($request);
    }
}