<?php

namespace App\Exceptions\Order;

use Exception;
use Throwable;

class InvalidDepositBalanceException extends Exception
{
    private float $value;

    public function __construct($message = "", $code = 0, Throwable $previous = null, float $value = 0)
    {
        $this->value = $value;

        parent::__construct($message, $code, $previous);
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
