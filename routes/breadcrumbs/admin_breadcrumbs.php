<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Crumbs;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Region;
use App\Entity\Catalog\Brand;
use App\Entity\Catalog\Model\ModelItem;
use App\Entity\Catalog\Model\Mark\Group;
use App\Entity\Catalog\Model\Mark;
use App\Entity\Catalog\Model\Mark\Detail;
use App\Entity\Common\Config;
use App\Model\Delivery\Entity\Delivery\DeliveryMethod;
use App\Model\Delivery\Entity\Country\Country;
use App\Model\Delivery\Entity\Region\Region as DeliveryRegion;
use App\Model\Delivery\Entity\Country\CountryRegion;
use App\Model\Delivery\Entity\Country\City;
use App\Model\Deposit\Entity\Refill\Refill;
use App\Model\Order\Entity\Order;
use App\Model\Auth\Entity\User;
use App\Entity\Catalog\Attribute;
use App\Model\Order\Entity\Request\RequestDetail;

Breadcrumbs::register('admin', function (Crumbs $crumbs) {
    $crumbs->push('Dashboard', route('admin.catalog'));
});

// Catalog
Breadcrumbs::register('admin.catalog.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin');
    $crumbs->push('Catalog', route('admin.catalog.index'));
});

// Categories
Breadcrumbs::register('admin.catalog.category', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('admin.catalog.index');
    $crumbs->push($category->name, route('admin.catalog.category', ['category' => $category]));
});
Breadcrumbs::register('admin.catalog.category.edit', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('admin.catalog.category', $category);
    $crumbs->push('Editing', route('admin.catalog.category.edit', ['category' => $category]));
});
Breadcrumbs::register('admin.catalog.category.create', function (Crumbs $crumbs) {
    $crumbs->parent('admin.catalog.index');
    $crumbs->push('New category', route('admin.catalog.category.create'));
});

Breadcrumbs::register('admin.catalog.category.attribute.create', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('admin.catalog.category', $category);
    $crumbs->push('New Attribute', route('admin.catalog.category.attribute.create', ['category' => $category]));
});
Breadcrumbs::register('admin.catalog.category.attribute.edit', function (Crumbs $crumbs, Category $category, Attribute $attribute) {
    $crumbs->parent('admin.catalog.category', $category);
    $crumbs->push("Updating {$attribute->name}");
});

Breadcrumbs::register('admin.catalog.region', function (Crumbs $crumbs, Category $category, Region $region) {
    $crumbs->parent('admin.catalog.category', $category);
    $crumbs->push($region->name, admin_region_path($category, $region));
});
Breadcrumbs::register('admin.catalog.region.create', function (Crumbs $crumbs, Category $category) {
    $crumbs->parent('admin.catalog.category', $category);
    $crumbs->push('New Region');
});
Breadcrumbs::register('admin.catalog.region.edit', function (Crumbs $crumbs, Category $category, Region $region) {
    $crumbs->parent('admin.catalog.category', $category);
    $crumbs->push($region->name);
});

// Brands
Breadcrumbs::register('admin.catalog.brand', function (Crumbs $crumbs, Category $category, Region $region, Brand $brand) {
    $crumbs->parent('admin.catalog.region', $category, $region);
    $crumbs->push($brand->name, admin_brand_path($category, $region, $brand));
});

Breadcrumbs::register('admin.catalog.brand.create', function (Crumbs $crumbs, Category $category, Region $region) {
    $crumbs->parent('admin.catalog.region', $category, $region);
    $crumbs->push('New brand', admin_region_path($category, $region));
});

Breadcrumbs::register('admin.catalog.brand.edit', function (Crumbs $crumbs, Category $category, Region $region, Brand $brand) {
    $crumbs->parent('admin.catalog.region', $category, $region);
    $crumbs->push($brand->name, admin_edit_brand_path($category, $region, $brand));
});

// Details
Breadcrumbs::register('admin.catalog.details.create', function (Crumbs $crumbs, Category $category, Region $region, Brand $brand, ModelItem $model, Mark $mark, Group $group) {
    $crumbs->parent('admin.catalog.group', $category, $region, $brand, $model, $mark, $group);
    $crumbs->push('New detail', admin_group_path($category, $region, $brand, $model, $mark, $group));
});

Breadcrumbs::register('admin.catalog.details.edit', function (Crumbs $crumbs, Category $category, Region $region, Brand $brand, ModelItem $model, Mark $mark, Group $group, Detail $detail) {
    $crumbs->parent('admin.catalog.group', $category, $region, $brand, $model, $mark, $group);
    $crumbs->push('Editing ' . $detail->name, admin_group_path($category, $region, $brand, $model, $mark, $group));
});

// Configs
Breadcrumbs::register('admin.configs.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin');
    $crumbs->push('Configs', route('admin.configs.index'));
});

Breadcrumbs::register('admin.configs.edit', function (Crumbs $crumbs, Config $config) {
    $crumbs->parent('admin.configs.index');
    $crumbs->push($config->name);
});

Breadcrumbs::register('admin.configs.create', function (Crumbs $crumbs) {
    $crumbs->parent('admin.configs.index');
    $crumbs->push('New Param');
});

// users
Breadcrumbs::register('admin.users.users.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin');
    $crumbs->push('Users', route('admin.users.users.index'));
});
Breadcrumbs::register('admin.users.users.show', function (Crumbs $crumbs, User $user) {
    $crumbs->parent('admin.users.users.index');
    $crumbs->push("#{$user->id}", route('admin.users.users.show', $user));
});
Breadcrumbs::register('admin.users.users.change_password', function (Crumbs $crumbs, User $user) {
    $crumbs->parent('admin.users.users.show', $user);
    $crumbs->push('Password changing', route('admin.users.users.change_password', $user));
});
