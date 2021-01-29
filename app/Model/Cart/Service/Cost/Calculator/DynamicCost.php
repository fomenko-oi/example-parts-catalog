<?php

declare(strict_types=1);

namespace App\Model\Cart\Service\Cost\Calculator;

use App\Model\Cart\Service\Cost\Cost;
use App\Model\Cart\Service\Cost\Discount as CartDiscount;

class DynamicCost implements CalculatorInterface
{
    private $next;
    private int $percent;

    public function __construct(CalculatorInterface $next, int $percent)
    {
        $this->next = $next;
        $this->percent = $percent;
    }

    public function getCost(array $items): Cost
    {
        $cost = $this->next->getCost($items);

        $new = new CartDiscount($cost->getOrigin() * $this->percent / 100, 'Discount');
        $cost = $cost->withDiscount($new);

        return $cost;
    }
}
