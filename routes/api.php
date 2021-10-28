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

Route::prefix('music/v1')->namespace('Music\V1')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');

    Route::middleware('auth:music')->group(function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@me');
    });
});
