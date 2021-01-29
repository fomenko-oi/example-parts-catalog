<?php

declare(strict_types=1);

namespace App\Model\Auth\Service;

interface PasswordGenerator
{
    public function generate(): string;
}
