<?php

use App\Http\Controllers\AdminController;
// use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
    return view('welcome');
});

Route::controller(LoginController::class)->group(function(){
    Route::get('login','index')->name('login');
    Route::post('login/proses','proses');
    Route::get('logout','logout');
    Route::get('register','create');
    Route::post('akun','store');
});

Route::controller(GoogleController::class)->group(function(){
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::get('auth/google',[\App\Http\Controllers\GoogleController::class, 'redirectToGoogle']);


Route::group(['middleware' => ['auth']],function(){
    Route::group(['middleware' => ['CekUser:1']],function(){
        Route::resource('admin',AdminController::class);
    });
});
Route::group(['middleware' => ['auth']],function(){
    Route::group(['middleware' => ['CekUser:2']],function(){
        Route::resource('kasir',KasirController::class);
    });
});
Route::group(['middleware' => ['auth']],function(){
    Route::group(['middleware' => ['CekUser:3']],function(){
        Route::resource('guru',GuruController::class);
    });
});
Route::group(['middleware' => ['auth']],function(){
    Route::group(['middleware' => ['CekUser:4']],function(){
        Route::resource('siswa',SiswaController::class);
    });
});

