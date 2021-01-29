<?php

declare(strict_types=1);

namespace App\Model\Order\UseCase;

use App\Exceptions\Order\InvalidDepositBalanceException;
use App\Exceptions\Order\InvalidQuantityException;
use App\Model\Auth\Repository\UserRepository;
use App\Model\Cart\Service\Cart;
use App\Model\Cart\Service\CartItem;
use App\Model\Cart\Service\Cost\Calculator\CalculatorInterface;
use App\Model\Catalog\Category\Repository\DetailRepository;
use App\Model\Delivery\Command\Delivery\CalculateDeliveryCommand;
use App\Model\Delivery\UseCase\CountryService;
use App\Model\Deposit\Entity\Deposit\Balance;
use App\Model\Deposit\Entity\Deposit\Deposit;
use App\Model\Order\Command\CreateOrder\CreateOrderCommand;
use App\Model\Order\Command\UpdateOrder\UpdateOrderCommand;
use App\Model\Order\Entity\Delivery\DeliveryData;
use App\Model\Order\Entity\Order;
use App\Model\Order\Entity\OrderItem;
use App\Model\Order\Repository\DeliveryMethodRepository;
use App\Model\Order\Repository\OrderRepository;
use Carbon\Carbon;
use DB;

class OrderService
{
    /**
     * @var Cart
     */
    private Cart $cart;
    /**
     * @var OrderRepository
     */
    private OrderRepository $orders;
    /**
     * @var DetailRepository
     */
    private DetailRepository $details;
    /**
     * @var UserRepository
     */
    private UserRepository $users;
    /**
     * @var DeliveryMethodRepository
     */
    private DeliveryMethodRepository $deliveryMethods;
    /**
     * @var CountryService
     */
    private CountryService $countryService;
    /**
     * @var CalculatorInterface
     */
    private $calculator;

    public function __construct(
        Cart $cart,
        OrderRepository $orders,
        DetailRepository $details,
        UserRepository $users,
        DeliveryMethodRepository $deliveryMethods,
        CountryService $countryService,
        CalculatorInterface $calculator
    ) {
        $this->cart = $cart;
        $this->orders = $orders;
        $this->details = $details;
        $this->users = $users;
        $this->deliveryMethods = $deliveryMethods;
        $this->countryService = $countryService;
        $this->calculator = $calculator;
    }

    public function reject(Order $order, ?string $reason = '')
    {
        if (!$order->getStatus()->isNew() && !$order->getPaymentStatus()->isWait()) {
            throw new \DomainException('Unable to reject the order.');
        }

        $order->update([
            'current_payment_status' => Order\PaymentStatus::CANCELED,
            'current_status' => Order\Status::CANCELED,
            'cancel_reason' => $reason
        ]);
    }

    public function confirmPayment(Order $order): void
    {
        if (!$order->getStatus()->isNew()) {
            throw new \DomainException('Unable to complete the order.');
        }
        if (!$order->getPaymentStatus()->isWait()) {
            throw new \DomainException('Payment status is already changed.');
        }

        $order->update(['current_payment_status' => Order\PaymentStatus::COMPLETED]);
    }

    public function complete(Order $order): void
    {
        if (!$order->getStatus()->isNew()) {
            throw new \DomainException('Unable to complete the order.');
        }
        if (!$order->getPaymentStatus()->isCompleted()) {
            throw new \DomainException('For confirm, order must be payed.');
        }

        $order->update(['current_status' => Order\Status::COMPLETED]);
    }

    public function update(Order $order, UpdateOrderCommand $command): void
    {
        $order->update([
            'delivery_cost' => $command->getDelivery()->getPrice(),
            'note' => $command->getComment(),
            'delivery_method_id' => $command->getDelivery()->getType(),
        ]);

        $order->setCustomerData($command->getCustomer());
        $order->setDeliveryInfo($command->getAddress());
    }

