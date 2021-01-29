<?php

declare(strict_types=1);

namespace App\Service\Proxy\Manager;

class ConsistentProxyManager implements ProxyManagerInterface
{
    /**
     * @var array
     */
    private $proxy;

    public function __construct(array $proxy)
    {
        $this->proxy = $proxy;
    }

    public function next(): string
    {
        return next($this->proxy);
    }
}
