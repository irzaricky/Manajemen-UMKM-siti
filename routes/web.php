<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\LaporanKeuntunganController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});



Route::group(['middleware' => 'auth', 'verified'], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('/dashboard/produk')->group(function () {
        Route::get('/', [ListProdukController::class, 'index'])->name('dashboard.produk.index');
        Route::get('/edit/{id}', [ListProdukController::class, 'edit'])->name('dashboard.produk.edit');
        Route::post('/{id}', [ListProdukController::class, 'update'])->name('dashboard.produk.update');
        Route::get('/create', [ListProdukController::class, 'create'])->name('dashboard.produk.create');
        Route::post('/store', [ListProdukController::class, 'store'])->name('dashboard.produk.store');
        Route::delete('/delete/{id}', [ListProdukController::class, 'destroy'])->name('dashboard.produk.delete');
    });

    Route::prefix('/dashboard/order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::get('/kasir', [OrderController::class, 'kasir'])->name('order.kasir');
        Route::post('/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
        Route::post('/add', [OrderController::class, 'addToOrder'])->name('order.add');
        Route::post('/remove', [OrderController::class, 'removeFromOrder'])->name('order.remove');
        Route::post('/process', [OrderController::class, 'processOrder'])->name('order.process');
    });

    Route::prefix('/laporan')->middleware(['auth'])->group(function () {
        Route::get('/penjualan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/penjualan/{date}/detail', [LaporanController::class, 'detail'])->name('laporan.detail');
        Route::delete('/transaction/{id}', [LaporanController::class, 'destroyTransaction'])->name('laporan.transaction.destroy');

        Route::get('/keuntungan', [LaporanKeuntunganController::class, 'index'])
            ->name('laporan.keuntungan.index');
    });

    Route::prefix('/bahan-baku')->middleware(['auth'])->group(function () {
        Route::get('/', [BahanBakuController::class, 'index'])->name('bahan-baku.index');
        Route::get('/create', [BahanBakuController::class, 'create'])->name('bahan-baku.create');
        Route::post('/', [BahanBakuController::class, 'store'])->name('bahan-baku.store');
        Route::get('/{id}/edit', [BahanBakuController::class, 'edit'])->name('bahan-baku.edit');
        Route::post('/{id}', [BahanBakuController::class, 'update'])->name('bahan-baku.update');
        Route::delete('/{id}', [BahanBakuController::class, 'destroy'])->name('bahan-baku.destroy');
        Route::post('/bahan-baku/beli', [BahanBakuController::class, 'storePembelian'])->name('bahan-baku.storePembelian');
        Route::get('/bahan-baku/{id}/beli', [BahanBakuController::class, 'showBeli'])->name('bahan-baku.showBeli');
    });

});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
