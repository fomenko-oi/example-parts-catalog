<?php

declare(strict_types=1);

namespace App\Model\Delivery\Command\Import;

use App\Imports\Delivery\DeliveryPricesImport;
use App\Model\Order\Repository\DeliveryMethodRepository;
use Maatwebsite\Excel\Facades\Excel;

class ImportPricesHandler
{
    /**
     * @var DeliveryMethodRepository
     */
    private DeliveryMethodRepository $deliveryMethods;

    public function __construct(DeliveryMethodRepository $deliveryMethods)
    {
        $this->deliveryMethods = $deliveryMethods;
    }

    public function execute(ImportPricesCommand $command)
    {
        $delivery = $this->deliveryMethods->getById($command->getDeliveryId());

        $region = $this->deliveryMethods->getRegion($delivery, $command->getRegionId());

        $region->ranges()->delete();

        Excel::import(new DeliveryPricesImport($delivery, $region), $command->getPath());
    }
}
