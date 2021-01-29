<?php

declare(strict_types=1);

namespace App\Model\Auth\Entity;

use Webmozart\Assert\Assert;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        Assert::email($email);
        $this->email = $email;
    }

    public function getValue(): string
    {
        return $this->email;
    }
}
