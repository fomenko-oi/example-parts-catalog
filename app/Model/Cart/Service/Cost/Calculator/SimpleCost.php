<?php

declare(strict_types=1);

namespace App\Model\Cart\Service\Cost\Calculator;

use App\Model\Cart\Service\CartItem;
use App\Model\Cart\Service\Cost\Cost;

class SimpleCost implements CalculatorInterface
{
    public function getCost(array $items): Cost
    {
        $cost = 0;
        /** @var CartItem $item */
        foreach ($items as $item) {
            $cost += $item->getCost();
        }
        return new Cost($cost);
    }
}
