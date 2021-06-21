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


// Auth Routes
Route::prefix('auth')->name('auth.')->group(function () {
  Route::post('/login', 'AuthController@login')->name('login');
  Route::post('/logout', 'AuthController@logout')->name('logout');
  Route::put('/change-password', 'AuthController@changePassword')->name('change-password');

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

// Poli Routes
Route::prefix('poli')->name('poli.')->group(function () {
  Route::get('/', 'PoliController@index')->name('index');
  Route::get('/{poli}', 'PoliController@show')->name('show');
  Route::post('/', 'PoliController@store')->name('store');
  Route::put('/{poli}', 'PoliController@update')->name('update');
  Route::delete('/{poli}', 'PoliController@destroy')->name('destroy');
});

// Dokter Routes
Route::prefix('dokter')->name('dokter.')->group(function () {
  Route::get('/', 'DokterController@index')->name('index');
  Route::get('user/{user}', 'DokterController@getByUserId')->name('get-by-user');
  Route::get('/{dokter}', 'DokterController@show')->name('show');
});

// Rekam Medis Routes
Route::prefix('rekam-medis')->name('rekam-medis.')->group(function () {
  Route::post('/', 'RekamMedisController@store')->name('store');
  Route::get('/antrian', 'RekamMedisController@antrian')->name('antrian');
  Route::get('/{rekamMedis}', 'RekamMedisController@show')->name('show');
  Route::put('/{rekamMedis}', 'RekamMedisController@update')->name('update');
  // Route::get('/{pasien}', 'RekamMedisController@index')->name('index');
});


// Obat Routes
Route::prefix('obat')->name('obat.')->group(function () {
  Route::get('/', 'ObatController@index')->name('index');
  Route::get('/{obat}', 'ObatController@show')->name('show');
  Route::post('/', 'ObatController@store')->name('store');
  Route::put('/{obat}', 'ObatController@update')->name('update');
  Route::delete('/{obat}', 'ObatController@destroy')->name('destroy');
});

// Antrian Obat Routes
Route::prefix('antrian-obat')->name('antrian-obat.')->group(function () {
  Route::get('/antrian', 'AntrianObatController@antrian')->name('antrian');
});

// Pasien Routes
Route::prefix('pasien')->name('pasien.')->group(function () {
  Route::get('/live/search', 'PasienController@liveSearch')->name('live-search');
  Route::get('/', 'PasienController@index')->name('index');
  Route::get('/{pasien}', 'PasienController@show')->name('show');
  Route::post('/', 'PasienController@store')->name('store');
  Route::put('/{pasien}', 'PasienController@update')->name('update');
  Route::delete('/{pasien}', 'PasienController@destroy')->name('destroy');
});
