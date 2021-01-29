<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Crumbs;
use App\Entity\Catalog\Region;
use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Model\ModelItem;
use App\Entity\Catalog\Model\Mark\Group;
use App\Entity\Catalog\Model\Mark;

Breadcrumbs::register('home', function (Crumbs $crumbs) {
    $crumbs->push(__('Catalogue'), route('home'));
});

// Auth
Breadcrumbs::register('login', function (Crumbs $crumbs) {
    $crumbs->push(__('Sign In'), route('login'));
});

// Cart
Breadcrumbs::register('cart', function (Crumbs $crumbs) {
    $crumbs->push(__('Cart'), route('cart'));
});

// Cart
Breadcrumbs::register('checkout', function (Crumbs $crumbs) {
    $crumbs->push(__('Checkout'), route('checkout'));
});

// Catalog
Breadcrumbs::register('catalog.category', function (Crumbs $crumbs, Category $category, ?string $region = null) {
    $crumbs->parent('home');
    $crumbs->push(translated_category_name($category), route('catalog.category', ['category' => $category]));
});

Breadcrumbs::register('catalog.brand', function (Crumbs $crumbs, Category $category, string $region, Brand $brand) {
    $crumbs->parent('catalog.category', $category, $region);

    $region = $category->regions->where('slug', $region)->first();

    if ($category->isWithEnabledRegions()) {
        $crumbs->push("{$brand->name} (".translated_region_name($region).")", route('catalog.brand', ['category' => $category, 'region' => $region, 'brand' => $brand]));
    } else {
        $crumbs->push($brand->name, route('catalog.brand', ['category' => $category, 'region' => $region, 'brand' => $brand]));
    }
});

Breadcrumbs::register('catalog.model', function (Crumbs $crumbs, Category $category, string $region, Brand $brand, ModelItem $model) {
    $crumbs->parent('catalog.brand', $category, $region, $brand);

    $crumbs->push(__('Accessories for'). " {$model->name}", route('catalog.model', ['category' => $category, 'region' => $region, 'brand' => $brand, 'model' => $model]));
});

Breadcrumbs::register('catalog.mark', function (Crumbs $crumbs, Category $category, string $region, Brand $brand, ModelItem $model, Mark $mark) {
    $crumbs->parent('catalog.model', $category, $region, $brand, $model);

    $crumbs->push($mark->name, route('catalog.mark', ['category' => $category, 'region' => $region, 'brand' => $brand, 'model' => $model, 'mark' => $mark]));
});

Breadcrumbs::register('catalog.group', function (Crumbs $crumbs, Category $category, string $region, Brand $brand, ModelItem $model, Mark $mark, Group $group) {
    $crumbs->parent('catalog.mark', $category, $region, $brand, $model, $mark);

    $crumbs->push(translated_group_name($group), route('catalog.group', ['category' => $category, 'region' => $region, 'brand' => $brand, 'model' => $model, 'mark' => $mark, 'group' => $group]));
});
