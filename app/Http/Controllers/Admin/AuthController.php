<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN PAGE
    |--------------------------------------------------------------------------
    |
    | Satu halaman login digunakan oleh:
    |
    | - admin
    | - kasir_menu
    | - kasir_wahana
    | - kasir_oleholeh
    |
    */

    public function login()
    {
        return view('admin.auth.login');
    }


    /*
    |--------------------------------------------------------------------------
    | AUTHENTICATE
    |--------------------------------------------------------------------------
    */

    public function authenticate(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $credentials = $request->validate(
            [
                'email' => [
                    'required',
                    'email',
                ],

                'password' => [
                    'required',
                    'string',
                ],
            ],
            [
                'email.required' =>
                    'Email wajib diisi.',

                'email.email' =>
                    'Format email tidak valid.',

                'password.required' =>
                    'Password wajib diisi.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | REMEMBER ME
        |--------------------------------------------------------------------------
        */

        $remember = $request->boolean('remember');


        /*
        |--------------------------------------------------------------------------
        | GUARD
        |--------------------------------------------------------------------------
        */

        $guard = Auth::guard('admin');


        /*
        |--------------------------------------------------------------------------
        | LOGOUT SESSION SEBELUMNYA
        |--------------------------------------------------------------------------
        */

        if ($guard->check()) {
            $guard->logout();
        }


        /*
        |--------------------------------------------------------------------------
        | LOGIN
        |--------------------------------------------------------------------------
        */

        if (!$guard->attempt($credentials, $remember)) {

            return back()
                ->withInput(
                    $request->only('email')
                )
                ->with(
                    'error',
                    'Email atau password salah.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | REGENERATE SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | AMBIL USER
        |--------------------------------------------------------------------------
        */

        $user = $guard->user();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI USER
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            $guard->logout();

            $request
                ->session()
                ->invalidate();

            $request
                ->session()
                ->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Login gagal. Silakan coba lagi.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        $allowedRoles = [

            'admin',

            'kasir_menu',

            'kasir_wahana',

            'kasir_oleholeh',

        ];


        /*
        |--------------------------------------------------------------------------
        | CEK ROLE
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $user->role,
                $allowedRoles,
                true
            )
        ) {

            $guard->logout();

            $request
                ->session()
                ->invalidate();

            $request
                ->session()
                ->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Role akun tidak dikenali.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */

        return $this->redirectByRole(
            $user->role
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $guard = Auth::guard('admin');


        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */

        if (!$guard->check()) {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        $user = $guard->user();


        /*
        |--------------------------------------------------------------------------
        | SESSION TIDAK VALID
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            $guard->logout();

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Sesi login tidak valid.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | BUKAN ADMIN
        |--------------------------------------------------------------------------
        |
        | Kalau kasir mencoba membuka dashboard admin,
        | arahkan kembali ke dashboard sesuai role.
        |
        */

        if ($user->role !== 'admin') {

            return $this->redirectByRole(
                $user->role
            );
        }


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $statistics = [

            'total_user' =>
                0,

            'total_menu' =>
                0,

            'total_wahana' =>
                0,

            'total_oleholeh' =>
                0,

            'total_paket_bundling' =>
                0,

            'total_event' =>
                0,

            'total_pesanan' =>
                0,

            'total_pendapatan' =>
                0,

        ];


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            [

                'user' =>
                    $user,

                'statistics' =>
                    $statistics,

            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | LOGOUT GUARD
        |--------------------------------------------------------------------------
        */

        Auth::guard('admin')->logout();


        /*
        |--------------------------------------------------------------------------
        | INVALIDATE SESSION
        |--------------------------------------------------------------------------
        */

        $request
            ->session()
            ->invalidate();


        /*
        |--------------------------------------------------------------------------
        | REGENERATE CSRF
        |--------------------------------------------------------------------------
        */

        $request
            ->session()
            ->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Anda berhasil keluar dari sistem.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REDIRECT BERDASARKAN ROLE
    |--------------------------------------------------------------------------
    |
    | Setiap role diarahkan ke dashboard masing-masing.
    |
    | ADMIN
    |       admin.dashboard
    |
    | KASIR MENU
    |       kasir.menu.dashboard
    |
    | KASIR WAHANA
    |       kasir.wahana.dashboard
    |
    | KASIR OLEH-OLEH
    |       kasir.oleholeh.dashboard
    |
    */

    private function redirectByRole(
        string $role
    ) {

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        if ($role === 'admin') {

            if (
                Route::has(
                    'admin.dashboard'
                )
            ) {

                return redirect()
                    ->route(
                        'admin.dashboard'
                    );
            }


            return redirect(
                url('/admin/dashboard')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | KASIR MENU
        |--------------------------------------------------------------------------
        */

        if ($role === 'kasir_menu') {

            if (
                Route::has(
                    'kasir.menu.dashboard'
                )
            ) {

                return redirect()
                    ->route(
                        'kasir.menu.dashboard'
                    );
            }


            /*
            | Fallback URL
            */

            return redirect(
                url('/kasir-menu/home')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | KASIR WAHANA
        |--------------------------------------------------------------------------
        */

        if ($role === 'kasir_wahana') {

            if (
                Route::has(
                    'kasir.wahana.dashboard'
                )
            ) {

                return redirect()
                    ->route(
                        'kasir.wahana.dashboard'
                    );
            }


            /*
            | Fallback URL
            */

            return redirect(
                url('/kasir-wahana/home')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | KASIR OLEH-OLEH
        |--------------------------------------------------------------------------
        */

        if ($role === 'kasir_oleholeh') {

            if (
                Route::has(
                    'kasir.oleholeh.dashboard'
                )
            ) {

                return redirect()
                    ->route(
                        'kasir.oleholeh.dashboard'
                    );
            }


            /*
            | Fallback URL
            */

            return redirect(
                url('/kasir-oleholeh/home')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE TIDAK VALID
        |--------------------------------------------------------------------------
        */

        Auth::guard('admin')->logout();

        return redirect()
            ->route('login')
            ->with(
                'error',
                'Role akun tidak dikenali.'
            );
    }
}