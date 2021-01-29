<?php

declare(strict_types=1);

namespace App\Service\Proxy\Manager;

class RandomProxyManager implements ProxyManagerInterface
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
        $proxy = $this->proxy[array_rand($this->proxy)];
        //echo "set {$proxy}" . PHP_EOL;

        return $proxy;
    }
}
