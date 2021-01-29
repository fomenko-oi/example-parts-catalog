<?php

declare(strict_types=1);

namespace App\Service\Proxy\Manager;

interface ProxyManagerInterface
{
    public function next(): string;
}
