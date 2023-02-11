<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ShortenerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// SHORTENER
Route::get('/links', [ShortenerController::class, 'all']);
Route::get('/links/{key}', [ShortenerController::class, 'find']);
Route::middleware('auth.optional')->post('/links', [ShortenerController::class, 'create']);

// Route::group(['middleware' => ['auth:sanctum']]);

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {
    Route::get('/all', [AuthController::class, 'all']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
