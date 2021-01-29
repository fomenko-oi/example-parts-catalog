<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale() . '/cabinet',
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
], function() {
    Route::get('/', 'PersonalController@index')->name('personal');
    Route::get('logout', 'PersonalController@logout')->name('logout');

    Route::get('orders', 'PersonalController@orders')->name('orders');
    Route::get('orders/{order}/pay', 'PersonalController@payOrder')->name('orders.pay');

    Route::get('payments', 'PersonalController@payments')->name('payments');
    Route::get('payments/{refill}/pay', 'PersonalController@payRefill')->name('payments.pay');

    Route::get('deposit', 'DepositController@deposit')->name('deposit');
    Route::get('deposit/{refill}', 'DepositController@bill')->name('deposit.bill');
});

Route::group(['prefix' => 'cabinet'], function() {
    Route::put('orders/{order}', 'PersonalController@updateOrder')->name('orders.update');

    Route::put('/', 'PersonalController@update')->name('personal.update');
    Route::post('deposit', 'DepositController@refill')->name('deposit.refill');
});
