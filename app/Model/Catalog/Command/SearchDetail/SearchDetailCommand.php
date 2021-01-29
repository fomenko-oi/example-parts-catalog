<?php

declare(strict_types=1);

namespace App\Model\Catalog\Command\SearchDetail;

use Webmozart\Assert\Assert;

class SearchDetailCommand
{
    private string $q;

    public function __construct(string $q)
    {
        Assert::notEmpty($q);
        Assert::minLength($q, 2);
        $this->q = $q;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->q;
    }
}
