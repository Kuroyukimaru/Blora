<?php

use Illuminate\Support\Facades\Route;

use App\Models\Menu;
use App\Models\TiketWahana;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TiketWahanaController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\EventController;

/*
|--------------------------------------------------------------------------
| PUBLIC HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $menus = Menu::latest()->get();

    $tiketWahanas =
        TiketWahana::latest()->get();

    return view(
        'public.home',
        compact(
            'menus',
            'tiketWahanas'
        )
    );

});

/*
|--------------------------------------------------------------------------
| PUBLIC MENU
|--------------------------------------------------------------------------
*/

Route::get('/menu', function () {

    $menus = Menu::latest()->get();

    return view(
        'public.menu.index',
        compact('menus')
    );

});

/*
|--------------------------------------------------------------------------
| PUBLIC TIKET WAHANA
|--------------------------------------------------------------------------
*/

Route::get('/tiket-wahana', function () {

    $tiketWahanas =
        TiketWahana::latest()->get();

    return view(
        'public.tiket-wisata.index',
        compact(
            'tiketWahanas'
        )
    );

});

/*
|--------------------------------------------------------------------------
| AUTH ADMIN
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/login',
    [AuthController::class,'login']
)->name(
    'admin.login'
);

Route::post(
    '/admin/login',
    [AuthController::class,'authenticate']
);

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(
    'auth:admin'
)->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/dashboard',
        [AuthController::class,'dashboard']
    );

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/admin/logout',
        [AuthController::class,'logout']
    );

    /*
    |--------------------------------------------------------------------------
    | MENU
    |--------------------------------------------------------------------------
    */

    Route::prefix(
        'admin/menu'
    )->group(function () {

        Route::get('/', [MenuController::class,'index']);

        Route::get('/create', [MenuController::class,'create']);

        Route::post('/store', [MenuController::class,'store']);

        Route::get('/edit/{id}', [MenuController::class,'edit']);

        Route::put('/update/{id}', [MenuController::class,'update']);

        Route::delete('/delete/{id}', [MenuController::class,'destroy']);

    });

    /*
    |--------------------------------------------------------------------------
    | TIKET WAHANA
    |--------------------------------------------------------------------------
    */

    Route::prefix(
        'admin/tiket-wahana'
    )->group(function () {

        Route::get('/', [TiketWahanaController::class,'index']);

        Route::get('/create', [TiketWahanaController::class,'create']);

        Route::post('/store', [TiketWahanaController::class,'store']);

        Route::get('/edit/{id}', [TiketWahanaController::class,'edit']);

        Route::put('/update/{id}', [TiketWahanaController::class,'update']);

        Route::delete('/delete/{id}', [TiketWahanaController::class,'destroy']);

    });

    /*
    |--------------------------------------------------------------------------
    | PAKET
    |--------------------------------------------------------------------------
    */

    Route::prefix(
        'admin/paket'
    )->group(function () {

        Route::get('/', [PaketController::class,'index']);

        Route::get('/create', [PaketController::class,'create']);

        Route::post('/store', [PaketController::class,'store']);

        Route::get('/edit/{id}', [PaketController::class,'edit']);

        Route::put('/update/{id}', [PaketController::class,'update']);

        Route::delete('/delete/{id}', [PaketController::class,'destroy']);

    });

    /*
    |--------------------------------------------------------------------------
    | EVENT
    |--------------------------------------------------------------------------
    */

    Route::prefix(
        'admin/event'
    )->group(function () {

        Route::get(
            '/',
            [EventController::class,'index']
        )->name('event.index');

        Route::get(
            '/create',
            [EventController::class,'create']
        )->name('event.create');

        Route::post(
            '/store',
            [EventController::class,'store']
        )->name('event.store');

        Route::get(
            '/edit/{id}',
            [EventController::class,'edit']
        )->name('event.edit');

        Route::put(
            '/update/{id}',
            [EventController::class,'update']
        )->name('event.update');

        Route::delete(
            '/delete/{id}',
            [EventController::class,'destroy']
        )->name('event.destroy');

    });

});