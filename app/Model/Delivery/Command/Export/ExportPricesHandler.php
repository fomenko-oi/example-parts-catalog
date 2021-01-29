<?php

declare(strict_types=1);

namespace App\Model\Delivery\Command\Export;

use App\Exports\Delivery\PricesExport;
use App\Model\Order\Repository\DeliveryMethodRepository;
use Maatwebsite\Excel\Facades\Excel;

class ExportPricesHandler
{
    /**
     * @var DeliveryMethodRepository
     */
    private DeliveryMethodRepository $deliveryMethods;

    public function __construct(DeliveryMethodRepository $deliveryMethods)
    {
        $this->deliveryMethods = $deliveryMethods;
    }

    public function execute(ExportPricesCommand $command)
    {
        $delivery = $this->deliveryMethods->getById($command->getDeliveryId());

        $region = $this->deliveryMethods->getRegion($delivery, $command->getRegionId());

        return Excel::download(new PricesExport($delivery, $region->id), "prices_{$delivery->name}_{$region->name}.xlsx");
    }
}
