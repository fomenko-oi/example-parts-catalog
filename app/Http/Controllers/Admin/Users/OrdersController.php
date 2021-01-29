<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Order\UpdateRequest;
use App\Model\Auth\Repository\UserRepository;
use App\Model\Delivery\Repository\CountriesRepository;
use App\Model\Order\Command\UpdateOrder\UpdateOrderCommand;
use App\Model\Order\Entity\Customer\Address;
use App\Model\Order\Entity\Customer\Customer;
use App\Model\Order\Entity\Order;
use App\Model\Order\Entity\Order\OrderDelivery;
use App\Model\Order\Repository\DeliveryMethodRepository;
use App\Model\Order\Repository\OrderRepository;
use App\Model\Order\UseCase\OrderService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    const ITEMS_PER_PAGE = 30;
    /**
     * @var OrderRepository
     */
    private OrderRepository $orders;
    /**
     * @var OrderService
     */
    private OrderService $orderService;

    public function __construct(OrderRepository $orders, OrderService $orderService)
    {
        $this->orders = $orders;
        $this->orderService = $orderService;
    }

    public function complete(Order $order)
    {
        try {
            $this->orderService->complete($order);

            return redirect()->route('admin.users.orders.show', $order)->with('success', 'Order successful completed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(Order $order, Request $request)
    {
        try {
            $this->orderService->reject($order, $request->input('reason'));

            return redirect()->route('admin.users.orders.show', $order)->with('success', 'Order successful rejected.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function rejectForm(Order $order)
    {
        return view('admin.users.orders.reject', compact('order'));
    }

    public function confirmPayment(Order $order)
    {
        try {
            $this->orderService->confirmPayment($order);

            return redirect()->route('admin.users.orders.show', $order)->with('success', 'Order payment successful confirmed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(UpdateRequest $request, Order $order)
    {
        try {
            $orderCommand = new UpdateOrderCommand(
                new Customer(
                    $request->input('name'),
                    $request->input('email'),
                    $request->input('phone'),
                ),
                new Address(
                    $request->input('country_id'),
                    $request->input('region_id'),
                    $request->input('city_id'),
                    $request->input('address'),
                    $request->input('postcode'),
                ),
                new OrderDelivery(
                    $request->input('delivery_type'),
                    $request->input('delivery_cost')
                ),
                $request->input('comment'),
            );

            $this->orderService->update($order, $orderCommand);

            return redirect()->route('admin.users.orders.show', $order)->with('success', 'Order successful updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function remove(Order $order)
    {
        try {
            $order->delete();

            return redirect()->route('admin.users.orders.index')->with('success', 'Order successful removed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Order $order, CountriesRepository $countries, DeliveryMethodRepository $deliveryMethods)
    {
        $customer = $order->customerData;
        $delivery = $order->deliveryData;
        $countries = $countries->all();
        $deliveryMethods = $deliveryMethods->all();
        $paymentMethods = Order\PaymentType::getTypesList();

        return view('admin.users.orders.edit', compact('order', 'customer', 'delivery', 'countries', 'deliveryMethods', 'paymentMethods'));
    }

    public function show(Order $order, UserRepository $users)
    {
        $user = $users->getById($order->user_id);
        $delivery = $order->deliveryData;
        $customer = $order->customerData;

        $items = $order->details()->with('detail.group.mark.model.brand.region.category')->get();

        return view('admin.users.orders.show', compact('order', 'user', 'delivery', 'customer', 'items'));
    }

    public function index()
    {
        $orders = $this->orders->paginate(self::ITEMS_PER_PAGE);

        return view('admin.users.orders.index', compact('orders'));
   }
}
