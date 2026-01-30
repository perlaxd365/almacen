<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/index', function () {
        return view('index');
    })->name('index');
});


Route::group(['middleware' => ['auth']], function () {
    /**
     * Logout Route
     */
    Route::get('index', [IndexController::class, 'index'])->name('index');
    
    /**
     * Producto
     */
    Route::get('producto', [ProductoController::class, 'index'])->name('producto');

});
