<?php

use App\Entity\Catalog\Region;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Model\ModelItem;
use App\Entity\Catalog\Model\Mark;
use App\Entity\Catalog\Model\Mark\Group;
use App\Entity\Catalog\Model\Mark\Detail;
use App\Service\Catalog\Detali\Price\PriceModificator;

if (!function_exists('admin_region_path')) {
    function admin_region_path(Category $category, Region $region)
    {
        return route('admin.catalog.region', ['category' => $category, 'region' => $region]);
    }
}

if (!function_exists('admin_brand_path'))
{
    function admin_brand_path(Category $category, Region $region, Brand $brand)
    {
        return route('admin.catalog.brand', ['category' => $category, 'region' => $region, 'brand' => $brand]);
    }
}

if (!function_exists('admin_remove_brand_path')) {
    function admin_remove_brand_path(Category $category, Region $region, Brand $brand)
    {
        return route('admin.catalog.brand.remove', ['category' => $category, 'region' => $region, 'brand' => $brand]);
    }
}

if (!function_exists('admin_edit_brand_path')) {
    function admin_edit_brand_path(Category $category, Region $region, Brand $brand)
    {
        return route('admin.catalog.brand.edit', ['category' => $category, 'region' => $region, 'brand' => $brand]);
    }
}

if (!function_exists('admin_create_mark_path'))
{
    function admin_create_mark_path(Category $category, Region $region, Brand $brand, ModelItem $model)
    {
        return route('admin.catalog.mark.create', ['category' => $category, 'region' => $region, 'brand' => $brand, 'model' => $model]);
    }
}

if (!function_exists('admin_store_mark_path'))
{
    function admin_store_mark_path(Category $category, Region $region, Brand $brand, ModelItem $model)
    {
        return route('admin.catalog.mark.store', ['category' => $category, 'region' => $region, 'brand' => $brand, 'model' => $model]);
    }
}

if (!function_exists('admin_model_path'))
{
    function admin_model_path(Category $category, Region $region, Brand $brand, ModelItem $model) {
        return route('admin.catalog.model', ['category' => $category, 'region' => $region, 'brand' => $brand, 'model' => $model]);
    }
}

if (!function_exists('admin_remove_mark_path')) {
    function admin_remove_mark_path(Category $category, Region $region, Brand $brand, ModelItem $model, Mark $mark)
    {
        return route('admin.catalog.mark.remove',
            ['category' => $category, 'region' => $region, 'brand' => $brand, 'model' => $model, 'mark' => $mark]);
    }
}

if (!function_exists('price_coefficient_converter')) {
    function price_coefficient_converter(Detail $detail)
    {
        return ceil(app(PriceModificator::class)->modify($detail));
    }
}

if (!function_exists('config_variable')) {
    function config_variable($key, $default = null)
    {
        return \App\UseCase\Common\ConfigManager::get($key, $default);
    }
}

if (!function_exists('toYen')) {
    function toYen($value)
    {
        return floor(\App\UseCase\Common\CurrencyManager::toYen($value));
    }
}

if (!function_exists('toDollarYen')) {
    function toDollarYen($value)
    {
        return number_format(\App\UseCase\Common\CurrencyManager::toDollarYen($value), 2, '.', '');
    }
}

if (!function_exists('toDollarYenDirect')) {
    function toDollarYenDirect($value)
    {
        return ceil(\App\UseCase\Common\CurrencyManager::toDollarYenDirect($value));
    }
}

if (!function_exists('toRub')) {
    function toRub($value)
    {
        return ceil(\App\UseCase\Common\CurrencyManager::toRub($value));
    }
}

if (!function_exists('getDirectRate')) {
    function getDirectRate()
    {
        return \App\UseCase\Common\CurrencyManager::getRate();
    }
}

if (!function_exists('getOppositeRate')) {
    function getOppositeRate()
    {
        return \App\UseCase\Common\CurrencyManager::getOppositeRate();
    }
}

if (!function_exists('getOppositeUsdRate')) {
    function getOppositeUsdRate()
    {
        return \App\UseCase\Common\CurrencyManager::getOppositeDollarRate();
    }
}

if (!function_exists('image_to_base64')) {
    function image_to_base64($path = null)
    {
        $storage = \Illuminate\Support\Facades\Storage::disk('public');

        if (!$path || !$storage->exists($path)) {
            $data = file_get_contents(public_path('img/default_avatar.png'));
        } else {
            $data = $storage->get($path);
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