    public function checkout($userId, CreateOrderCommand $command): Order
    {
        if (count($this->cart->getItems()) === 0) {
            throw new \DomainException('Unable to created order without details.');
        }

        $items = array_map(function (CartItem $item) use (&$details) {
            $detail = $item->getDetail();
            $detail->checkout($item->getQuantity());

            $details[] = $detail;

            return OrderItem::make([
                'detail_id' => $item->getId(),
                'detail_name' => $detail->name,
                'detail_code' => $detail->sku,
                'price' => $item->getPrice(),
                'quantity' => $item->getQuantity(),
            ]);
        }, $this->cart->getItems());

        $deliveryMethod = $this->deliveryMethods->getById($command->getDeliveryType());
        $deliveryPrice = $this->countryService->calculateDelivery($deliveryMethod, new CalculateDeliveryCommand(
            $command->getAddress()->getCountry(),
            $this->cart->getWeight()
        ));

        $order = DB::transaction(function () use ($userId, $command, $items, $deliveryPrice) {
            $order = Order::create([
                'user_id' => $userId,
                'cost' => $this->cart->getCost()->getTotal(),
                'delivery_cost' => $deliveryPrice,
                'note' => $command->getComment(),
                'delivery_method_id' => $command->getDeliveryType(),
                'current_status' => Order\Status::NEW,
                'payment_method' => $command->getPayment()->getValue(),
                'current_payment_status' => Order\PaymentStatus::WAIT,
            ]);

            $order->setCustomerData($command->getCustomer());
            $order->setDeliveryInfo($command->getAddress());

            $order->details()->saveMany($items);

            $this->cart->clear();

            return $order;
        });

        event(new Order\Event\OrderCreated($order));

        return $order;
    }

    public function updateDetails(Order $order, array $items): Order
    {
        $errors = [];

        $weight = 0;
        $orderItems = array_map(function (CartItem $item) use ($order, &$errors, &$weight) {
            /** @var OrderItem $orderItem */
            if (!($orderItem = $order->details()->where('detail_id', $item->getId())->first())) {
                throw new \DomainException('Unable to increase product ' . $item->getId() . ' quantity.');
            }

            $detail = $item->getDetail();

            $detail->setQuantity($detail->quantity + $orderItem->quantity);

            try {
                $detail->checkout($item->getQuantity());
                $orderItem->setQuantity($item->getQuantity());
                $weight += $item->getWeight();
            } catch (\Exception $e) {
                $errors[$item->getId()] = [
                    'current' => $item->getQuantity(),
                    'max' => $detail->quantity
                ];
            }

            return OrderItem::make([
                'detail_id' => $item->getId(),
                'detail_name' => $detail->name,
                'detail_code' => $detail->sku,
                'price' => $item->getPrice(),
                'quantity' => $item->getQuantity(),
            ]);
        }, $items);

        if (count($orderItems) === 0) {
            throw new \DomainException('Unable to save order without items.');
        }

        $order->details()->delete();

        $order->details()->saveMany($orderItems);

        $price = $this->calculator->getCost($items);

        $deliveryMethod = $this->deliveryMethods->getById($order->delivery_method_id);
        $deliveryPrice = $this->countryService->calculateDelivery($deliveryMethod, new CalculateDeliveryCommand(
            $order->deliveryData->country_id,
            $weight
        ));

        $order->update(['cost' => $price->getTotal(), 'delivery_cost' => $deliveryPrice]);

        if (count($errors) > 0) {
            throw new InvalidQuantityException('Unable to save this details quantity.', 0, null, $errors);
        }

        return $order;
    }

    public function depositPay(Deposit $deposit, Order $order)
    {
        $balance = $deposit->getBalance();
        if (!$balance->isGTE($orderCost = new Balance($order->getTotalCost()))) {
            throw new InvalidDepositBalanceException(
                'You don\'t have enough money for pay this order.',
                0,
                null,
                ceil($orderCost->getValue() - $balance->getValue())
            );
        }

        $deposit->holdMoney($orderCost);
        $order->setPayed(Carbon::now());
    }

    public function generateInvoice(Order $order): string
    {
        return file_get_contents(storage_path('app/deposit_invoice.pdf'));
    }
}
