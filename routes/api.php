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

Route::get('es','ElasticSearchController@index');
Route::name('login')->post('login','LoginController@login');
Route::post('users','UsersController@store');
Route::middleware('auth:api')->group(function() {
    Route::name('logout')->get('logout', 'LoginController@logout');
    //Route::apiResource('users', 'UsersController');
    Route::get('posts','PostsController@index');
    Route::get('posts/{id}','PostsController@show');
    Route::put('posts/{id}','PostsController@update');
    Route::get('sites/types','SitesController@getTypes');
    Route::apiResource('sites', 'SitesController');
});




	