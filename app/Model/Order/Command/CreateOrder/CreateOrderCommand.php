<?php

declare(strict_types=1);

namespace App\Model\Order\Command\CreateOrder;

use App\Model\Order\Entity\Customer\Address;
use App\Model\Order\Entity\Customer\Customer;
use App\Model\Order\Entity\Customer\Payment;
use App\Model\Order\Entity\Order\PaymentType;

class CreateOrderCommand
{
    /**
     * @var Customer
     */
    private Customer $customer;
    /**
     * @var Address
     */
    private Address $address;
    /**
     * @var Payment
     */
    private PaymentType $payment;
    private int $deliveryType;
    private ?string $comment;

    public function __construct(Customer $customer, Address $address, PaymentType $payment, int $deliveryType, ?string $comment = null)
    {
        $this->customer = $customer;
        $this->address = $address;
        $this->payment = $payment;
        $this->deliveryType = $deliveryType;
        $this->comment = $comment;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return PaymentType
     */
    public function getPayment(): PaymentType
    {
        return $this->payment;
    }

    /**
     * @return int
     */
    public function getDeliveryType(): int
    {
        return $this->deliveryType;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }
}
