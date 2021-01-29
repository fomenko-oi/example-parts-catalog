<?php

namespace App\Providers;

use App\Service\Catalog\Watermark\DummyWaterMarker;
use App\Service\Catalog\Watermark\GDWaterMarker;
use App\Service\Catalog\Watermark\TextWaterMarker;
use App\Service\Catalog\Watermark\Watermark;
use Illuminate\Support\ServiceProvider;

class WatermarkServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->singleton(Watermark::class, function() {
            $config = config('watermark');

            if ($config['enabled'] === false) {
                return new DummyWaterMarker();
            }

            $driver = $config['driver'];
            if (!isset($config['drivers'][$driver])) {
                throw new \DomainException('Unable to handle watermark driver ' . $driver);
            }
            $params = $config['drivers'][$driver];

            switch ($driver) {
                case 'text':
                    return new TextWaterMarker(
                        $params['value'],
                        $params['size'],
                        $params['x'],
                        $params['y'],
                    );
                break;

                case 'gd_laravel':
                    $position = $params['position'];

                    $waterMarker = new GDWaterMarker($params['watermark'], $params['width'], $params['height']);
                    $waterMarker->setPosition($position['x'], $position['y'], $position['position']);

                    return $waterMarker;
                    break;
            }

            throw new \DomainException('Unable to init watermark driver ' . $driver);
        });
    }
}
