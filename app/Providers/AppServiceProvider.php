<?php

namespace App\Providers;

use App\Model\Auth\Service\PasswordGenerator;
use App\Model\Auth\Service\SimplePasswordGenerator;
use App\Model\Delivery\Entity\Delivery\DeliveryMethod;
use App\Model\Delivery\Entity\Delivery\Range;
use App\Model\Delivery\Repository\CountryRegionRepository;
use App\Model\Order\Repository\DeliveryMethodRepository;
use App\Service\Catalog\Detali\Price\HierarchicPriceModificator;
use App\Service\Catalog\Detali\Price\NoActionPriceModificator;
use App\Service\Catalog\Detali\Price\PriceModificator;
use App\Service\Catalog\Watermark\DummyWaterMarker;
use App\Service\Catalog\Watermark\GDWaterMarker;
use App\Service\Catalog\Watermark\Watermark;
use App\UseCase\Common\ConfigManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use View;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->app->singleton(QueryEncoder::class, fn() => new SimpleEncoder());
        $this->app->singleton(PasswordGenerator::class, fn() => new SimplePasswordGenerator(6));
        $this->app->singleton(PriceModificator::class, function() {
            //return new NoActionPriceModificator();
            return new HierarchicPriceModificator(ConfigManager::get('catalog_discount_koeficient', 0));
        });

        View::composer('app.catalog._segments._calculator', function(\Illuminate\View\View $view) {
            $countries = app(CountryRegionRepository::class);

            $deliveries = $countries->getDeliveriesWithCountries();

            $view->with('countries', $countries->all());
        });

        View::composer('layout.app', function(\Illuminate\View\View $view) {
            $deliveryMethods = app(DeliveryMethodRepository::class);

            $deliveryData = [];
            $jpData = [];

            /** @var DeliveryMethod $method */
            foreach ($deliveryMethods->allWith(['regions.ranges', 'regions.countries']) as $method) {
                if ($method->key === 'jp') {
                    $jpData = $method;
                    continue;
                }

                foreach ($method->regions as $region) {
                    $deliveryData[$method->key][Str::slug($region->name)] = [
                        'countries' => $region->countries->pluck('name')->toArray(),
                        'scale' => $region->ranges->filter(fn(Range $range) => $range->isByWeight())->map(function(Range $range) {
                            return ['weight' => $range->to / 1000, 'price' => $range->price];
                        })->toArray(),
                    ];
                }
            }

            $view->with('deliveryData', $deliveryData);
            $view->with('jpDeliveryData', $deliveryData);
        });
    }
}
