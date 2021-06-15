<?php

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


Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', 'AuthController@login')->name('login');
    // Route::post('/change-password', 'AuthController@changePassword')->name('change-password');
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});

// User Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/{user}', 'UserController@show')->name('show');
    Route::post('/', 'UserController@store')->name('store');
    Route::put('/{user}', 'UserController@update')->name('update');
    Route::delete('/{user}', 'UserController@destroy')->name('destroy');
});

// Dokter Routes
Route::prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/', 'DokterController@index')->name('index');
    Route::get('/{dokter}', 'DokterController@show')->name('show');
});
