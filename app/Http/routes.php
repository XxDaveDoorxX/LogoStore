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

Route::group(['namespace' => 'Frontend'], function() {
    Route::get('home', [
        'uses' => 'HomeController@index',
        'as' => 'index'
    ]);

    Route::get('/', function() {
        return redirect('home');
    });

    Route::get('detail/{id}', [
        'uses' => 'HomeController@detail',
        'as' => 'detail'
    ]);

    // Register
    Route::get('purchase/register', [
        'uses' => 'HomeController@register_customer',
        'as' => 'register'
    ]);
    Route::post('purchase/postRegister', [
        'uses' => 'HomeController@register_customer_preStore',
        'as' => 'register.preStore'
    ]);

    // Requirements
    Route::get('purchase/requirement', [
        'uses' => 'HomeController@requirement_logo',
        'as' => 'requirement'
    ]);
    Route::post('purchase/postRequirement', [
        'uses' => 'HomeController@requirement_logo_preStore',
        'as' => 'requirement.preStore'
    ]);

    // Additional Requirements
    Route::get('purchase/additional', [
        'uses' => 'HomeController@additional_requirements',
        'as'   => 'additional'
    ]);
    Route::post('purchase/postAdditional', [
        'uses' => 'HomeController@additional_requirements_preStore',
        'as'   => 'additional.preStore'
    ]);

    Route::get('purchase/summary', [
        'uses' => 'HomeController@summary',
        'as' => 'summary'
    ]);

    Route::post('contact/form', [
        'uses' => 'HomeController@messageContact',
        'as' => 'contact.message'
    ]);

});

Route::get('payment', [
    'uses' => 'Frontend\PaypalController@postPayment',
    'as' => 'payment'
]);

// Después de realizar el pago Paypal redirecciona a esta ruta
Route::get('payment/status', [
    'uses' => 'Frontend\PaypalController@getPaymentStatus',
    'as' => 'payment.status'
]);

Route::get('payment/success', [
    'uses' => 'Frontend\HomeController@paymentMessages',
    'as'   => 'payment.messages'
]);


Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function() {

    Route::get('/', [
        'uses' => 'HomeController@index',
        'as'   => 'admin'
    ]);

    Route::resource('logos', 'LogoController');
    Route::group(['as' => 'logos.', 'prefix' => 'logos'], function() {
        Route::get('{logo_id}/images', [
            'uses' => 'LogoController@editImages',
            'as'   => 'images'
        ]);
        Route::post('{logo_id}/images/list', [
            'uses' => 'ImagesLogoController@listByLogo',
            'as'   => 'images.list'
        ]);
        Route::post('{logo_id}/images/create', [
            'uses' => 'ImagesLogoController@storeByLogo',
            'as'   => 'images.create'
        ]);
        Route::post('images/{id}/update', [
            'uses' => 'ImagesLogoController@update',
            'as'   => 'images.update'
        ]);
        Route::post('images/{id}/destroy', [
            'uses' => 'ImagesLogoController@destroy',
            'as'   => 'images.destroy'
        ]);
    });

    Route::resource('customers', 'CustomerController');
    Route::resource('categories', 'CategoryController');
    Route::resource('keywords', 'KeywordController');

    Route::resource('orders', 'OrderController');

    Route::resource('additional', 'AdditionalRequirementsLogoPriceController');

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


