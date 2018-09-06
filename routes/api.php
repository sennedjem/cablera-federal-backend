<?php

use Illuminate\Http\Request;

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

Route::name('login')->post('login','LoginController@login');
Route::apiResource('users', 'UsersController');
Route::middleware('auth:api')->group(function() {
    Route::name('logout')->get('logout', 'LoginController@logout');
	Route::apiResource('sites', 'SitesController');
});




	