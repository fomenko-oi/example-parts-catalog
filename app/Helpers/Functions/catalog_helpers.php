<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Region;
use App\Entity\Catalog\Attribute;
use App\Entity\Catalog\Model\Mark\Group;
use App\Entity\Catalog\Model\Mark\Detail;
use App\Model\Delivery\Entity\Country\Country;

if (!function_exists('translated_simple_name')) {
    function translated_simple_name($entity, $loc, $firstField = 'name', $secondField = 'name_ru')
    {
        if(!$loc) {
            $loc = LaravelLocalization::getCurrentLocale();
        }

        return $loc === 'ru' && !empty($entity->{$secondField}) ? $entity->{$secondField} : $entity->{$firstField};
    }
}

if (!function_exists('translated_category_name')) {
    function translated_category_name(Category $category, $loc = null)
    {
        if(!$loc) {
            $loc = LaravelLocalization::getCurrentLocale();
        }

        return translated_simple_name($category, $loc);
    }
}

if (!function_exists('translated_region_name')) {
    function translated_region_name(Region $region, $loc = null)
    {
        if(!$loc) {
            $loc = LaravelLocalization::getCurrentLocale();
        }

        return translated_simple_name($region, $loc);
    }
}

if (!function_exists('translated_attribute_name')) {
    function translated_attribute_name(Attribute $attribute, $loc = null)
    {
        if(!$loc) {
            $loc = LaravelLocalization::getCurrentLocale();
        }

        return translated_simple_name($attribute, $loc, 'label', 'label_ru');
    }
}

if (!function_exists('translated_group_name')) {
    function translated_group_name(Group $group, $loc = null)
    {
        if(!$loc) {
            $loc = LaravelLocalization::getCurrentLocale();
        }

        return translated_simple_name($group, $loc);
    }
}

if (!function_exists('translated_detail_name')) {
    function translated_detail_name(Detail $detail, $loc = null)
    {
        if(!$loc) {
            $loc = LaravelLocalization::getCurrentLocale();
        }

        $val = translated_simple_name($detail, $loc, 'name_en', 'name_ru');

        return $val ? $val : $detail->name;
    }
}

if (!function_exists('translated_country_name')) {
    function translated_country_name(Country $country, $loc = null)
    {
        if(!$loc) {
            $loc = LaravelLocalization::getCurrentLocale();
        }

        $val = translated_simple_name($country, $loc, 'name', 'name_ru');

        return $val ? $val : $country->name;
    }
}
