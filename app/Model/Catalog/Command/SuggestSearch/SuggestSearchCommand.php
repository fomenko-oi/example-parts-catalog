<?php

declare(strict_types=1);

namespace App\Model\Catalog\Command\SuggestSearch;

use Webmozart\Assert\Assert;

class SuggestSearchCommand
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
