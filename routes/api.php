<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\Routes\RouteHelper;
use Illuminate\Support\Facades\Route;


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



Route::group([], function(){
    RouteHelper::includeRouteFiles(__DIR__ . '/api');
});


// require __DIR__ . '/api/users.php';
// require __DIR__ . '/api/posts.php';
// require __DIR__ . '/api/comments.php';


// Route::apiResource('users', UserController::class);



