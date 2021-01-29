<?php

Route::get('/', function() {
    return view('admin.dashboard');
})->name('catalog');

// Catalog
Route::group(['as' => 'catalog.', 'prefix' => 'catalog', 'namespace' => 'Catalog'], function() {
    Route::get('/', 'CategoriesController@index')->name('index');
    Route::post('koefficient', 'CategoriesController@koefficient')->name('koefficient');
    Route::post('/', 'CategoriesController@store')->name('category.store');
    Route::get('create', 'CategoriesController@create')->name('category.create');

    Route::group(['as' => 'category', 'prefix' => 'category'], function() {
        Route::get('{category:id}', 'CategoriesController@show');
        Route::get('{category:id}/edit', 'CategoriesController@edit')->name('.edit');
        Route::put('{category:id}', 'CategoriesController@update')->name('.update');
        Route::delete('{category:id}', 'CategoriesController@remove')->name('.remove');
        Route::post('{category:id}/koefficient', 'CategoriesController@categoryKoefficient')->name('.koefficient');

        Route::group(['as' => '.attribute.'], function() {
            Route::get('{category:id}/attribute', 'AttributesController@create')->name('create');
            Route::get('{category:id}/attribute/{attribute}', 'AttributesController@edit')->name('edit');
            Route::put('{category:id}/attribute/{attribute}', 'AttributesController@update')->name('update');
            Route::post('{category:id}/attribute', 'AttributesController@store')->name('store');
            Route::delete('{category:id}/attribute/{attribute}', 'AttributesController@destroy')->name('destroy');
        });
    });

    Route::get('category/{category:id}/create', 'RegionsController@create')->name('region.create');
    Route::post('category/{category:id}', 'RegionsController@store')->name('region.store');
    Route::delete('category/{category:id}/{region:id}/', 'RegionsController@remove')->name('region.remove');
    Route::put('category/{category:id}/{region:id}/', 'RegionsController@update')->name('region.update');
    Route::get('category/{category:id}/{region:id}/edit', 'RegionsController@edit')->name('region.edit');
    Route::get('category/{category:id}/{region:id}', 'RegionsController@show')->name('region');

    Route::get('category/{category:id}/{region:id}/create', 'BrandsController@create')->name('brand.create');
    Route::post('category/{category:id}/{region:id}', 'BrandsController@store')->name('brand.store');
    Route::post('category/{category:id}/{region:id}/{brand:id}/koefficient', 'BrandsController@koefficient')->name('brand.koefficient');
    Route::delete('category/{category:id}/{region:id}/{brand:id}', 'BrandsController@remove')->name('brand.remove');
    Route::get('category/{category:id}/{region:id}/{brand:id}/edit', 'BrandsController@edit')->name('brand.edit');
    Route::put('category/{category:id}/{region:id}/{brand:id}/update', 'BrandsController@update')->name('brand.update');
    Route::get('category/{category:id}/{region:id}/{brand:id}', 'BrandsController@show')->name('brand');

    Route::group(['as' => 'model', 'prefix' => 'category'], function() {
        Route::get('{category:id}/{region:id}/{brand:id}/create', 'ModelsController@create')->name('.create');
        Route::post('{category:id}/{region:id}/{brand:id}', 'ModelsController@store')->name('.store');
        Route::post('{category:id}/{region:id}/{brand:id}/{model:id}/koefficient', 'ModelsController@koefficient')->name('.koefficient');
        Route::get('{category:id}/{region:id}/{brand:id}/{model:id}/edit', 'ModelsController@edit')->name('.edit');
        Route::get('{category:id}/{region:id}/{brand:id}/{model:id}', 'ModelsController@show');
        Route::put('{category:id}/{region:id}/{brand:id}/{model:id}', 'ModelsController@update')->name('.update');
        Route::delete('{category:id}/{region:id}/{brand:id}/{model:id}', 'ModelsController@remove')->name('.remove');
    });

    Route::group(['as' => 'mark', 'prefix' => 'category'], function() {
        Route::post('{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/export', 'MarksController@export')->name('.export');
        Route::post('{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/import', 'MarksController@import')->name('.import');
        Route::get('{category:id}/{region:id}/{brand:id}/{model:id}/create', 'MarksController@create')->name('.create');
        Route::post('{category:id}/{region:id}/{brand:id}/{model:id}', 'MarksController@store')->name('.store');
        Route::post('{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/koefficient', 'MarksController@koefficient')->name('.koefficient');
        Route::delete('{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}', 'MarksController@remove')->name('.remove');
        Route::get('{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/edit', 'MarksController@edit')->name('.edit');
        Route::put('{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/edit', 'MarksController@update');
        Route::get('{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}', 'MarksController@show');
    });

    Route::get('category/{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/create', 'GroupsController@create')->name('group.create');
    Route::post('category/{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}', 'GroupsController@store')->name('group.store');
    Route::delete('category/{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/{group:id}', 'GroupsController@remove')->name('group.remove');
    Route::get('category/{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/{group:id}/edit', 'GroupsController@edit')->name('group.edit');
    Route::put('category/{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/{group:id}', 'GroupsController@update')->name('group.update');
    Route::get('category/{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/{group:id}', 'GroupsController@show')->name('group');

    Route::get('category/{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/{group:id}/create', 'DetailsController@create')->name('details.create');
    Route::post('category/{category:id}/{region:id}/{brand:id}/{model:id}/{mark:id}/{group:id}', 'DetailsController@store')->name('details.store');
    Route::delete('detail/{detail}', 'DetailsController@remove')->name('details.remove');
    Route::get('detail/{detail}', 'DetailsController@edit')->name('details.edit');
    Route::put('detail/{detail}', 'DetailsController@update')->name('details.update');
});

