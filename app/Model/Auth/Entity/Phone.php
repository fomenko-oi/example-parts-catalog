<?php

declare(strict_types=1);

namespace App\Model\Auth\Entity;

use Webmozart\Assert\Assert;

class Phone
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::regex($value, '/\+[0-9]{1}\([0-9]{3}\) [0-9]{3}\-[0-9]{2}\-[0-9]{2}/', 'Mobile phone is invalid.');
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
