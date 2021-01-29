<?php

declare(strict_types=1);

namespace App\Model\Cart\UseCase;

use App\Model\Cart\Service\Cart;
use App\Model\Cart\Service\CartItem;
use App\Model\Catalog\Category\Repository\DetailRepository;

class CartService
{
    /**
     * @var DetailRepository
     */
    private DetailRepository $details;
    /**
     * @var Cart
     */
    private Cart $cart;

    public function __construct(Cart $cart, DetailRepository $details)
    {
        $this->cart = $cart;
        $this->details = $details;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function add(int $detailId, int $quantity): void
    {
        $detail = $this->details->getById($detailId);
        $this->cart->add(new CartItem($detail, $quantity));
    }

    public function set($id, $quantity): void
    {
        $this->cart->set($id, $quantity);
    }

    public function remove(int $id): void
    {
        $this->cart->remove($id);
    }

    public function clear(): void
    {
        $this->cart->clear();
    }
}
