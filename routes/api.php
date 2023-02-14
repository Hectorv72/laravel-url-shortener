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
Route::group(['prefix' => 'shortener', 'as' => 'api.shortener.'], function () {
    Route::get('/', [ShortenerApiController::class, 'all'])->name('all');
    Route::get('/{key}', [ShortenerApiController::class, 'find'])->name('find');
    Route::middleware('auth.optional')->post('/', [ShortenerApiController::class, 'create'])->name('create');
});


// AUTH
Route::group(['as' => 'api.auth.'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {
        Route::get('/all', [AuthController::class, 'all'])->name('all');
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
