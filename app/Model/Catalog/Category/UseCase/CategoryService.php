<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\UseCase;

use App\Entity\Catalog\Category;
use App\Entity\Catalog\Attribute;
use App\Entity\Catalog\Model\ModelItem;
use App\Model\Catalog\Category\Dto\Attribute\AttributesFilterDto;
use App\Model\Catalog\Category\Dto\Attribute\Filter;
use App\Model\Catalog\Entity\Category\Attribute\Attribute as AttributeItem;

class CategoryService
{
    public function attributeExists(Category $category, string $name): bool
    {
        return $category->attributes()->where('name', $name)->exists();
    }

    public function findAttribute(Category $category, string $name, $lang): ?Attribute
    {
        /** @var Attribute|null $attribute */
        $attribute = $category->attributes()->where('name', $name)->where('lang', $lang)->first();

        return $attribute;
    }

    public function createAttribute(Category $category, AttributeItem $attribute, $lang): Attribute
    {
        /** @var Attribute $item */
        $item = $category->attributes()->create([
            'name' => $attribute->getName()->getName(),
            'label' => $attribute->getName()->getLabel(),
            'label_ru' => $attribute->getName()->getLabelRu(),
            'type' => $attribute->getValue()->getType(),
            'required' => $attribute->getValue()->isRequired(),
            'variants' => $attribute->getValue()->getVariants(),
            'default' => $attribute->getValue()->getDefault(),
            'sort' => $attribute->getSort(),
            'filterable' => $attribute->isFilterable(),
            'lang' => $lang
        ]);

        return $item;
    }

    public function updateAttribute(Attribute $attribute, AttributeItem $attributeItem, $lang): void
    {
        /** @var Attribute $item */
        $attribute->update([
            'name' => $attributeItem->getName()->getName(),
            'label' => $attributeItem->getName()->getLabel(),
            'label_ru' => $attributeItem->getName()->getLabelRu(),
            'type' => $attributeItem->getValue()->getType(),
            'required' => $attributeItem->getValue()->isRequired(),
            'variants' => $attributeItem->getValue()->getVariants(),
            'default' => $attributeItem->getValue()->getDefault(),
            'sort' => $attributeItem->getSort(),
            'filterable' => $attributeItem->isFilterable(),
            'lang' => $lang
        ]);
    }

    public function getAttributes(Category $category, $lang = null)
    {
        $q = $category->attributes()->orderBy('sort', 'ASC');

        if($lang) {
            $q->where('lang', $lang);
        }

        return $q->get();
    }

    public function getFilters(Category $category, ModelItem $model): AttributesFilterDto
    {
        $attributes = $category->attributes()
            ->select(['catalog_attributes.id', 'catalog_attributes.name', 'catalog_attributes.label_ru', 'catalog_attributes.label', 'catalog_attributes.default', 'catalog_attributes.type', 'catalog_marks_values.value'])
            ->distinct('value')
            ->where('filterable', true)
            ->join('catalog_marks_values', 'catalog_marks_values.attribute_id', '=', 'catalog_attributes.id')
            ->whereIn('catalog_marks_values.mark_id', $model->marks()->select('id')->get()->pluck('id'))
            ->orderBy('catalog_marks_values.value', 'ASC')
            ->get();

        $groups = $attributes->groupBy('id');

        $filters = new AttributesFilterDto();

        foreach ($groups as $attributeId => $items) {
            foreach($items as $item) {
                if (!$filters->hasFilter($attributeId)) {
                    $filters->addFilter($filter = new Filter($attributeId, $item['label'], $item['type'], $item['default']));
                }
                $filter->addValue($item['value']);
            }
            $filters->addFilter($filter);
        }

        return $filters;
    }
}
