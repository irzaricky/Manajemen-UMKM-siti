<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListProdukController;
use App\Http\Controllers\OrderController;
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
        Route::put('/{id}', [ListProdukController::class, 'update'])->name('dashboard.produk.update');
        Route::get('/create', [ListProdukController::class, 'create'])->name('dashboard.produk.create');
        Route::post('/store', [ListProdukController::class, 'store'])->name('dashboard.produk.store');
        Route::delete('/delete/{id}', [ListProdukController::class, 'destroy'])->name('dashboard.produk.delete');
    });

    Route::prefix('/dashboard/order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::post('/add', [OrderController::class, 'addToOrder'])->name('order.add');
        Route::post('/remove', [OrderController::class, 'removeFromOrder'])->name('order.remove');
        Route::post('/process', [OrderController::class, 'processOrder'])->name('order.process');
    });

});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
