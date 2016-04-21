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

Route::get('/', 'Frontend\HomeController@index');
Route::get('/detail', 'Frontend\HomeController@detalle');


Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function(){

    Route::get('/', [
        'uses' => 'HomeController@index',
        'as'   => 'admin'
    ]);

    Route::resource('logos', 'LogoController');
    Route::resource('customers', 'CustomerController');
    Route::resource('categories', 'CategoryController');

});


// Authentication routes...
Route::get('login', [
    'uses'  => 'Auth\AuthController@getLogin',
    'as'    => 'login'
]);
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', [
    'uses'  => 'Auth\AuthController@getLogout',
    'as'    => 'logout'
]);

Route::auth();


