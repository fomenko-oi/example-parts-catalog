<?php

declare(strict_types=1);

namespace App\Model\Cart\Service\Cost\Calculator;

use App\Model\Cart\Service\CartItem;
use App\Model\Cart\Service\Cost\Cost;

interface CalculatorInterface
{
    /**
     * @param CartItem[] $items
     * @return Cost
     */
    public function  getCost(array $items): Cost;
}