Route::group(['as' => 'configs.', 'prefix' => 'configs', 'namespace' => 'Common'], function() {
    Route::get('/', 'ConfigsController@index')->name('index');
    Route::get('create', 'ConfigsController@create')->name('create');
    Route::post('store', 'ConfigsController@store')->name('store');
    Route::get('{config}/edit', 'ConfigsController@edit')->name('edit');
    Route::put('{config}', 'ConfigsController@update')->name('updated');
    Route::delete('{config}', 'ConfigsController@remove')->name('remove');
});

Route::resource('countries', 'Delivery\\CountriesController');
Route::group(['as' => 'countries.', 'name' => 'countries.', 'prefix' => 'countries/{country}'], function() {
    Route::post('/', 'Delivery\\CountriesController@storeRegion')->name('regions.store');
    Route::get('create', 'Delivery\\CountriesController@createRegion')->name('regions.create');
    Route::get('{region}/edit', 'Delivery\\CountriesController@editRegion')->name('regions.edit');
    Route::get('{region}', 'Delivery\\CountriesController@showRegions')->name('regions.show');
    Route::delete('{region}', 'Delivery\\CountriesController@removeRegion')->name('regions.destroy');

    Route::get('{region}/cities/create', 'Delivery\\RegionCitiesController@create')->name('regions.cities.create');
    Route::post('{region}/cities', 'Delivery\\RegionCitiesController@store')->name('regions.cities.store');
    Route::delete('{region}/cities/{city}', 'Delivery\\RegionCitiesController@remove')->name('regions.cities.remove');
    Route::get('{region}/cities/{city}/edit', 'Delivery\\RegionCitiesController@edit')->name('regions.cities.edit');
    Route::put('{region}/cities/{city}', 'Delivery\\RegionCitiesController@update')->name('regions.cities.update');
});

Route::resource('delivery_methods', 'Order\\DeliveryMethodsController');
Route::group(['as' => 'delivery_methods.', 'name' => 'delivery_methods.', 'prefix' => 'delivery_methods/{delivery_method}'], function() {
    Route::get('{region}', 'Delivery\\RegionsController@show')->name('regions.show');
    Route::post('{region}/export', 'Delivery\\RegionsController@export')->name('regions.prices.export');
    Route::post('{region}/import', 'Delivery\\RegionsController@import')->name('regions.prices.import');
    Route::put('{region}/ranges', 'Delivery\\RegionsController@ranges')->name('regions.ranges');
    Route::resource('regions', 'Delivery\\RegionsController')->except('show');
    Route::delete('{region}/{country}', 'Delivery\\RegionsController@removeCountry')->name('regions.ranges.remove');
});

Route::group(['as' => 'users.', 'prefix' => 'users', 'namespace' => 'Users'], function() {
    // payments
    Route::get('payments', 'PaymentsController@index')->name('payments');
    Route::get('payments/{payment}', 'PaymentsController@show')->name('payments.show');
    Route::get('payments/{payment}/print', 'PaymentsController@print')->name('payments.print');
    Route::put('payments/{payment}/accept', 'PaymentsController@accept')->name('payments.accept');
    Route::get('payments/{payment}/reject', 'PaymentsController@rejectForm')->name('payments.reject');
    Route::put('payments/{payment}/reject', 'PaymentsController@reject');

    // orders
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
    Route::get('orders/{order}/edit', 'OrdersController@edit')->name('orders.edit');
    Route::put('orders/{order}', 'OrdersController@update')->name('orders.update');
    Route::post('orders/{order}/complete', 'OrdersController@complete')->name('orders.complete');
    Route::post('orders/{order}/payment_confirm', 'OrdersController@confirmPayment')->name('orders.confirm_payment');
    Route::get('orders/{order}/reject', 'OrdersController@rejectForm')->name('orders.reject_order');
    Route::post('orders/{order}/reject', 'OrdersController@reject');
    Route::delete('orders/{order}', 'OrdersController@remove')->name('orders.remove');

    // request orders
    Route::get('request_orders', 'RequestOrdersController@index')->name('request_orders.index');
    Route::get('request_orders/{order}', 'RequestOrdersController@show')->name('request_orders.show');
    Route::get('request_orders/{order}/edit', 'RequestOrdersController@edit')->name('request_orders.edit');
    Route::get('request_orders/{order}/complete', 'RequestOrdersController@complete')->name('request_orders.complete');
    Route::post('request_orders/{order}/complete', 'RequestOrdersController@completeProcess');
    Route::put('request_orders/{order}', 'RequestOrdersController@update')->name('request_orders.update');
    Route::delete('request_orders/{order}', 'RequestOrdersController@remove')->name('request_orders.remove');

    Route::get('details/{detail}', function(\App\Entity\Catalog\Model\Mark\Detail $detail) {
        return redirect()->route('admin.catalog.details.edit', $detail);
    });

    // users
    Route::resource('users', 'UsersController');
    Route::get('users/{user}/change_password', 'UsersController@changePassword')->name('users.change_password');
    Route::put('users/{user}/change_password', 'UsersController@updatePassword');
});
