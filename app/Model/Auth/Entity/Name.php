<?php

declare(strict_types=1);

namespace App\Model\Auth\Entity;

use Webmozart\Assert\Assert;

class Name
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        Assert::minCount(explode(' ', $value), 2, 'Value must contains first and last names.');
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
