<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Model\Delivery\Entity\Country\Country;
use App\Model\Delivery\Entity\Country\CountryRegion;
use App\Model\Delivery\Repository\CountriesRepository;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('country/{country}/regions', function(Country $country, CountriesRepository $countries) {
    return $countries->getRegions($country);
});

Route::get('country/{country}/{region}', function(Country $country, CountryRegion $region, CountriesRepository $countries) {
    return $countries->getRegionCities($region);
});
