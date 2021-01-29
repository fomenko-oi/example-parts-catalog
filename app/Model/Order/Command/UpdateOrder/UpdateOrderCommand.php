<?php

declare(strict_types=1);

namespace App\Model\Order\Command\UpdateOrder;

use App\Model\Order\Entity\Customer\Address;
use App\Model\Order\Entity\Customer\Customer;
use App\Model\Order\Entity\Customer\Payment;
use App\Model\Order\Entity\Order\OrderDelivery;
use App\Model\Order\Entity\Order\PaymentType;

class UpdateOrderCommand
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
     * @var OrderDelivery
     */
    private OrderDelivery $delivery;
    private ?string $comment;

    public function __construct(Customer $customer, Address $address, OrderDelivery $delivery, ?string $comment = null)
    {
        $this->customer = $customer;
        $this->address = $address;
        $this->delivery = $delivery;
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
     * @return OrderDelivery
     */
    public function getDelivery(): OrderDelivery
    {
        return $this->delivery;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }
}
