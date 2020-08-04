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

Route::get('user/profile','API\UserController@infoLogin');
Route::post('user/login','API\UserController@login');
Route::post('user/logout','API\UserController@logout');
Route::post('user/register','API\UserController@store');
Route::post('user/profile','API\UserController@update');

Route::apiResource('user','API\UserController')->except(['store','update']);
Route::apiResource('user.postingan','API\UserPostinganController')->only(['index']);
Route::apiResource('user.media','API\UserMediaController')->only(['index']);
Route::apiResource('user.like','API\UserLikeController')->only(['index']);
Route::apiResource('user.komentar','API\UserKomentarController')->only(['index']);
Route::apiResource('user.teman','UserPertemananController')->shallow();


Route::apiResource('postingan','API\PostinganController');
Route::apiResource('postingan.like','API\PostinganLikeController')->only(['index', 'store', 'destroy'])->shallow();
Route::apiResource('postingan.media','API\PostinganMediaController')->only(['index','store', 'destroy'])->shallow();
Route::apiResource('postingan.komentar','API\PostinganKomentarController')->except(['show'])->shallow();

