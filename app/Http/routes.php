<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'guest'], function () {

    Route::get('auth/github', 'AuthController@redirectToProvider');
    Route::get('auth/github/callback', 'AuthController@handleProviderCallback');

});


Route::group(['middleware' => 'auth'], function () {
    Route::get('auth/logout', 'AuthController@logout');

    Route::get('repos', 'ReposController@index');
    Route::post('repos', 'ReposController@select');

    Route::get('issues/{user}/{name}', 'ReposController@show');
    Route::get('milestones/{user}/{name}', 'ReposController@milestones');

    Route::post('issues/add', 'ReposController@add');

    Route::get('report', 'ReportsController@show');
    Route::delete('report', 'ReportsController@destroy');

});