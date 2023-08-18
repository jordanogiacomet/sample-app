<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::middleware('auth')->name('posts.')->group(function(){


    Route::get('/posts', [PostController::class, 'index'])->name('index')->withoutMiddleware('auth');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('show')->withoutMiddleware('auth');
    Route::post('/posts', [PostController::class, 'store'])->name('store');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('destroy');

});

