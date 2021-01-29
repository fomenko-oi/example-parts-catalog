<?php

namespace App\Providers;

use App\Model\Cart\Service\Cart;
use App\Model\Cart\Service\Cost\Calculator\CalculatorInterface;
use App\Model\Cart\Service\Cost\Calculator\SimpleCost;
use App\Model\Cart\Service\Storage\HybridStorage;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use View;

class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //$this->app->bind(StorageInterface::class);

        $this->app->bind(CalculatorInterface::class, SimpleCost::class);

        $this->app->singleton(Cart::class, function (Application $app) {
            return new Cart(
                new HybridStorage('cart', 3600 * 24),
                new SimpleCost()
            );
        });

        View::share('cart', $cart = $this->app->get(Cart::class));
        //View::share('cartAmount', $cart->getAmount());
    }
}
