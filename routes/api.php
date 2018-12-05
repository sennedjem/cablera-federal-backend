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
Route::get('escreate','ElasticSearchController@create');
Route::name('login')->post('login','LoginController@login');
Route::post('users','UsersController@store');
    Route::get('favourite-posts-extended/{userId}','PostsController@getFavouritesPosts');
Route::middleware('auth:api')->group(function() {
    Route::get('favs-posts/{userId}','UsersFavsPostsController@index');
    Route::post('favs-posts','UsersFavsPostsController@store');
    Route::delete('favs-posts/{userId}','UsersFavsPostsController@destroy');
    Route::name('logout')->get('logout', 'LoginController@logout');
    //Route::apiResource('users', 'UsersController');
    Route::get('posts','PostsController@index');
    Route::get('posts/{id}','PostsController@show');
    Route::put('posts/{id}','PostsController@update');
    Route::get('sites/types','SitesController@getTypes');
    Route::apiResource('sites', 'SitesController');
	Route::apiResource('media', 'MediaController');

});




	