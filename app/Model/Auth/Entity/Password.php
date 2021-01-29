<?php

declare(strict_types=1);

namespace App\Model\Auth\Entity;

use Webmozart\Assert\Assert;

class Password
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
