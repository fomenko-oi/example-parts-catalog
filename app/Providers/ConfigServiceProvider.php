<?php

namespace App\Providers;

use App\Entity\Common\Config;
use App\UseCase\Common\ConfigManager;
use App\UseCase\Common\ConfigService;
use App\UseCase\Common\CurrencyManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if (DB::table((new Config())->getTable())->exists()) {
            // autoload all required configs
            ConfigManager::init(app(ConfigService::class)->common()->pluck('value', 'key')->toArray());
        }

        // Currency configuration
        CurrencyManager::init(
            ConfigManager::get('yen_rub_currency', 1.432),
            ConfigManager::get('yen_usd_currency', 107.60)
        );
    }
}
