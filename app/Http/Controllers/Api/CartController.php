<?php

namespace App\Http\Controllers\Api;

use App\Model\Cart\UseCase\CartService;
use App\Model\Catalog\Category\Repository\DetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * @var DetailRepository
     */
    private DetailRepository $details;
    /**
     * @var CartService
     */
    private CartService $cart;

    public function __construct(DetailRepository $details, CartService $cart)
    {
        $this->details = $details;
        $this->cart = $cart;
    }

    public function add(Request $request)
    {
        try {
            $this->cart->add($request->input('id'), 1);

            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function update(Request $request)
    {
        $detail = $this->details->getById($request->input('id'));

        try {
            $this->cart->set($detail->id, (int)$request->input('quantity'));

            return ['success' => true, 'quantity' => $detail->quantity];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage(), 'quantity' => $detail->quantity];
        }
    }

    public function delete(Request $request)
    {
        try {
            $this->cart->remove((int)$request->input('id'));

            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
