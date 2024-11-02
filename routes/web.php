<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
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
        Route::get('/', [ProdukController::class, 'index'])->name('dashboard.produk.index');
        Route::get('/edit/{id}', [ProdukController::class, 'edit'])->name('dashboard.produk.edit');
        Route::put('/{id}', [ProdukController::class, 'update'])->name('dashboard.produk.update');
        Route::get('/create', [ProdukController::class, 'create'])->name('dashboard.produk.create');
        Route::post('/store', [ProdukController::class, 'store'])->name('dashboard.produk.store');
        Route::get('/delete/{id}', [ProdukController::class, 'destroy'])->name('dashboard.produk.delete');
    });

});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
