<?php

use App\Model\Deposit\Entity\Refill\Event\RefillCompleted;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'paypal.'], function() {
    Route::post('payment/process', 'PaypalController@process')->name('process');
    Route::get('payment', 'PaypalController@payment')->name('payment');
    Route::get('cancel', 'PaypalController@cancel')->name('payment.cancel');
    Route::get('payment/success', 'PaypalController@success')->name('payment.success');
});

Route::post('cart', 'Api\CartController@add');
Route::put('cart', 'Api\CartController@update');
Route::delete('cart', 'Api\CartController@delete');

Route::post('order/delivery', 'Api\OrdersController@delivery');
Route::post('order', 'Api\OrdersController@order');
Route::post('request_order', 'Api\OrdersController@requestOrder');

Route::redirect('/home', 'cabinet')->name('home');

Route::get('catalog/detail/{detail}', 'SiteController@detailProxy')->name('catalog.detail');

Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){
    Route::view('password/reset/requested', 'app.auth.passwords.requested')->name('auth.password.requested');
    Auth::routes();

    Route::post('simple_search', 'SiteController@simpleSearch')->name('simple_search');

    Route::get('/', 'Catalog\\MainController@index')->name('home');
    Route::get('cart', 'SiteController@cart')->name('cart');
    Route::get('checkout', 'SiteController@checkout')->name('checkout');
    Route::get('set_locale/{locale}', 'SiteController@setLocale')->where('locale', 'en|ru')->name('set_locale');

    Route::get('search', 'SiteController@search')->name('search');

    Route::view('auth/password/status', 'app.auth.passwords.success')->name('auth.password.success');
    Route::view('auth/sign_up/status', 'app.auth.success')->name('auth.sign_up.success');

    Route::get('{category}/{region?}', 'Catalog\\MainController@category')->name('catalog.category');
    Route::get('{category}/{region}/{brand}', 'Catalog\\MainController@brand')->name('catalog.brand');
    Route::get('{category}/{region}/{brand}/{model}', 'Catalog\\MainController@model')->name('catalog.model');
    Route::get('{category}/{region}/{brand}/{model}/{mark}', 'Catalog\\MainController@mark')->name('catalog.mark');
    Route::get('{category}/{region}/{brand}/{model}/{mark}/{group}', 'Catalog\\MainController@group')->name('catalog.group');
});
