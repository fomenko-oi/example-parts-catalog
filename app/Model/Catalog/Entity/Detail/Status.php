<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity\Detail;

use Webmozart\Assert\Assert;
use App\Entity\Catalog\Model\Mark\Detail;

class Status
{
    private string $value;

    public function __construct(string $status)
    {
        Assert::oneOf($status, array_keys(Detail::getStatusesList()));
        $this->value = $status;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $status): bool
    {
        return $this->value === $status->getValue();
    }
}
