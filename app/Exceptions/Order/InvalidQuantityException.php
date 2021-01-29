<?php

namespace App\Exceptions\Order;

use Exception;
use Throwable;

class InvalidQuantityException extends Exception
{
    private array $items;

    public function __construct($message = "", $code = 0, Throwable $previous = null, array $items = [])
    {
        $this->items = $items;

        parent::__construct($message, $code, $previous);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
