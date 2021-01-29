<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\UseCase;

use App\Entity\Catalog\Attribute;
use App\Entity\Catalog\Category;
use App\Entity\Catalog\Model\ModelItem;
use App\Model\Catalog\Category\Dto\Attribute\AttributesFilterDto;
use App\Model\Catalog\Category\Dto\Attribute\Filter;

class AttributesService
{
    public function getFilters(Category $category, array $names): AttributesFilterDto
    {
        $attributes = $category->attributes()
            ->select(['catalog_attributes.id', 'catalog_attributes.name', 'catalog_attributes.label', 'catalog_attributes.default', 'catalog_attributes.type', 'catalog_marks_values.value'])
            ->distinct('value')
            ->whereIn('catalog_attributes.name', $names)
            ->join('catalog_marks_values', 'catalog_marks_values.attribute_id', '=', 'catalog_attributes.id')
            ->orderBy('catalog_marks_values.value', 'ASC')
            ->get();

        $groups = $attributes->groupBy('id');

        $filters = new AttributesFilterDto();

        foreach ($groups as $attributeId => $items) {
            foreach($items as $item) {
                if (!$filters->hasFilter($attributeId)) {
                    $filters->addFilter($filter = new Filter($attributeId, $item['label'], $item['type'], $item['default']));
                }
                $filter->addValue(intval($item['value']));
            }
            $filters->addFilter($filter);
        }

        return $filters;
    }
}
