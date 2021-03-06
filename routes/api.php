<?php

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

// Music
Route::prefix('music/v1')->namespace('Music\V1')->group(function () {
	// 前台
	Route::post('register', 'AuthController@register');
	Route::post('login', 'AuthController@login');
	Route::post('refresh', 'AuthController@refresh');

	Route::get('music-type', 'MusicTypeController@index');
	Route::get('music-type/{musicType}', 'MusicTypeController@show');
	Route::get('music', 'MusicController@index');
	Route::get('music/{music}', 'MusicController@show');

	Route::middleware('auth:music_user')->group(function () {
		Route::get('music/like', 'MusicController@likeList');
		Route::get('music/{music}/like', 'MusicController@like');
		Route::get('music/{music}/unlike', 'MusicController@unlike');
		Route::get('logout', 'AuthController@logout');
		Route::get('user', 'AuthController@me');
	});

	// 後台
	Route::prefix('admin')->namespace('Admin')->group(function () {
		Route::post('login', 'AuthController@login');
		Route::post('refresh', 'AuthController@refresh');

		Route::middleware('auth:music_admin')->group(function () {
			Route::apiResource('music-type', MusicTypeController::class);
			Route::apiResource('music', MusicController::class);
			Route::get('logout', 'AuthController@logout');
			Route::get('user', 'AuthController@me');
		});
	});
});
