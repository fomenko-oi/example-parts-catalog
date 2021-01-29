<?php

namespace App\Imports\Delivery;

use App\Model\Delivery\Entity\Delivery\DeliveryMethod;
use App\Model\Delivery\Entity\Delivery\Range;
use App\Model\Delivery\Entity\Region\Region;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class DeliveryPricesImport implements WithHeadingRow, OnEachRow
{
    /**
     * @var DeliveryMethod
     */
    private DeliveryMethod $deliveryMethod;
    /**
     * @var Region
     */
    private Region $region;

    public function __construct(DeliveryMethod $deliveryMethod, Region $region)
    {
        $this->deliveryMethod = $deliveryMethod;
        $this->region = $region;
    }

    public function onRow(Row $row)
    {
        $item = $row->toArray();

        $from = $item['from_kg'] * 1000;
        $to = $item['to_kg'] * 1000;
        $price = $item['price_yen'];

        $range = $this->region->ranges()
            ->where('from', (int)$from)
            ->where('to', (int)$to)
            ->where('type', Range::TYPE_WEIGHT)
            ->first();

        if ($range) {
            return $range->update(['price' => $price]);
        }

        $this->region->ranges()->create([
            'from'  => $from,
            'to'    => $to,
            'type'  => Range::TYPE_WEIGHT,
            'price' => $price,
        ]);
        return true;
    }
}
