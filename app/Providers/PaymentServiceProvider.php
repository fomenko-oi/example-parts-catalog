<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Srmklive\PayPal\Traits\PayPalHttpClient;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }
}
