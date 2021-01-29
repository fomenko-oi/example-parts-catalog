<?php

declare(strict_types=1);

namespace App\Model\Auth\Service;

use Illuminate\Support\Str;

class SimplePasswordGenerator implements PasswordGenerator
{
    private int $length;

    public function __construct(int $length = 6)
    {
        $this->length = $length;
    }

    public function generate(): string
    {
        return Str::random($this->length);
    }
}
