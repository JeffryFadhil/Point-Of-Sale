<?php

use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest'); // Ensure this route is accessible only to guests (not logged in users)
Route::post('/login', [loginController::class, 'HandleLogin'])->name('login')->middleware('guest'); // Handle login for guests

route::middleware('auth')->group(function () {
    // Define routes that require authentication here
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Ensure this route is accessible only to authenticated users
    Route::post('/logout', [loginController::class, 'logout'])->name('logout');

    Route::prefix('get-data')->as('get-data.')->group(function () {
       Route::get('/product', [ProductController::class, 'getData'])->name('product'); // Get product data
       Route::get('/cek-stok', [ProductController::class, 'cekStok'])->name('cek-stok'); // Check stock
    });

    Route::prefix('users')->as('users.')->controller(userController::class)->group(function () {
        Route::get('/', 'index')->name('index'); // List users
        Route::post('/store', 'store')->name('store'); // Store a new user
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::post('/ganti-password', 'gantiPassword')->name('ganti-password'); // Ganti password
    });

    Route::prefix('master-data')->as('master-data.')->group(function () {

        Route::prefix('kategori')->as('kategori')->controller(KategoriController::class)->group(function () {
            Route::get('/', 'index')->name('.index');
            Route::post('/store', 'store')->name('.store');
            Route::delete('/destroy/{id}', 'destroy')->name('.destroy');
        });

        Route::prefix('product')->as('product')->controller(ProductController::class)->group(function () {
            Route::get('/', 'index')->name('.index');
            Route::post('/store', 'store')->name('.store');
            Route::delete('/destroy/{id}', 'destroy')->name('.destroy');
        });
    });

    Route::prefix('penerimaan-barang')->as('penerimaan-barang.')->controller(PenerimaanBarangController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });
});