<?php

namespace App\Http\Controllers;

use App\Entity\Catalog\Model\Mark\Detail;
use App\Http\Requests\Order\Checkout\PreCheckOutRequest;
use App\Http\Resources\User\Cart\CartItemResource;
use App\Http\Resources\User\Cart\DeliveryItemResource;
use App\Model\Auth\Entity\Address\Address;
use App\Model\Auth\Entity\User;
use App\Model\Cart\Service\Cart;
use App\Model\Catalog\Command\SearchDetail\SearchDetailCommand;
use App\Model\Catalog\Command\SearchDetail\SearchDetailHandler;
use App\Model\Catalog\Command\SuggestSearch\SuggestSearchCommand;
use App\Model\Catalog\Command\SuggestSearch\SuggestSearchHandler;
use App\Model\Delivery\Repository\CountriesRepository;
use App\Model\Order\Entity\Order\PaymentType;
use App\Model\Order\Repository\DeliveryMethodRepository;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{
    /**
     * @var CountriesRepository
     */
    private CountriesRepository $countries;

    public function __construct(CountriesRepository $countries)
    {
        $this->countries = $countries;
    }

    public function checkout(Cart $cart, DeliveryMethodRepository $deliveries)
    {
        /** @var User $user */
        $user = Auth::user();
        $items = $cart->getItems();

        $address = $user ? $user->mainAddress : Address::make();

        $default = new \stdClass();
        $default->country = old('country_id', $address->country_id);
        $default->region = old('region_id', $address->region_id);
        $default->city = old('city_id', $address->city_id);

        $countries = $this->countries->all();

        $paymentTypes = array_map(function($type) {
            return __($type);
        }, PaymentType::getTypesList());

        $deliveryMethods = DeliveryItemResource::collection($deliveries->all());

        return view('app.checkout', compact('user', 'items', 'countries', 'default', 'address', 'paymentTypes', 'deliveryMethods'));
    }

    public function cart(Cart $cart, DeliveryMethodRepository $deliveryMethods)
    {
        $deliveryMethods = DeliveryItemResource::collection($deliveryMethods->all());
        $items = $cart->getItems();
        $cartItems = CartItemResource::collection($items);

        return view('app.cart', compact('deliveryMethods', 'items', 'cartItems'));
    }

    public function simpleSearch(Request $request, SuggestSearchHandler $search)
    {
        try {
            $command = new SuggestSearchCommand($request->get('q'));

            $details = $search->execute($command);

            return ['success' => true, 'html' => (string)view('app.catalog.search', compact('details'))];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function search(Request $request, SearchDetailHandler $handler)
    {
        $details = [];

        if ($q = $request->input('q')) {
            $command = new SearchDetailCommand($q);
            $details = $handler->execute($command);
        }

        return view('app.search', compact('details'));
    }
}
