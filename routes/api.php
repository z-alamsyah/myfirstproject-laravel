<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// JWT Authentication Routes with Cookie Middleware
Route::group(['middleware' => 'jwt.cookie'], function ($router) {
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected routes (require authentication)
    Route::group(['middleware' => 'auth:api'], function ($router) {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/refresh', [AuthController::class, 'refresh']);
        Route::get('/auth/profile', [AuthController::class, 'profile']);
    });
});

// Legacy Sanctum route (kept for reference)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
