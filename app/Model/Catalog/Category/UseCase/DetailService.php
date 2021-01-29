<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\UseCase;

use App\Entity\Catalog\Model\Mark\Group;
use App\Model\Catalog\Category\Repository\DetailRepository;
use App\Entity\Catalog\Model\Mark\Detail;
use App\Model\Catalog\Entity\Detail\Detail as DetailItem;

class DetailService
{
    /**
     * @var DetailRepository
     */
    private DetailRepository $details;

    public function __construct(DetailRepository $details)
    {
        $this->details = $details;
    }

    public function create(Group $group, DetailItem $detail): Detail
    {
        /** @var Detail $item */
        $item = $group->details()->create([
            'name' => $detail->getName()->getName(),
            'name_ru' => $detail->getName()->getNameRu(),
            'name_en' => $detail->getName()->getNameEn(),
            'description' => $detail->getName()->getDescription(),
            'sku' => $detail->getName()->getCatNumber(),
            'price' => $detail->getPrice()->getValue(),
            'status' => $detail->getStatus()->getValue(),
            'use_count' => $detail->getQuantity()->getUseCount(),
            'quantity' => $detail->getQuantity()->getQuantity(),
            'weight' => $detail->getQuantity()->getWeight(),
            'visible' => $detail->isVisible()
        ]);

        return $item;
    }

    public function update(Detail $item, DetailItem $detail): Detail
    {
        /** @var Detail $item */
        $item->update([
            'name' => $detail->getName()->getName(),
            'name_ru' => $detail->getName()->getNameRu(),
            'name_en' => $detail->getName()->getNameEn(),
            'description' => $detail->getName()->getDescription(),
            'sku' => $detail->getName()->getCatNumber(),
            'price' => $detail->getPrice()->getValue(),
            'status' => $detail->getStatus()->getValue(),
            'use_count' => $detail->getQuantity()->getUseCount(),
            'quantity' => $detail->getQuantity()->getQuantity(),
            'weight' => $detail->getQuantity()->getWeight(),
            'visible' => $detail->isVisible(),
            'group_id' => $detail->getGroupId() ?? $item->group_id,
        ]);

        return $item;
    }
}
