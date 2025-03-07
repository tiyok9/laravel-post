<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'home'])->name('home');

Route::prefix('posts')->controller(PostController::class)->group(function () {
    Route::get('/', 'index')->name('posts.index');
    Route::get('/{post}', 'show')->name('posts.show');

    Route::middleware(['auth',\App\Http\Middleware\OwnerPost::class])->group(function () {
        Route::patch('/{id}/update', 'update')->name('posts.update');
        Route::delete('/{id}/delete', 'destroy')->name('posts.destroy');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/create', 'create')->name('posts.create');
        Route::get('/{post}/edit', 'edit')->name('posts.edit');
        Route::post('/create', 'store')->name('posts.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
