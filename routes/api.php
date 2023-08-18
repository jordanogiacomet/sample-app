<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/users', [UserController::class, 'index']);

Route::get('/users/{user}', [UserController::class, 'show']);

Route::post('/users', [UserController::class, 'store']);

Route::patch('/users/{user}', [UserController::class, 'update']);

Route::delete('/users/{user}', [UserController::class, 'destroy']);


