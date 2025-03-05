<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Galleries Routes
    Route::get('/galleries', [GalleryController::class, 'index'])->name('galleries.index');
    Route::get('/galleries/{id}', [GalleryController::class, 'show'])->name('galleries.show');
    Route::post('/galleries', [GalleryController::class, 'store'])->name('galleries.store');
    Route::put('/galleries/{id}', [GalleryController::class, 'update'])->name('galleries.update');
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

    Route::post('/galleries/{id}/image', [GalleryController::class, 'createImg'])->name('galleries.img.store');
    Route::put('/galleries/{id}/image', [GalleryController::class, 'updateImgTitle'])->name('galleries.img.update');
    Route::delete('/galleries/{id}/image', [GalleryController::class, 'destroyImg'])->name('galleries.img.delete');

    // Accesses Routes
    Route::post('/galleries/{id}/access', [AccessController::class, 'store'])->name('galleries.access.store');
    Route::delete('/galleries/{id}/access', [AccessController::class, 'destroy'])->name('galleries.access.delete');
});

require __DIR__ . '/auth.php';