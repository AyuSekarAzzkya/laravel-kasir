<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminTransaksiDetailController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;


Route::get('/login',[AdminAuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login/do', [AdminAuthController::class, 'doLogin'])->middleware('guest');
Route::get('logout', [AdminAuthController::class, 'logout'])->middleware('auth');

Route::get('/', function () {
    $data = [
        'content' => 'admin.dashboard.index'
    ];
    return view('admin.layouts.wrapper', $data);
})->middleware('auth');

Route::prefix('/admin')->middleware('auth')->group(function(){

    Route::get('/dashboard',function(){
        $data = [
            'content' => 'admin.dashboard.index'
        ];
        return view('admin.layouts.wrapper', $data);

    }); 

    Route::get('transaksi/detail/delete', [AdminTransaksiDetailController::class, 'delete']);
    Route::get('transaksi/detail/selesai/{id}', [AdminTransaksiDetailController::class, 'done']);
    Route::post('transaksi/detail/create', [AdminTransaksiDetailController::class, 'create']);



    Route::resource('/transaksi', AdminTransaksiController::class);

    Route::get('produk', [AdminProdukController::class, 'index'])->name('produk');
    Route::get('produk/create', [AdminProdukController::class, 'create'])->name('produk.create');
    Route::post('produk/store', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::get('produk/edit/{produkId}', [AdminProdukController::class, 'edit'])->name('produk.edit');
    Route::PUT('produk/update/{produkId}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('produk/delete/{produkId}', [AdminProdukController::class, 'destroy'])->name('produk.delete');

    Route::get('kategori', [AdminKategoriController::class, 'index'])->name('kategori');
    Route::get('kategori/create', [AdminKategoriController::class, 'create'])->name('kategori.create');
    Route::post('kategori/store', [AdminKategoriController::class, 'store'])->name('kategori.store');
    Route::get('kategori/edit/{kategoriId}', [AdminKategoriController::class, 'edit'])->name('kategori.edit');
    Route::PUT('kategori/update/{kategoriId}', [AdminKategoriController::class, 'update'])->name('kategori.update');
    Route::delete('kategori/delete/{kategoriId}', [AdminKategoriController::class, 'destroy'])->name('kategori.delete');

    // Route::resource('/kategori', AdminKategoriController::class);
    Route::resource('/user', AdminUserController::class);
});



