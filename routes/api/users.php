<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/users/login', [UserController::class, 'login'])->name('users.login');


Route::middleware('auth:sanctum')->name('users.')->group(function(){
    Route::get('/users', [UserController::class, 'index'])->name('index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('show')->whereNumber('user');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('destroy');
});


Route::middleware('auth:sanctum')->post('/users/logout', [UserController::class, 'logout'])->name('users.logout');


// Rota para exibir uma mensagem de erro para usuários não autenticados
Route::get('/error-message', function () {
    return response()->json([
        'message' => 'Usuário não autenticado'
    ]);
})->name('error-message');
