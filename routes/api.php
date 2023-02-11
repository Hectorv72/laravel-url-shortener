<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShortenerApiController;
// use Illuminate\Http\Request;
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


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// SHORTENER
Route::prefix('link')->group(function () {
    Route::get('/', [ShortenerApiController::class, 'all']);
    Route::post('/', [ShortenerApiController::class, 'create'])->middleware('auth.optional');
    Route::delete('/', [ShortenerApiController::class, 'delete'])->middleware('auth:sanctum');
    Route::get('/{key}', [ShortenerApiController::class, 'find']);
});

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {
    Route::get('/all', [AuthController::class, 'all']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
