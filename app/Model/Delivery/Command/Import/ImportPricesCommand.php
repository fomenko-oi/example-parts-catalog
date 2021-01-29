<?php

declare(strict_types=1);

namespace App\Model\Delivery\Command\Import;

use Illuminate\Http\UploadedFile;
use Webmozart\Assert\Assert;

class ImportPricesCommand
{
    private int $deliveryId;
    private int $regionId;
    private string $path;

    public function __construct(int $deliveryId, int $regionId, string $path)
    {
        $this->deliveryId = $deliveryId;
        $this->regionId = $regionId;
        $this->path = $path;
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

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
