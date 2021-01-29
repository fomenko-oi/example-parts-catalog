<?php

declare(strict_types=1);

namespace App\Model\Delivery\Command\Export;

use Webmozart\Assert\Assert;

class ExportPricesCommand
{
    private int $deliveryId;
    private int $regionId;

    public function __construct(int $deliveryId, int $regionId)
    {
        $this->deliveryId = $deliveryId;
        $this->regionId = $regionId;
    }

    /**
     * @return int
     */
    public function getDeliveryId(): int
    {
        return $this->deliveryId;
    }

    /**
     * @return int
     */
    public function getRegionId(): int
    {
        return $this->regionId;
    }
}
