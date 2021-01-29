<?php

declare(strict_types=1);

namespace App\Model\Cart\Service\Storage;

use App\Model\Cart\Service\CartItem;

interface StorageInterface
{
    /**
     * @return CartItem[]
     */
    public function load(): array;

    /**
     * @param CartItem[] $items
     */
    public function save(array $items): void;
}
