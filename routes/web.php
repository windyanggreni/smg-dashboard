<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('login');
});

// Route::get('/dashboard', function () {
//     return view('index');
// });
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

// Dashboard hanya bisa diakses jika sudah login
Route::middleware('auth')->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('index');
    // });
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/item/{id}/upload-revision', [OrderController::class, 'uploadRevision'])->name('orders.uploadRevision');
    Route::post('/orders/{orderItem}/upload-design', [OrderController::class, 'uploadDesign'])->name('orders.uploadDesign');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/transaksi/pdf', [LaporanController::class, 'cetakTransaksiPDF'])->name('laporan.transaksi.pdf');
    Route::get('/laporan/stok', [LaporanController::class, 'stokIndex'])->name('laporan.stok.index');
    Route::get('/laporan/stok/pdf', [LaporanController::class, 'cetakStokPdf'])->name('laporan.stok.pdf');
    Route::get('/laporan/performa', [LaporanController::class, 'performaIndex'])->name('laporan.performa.index');
    Route::get('/laporan/performa/pdf', [LaporanController::class, 'cetakPerformaPdf'])->name('laporan.performa.pdf');

});
