<?php

declare(strict_types=1);

namespace App\Model\Order\Entity;

use App\Model\Cart\Entity\DetailItem;
use App\Model\Order\Entity\Customer\Address;
use App\Model\Order\Entity\Customer\Customer;
use App\Model\Order\Entity\Customer\CustomerData;
use App\Model\Order\Entity\Order\OrderDetailItem;
use App\Model\Order\Entity\Order\PaymentStatus;
use App\Model\Order\Entity\Order\PaymentType;
use App\Model\Order\Entity\Order\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Model\Order\Entity\Delivery\DeliveryData;
use App\Model\Delivery\Entity\Delivery\DeliveryMethod;

/**
 * App\Model\Order\Entity\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $delivery_method_id
 * @property int|null $delivery_cost
 * @property string $payment_method
 * @property string $current_payment_status
 * @property string $current_status
 * @property float $cost
 * @property string|null $note
 * @property string|null $cancel_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Order\Entity\Customer\CustomerData|null $customerData
 * @property-read \App\Model\Order\Entity\Delivery\DeliveryData|null $deliveryData
 * @property-read \App\Model\Delivery\Entity\Delivery\DeliveryMethod|null $deliveryMethod
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Order\Entity\OrderItem[] $details
 * @property-read int|null $details_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Order query()
 * @mixin \Eloquent
 */
class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'delivery_method_id',
        'delivery_cost',
        'payment_method',
        'cost',
        'note',
        'current_status',
        'current_payment_status',
        'cancel_reason',
    ];

    public function deliveryMethod()
    {
        return $this->hasOne(DeliveryMethod::class, 'id', 'delivery_method_id');
    }

    public function deliveryData()
    {
        return $this->hasOne(DeliveryData::class);
    }

    public function customerData()
    {
        return $this->hasOne(CustomerData::class);
    }

    public function details()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatus(): Status
    {
        return new Status($this->current_status);
    }

    public function getPaymentStatus(): PaymentStatus
    {
        return new PaymentStatus($this->current_payment_status);
    }

    public function getPaymentMethod(): PaymentType
    {
        return new PaymentType($this->payment_method);
    }

    public function getTotalCost(): float
    {
        return $this->cost + $this->delivery_cost;
    }

    public function setPayed(Carbon $payedAt): void
    {
        $this->update([
            'current_payment_status' => Status::COMPLETED
        ]);
    }

    public function setCustomerData(Customer $customer)
    {
        if (!$this->customerData) {
            $this->customerData()->create([
                'name' => $customer->getName(),
                'email' => $customer->getEmail(),
                'phone' => $customer->getPhone(),
            ]);
            return;
        }

        $this->customerData->update([
            'name' => $customer->getName(),
            'email' => $customer->getEmail(),
            'phone' => $customer->getPhone(),
        ]);
    }

    public function setDeliveryInfo(Address $address)
    {
        if (!$this->deliveryData) {
            $this->deliveryData()->create([
                'index' => $address->getPostcode(),
                'address' => $address->getAddress(),
                'country_id' => $address->getCountry(),
                'region_id' => $address->getRegion(),
                'city_id' => $address->getCity(),
            ]);
            return;
        }

        $this->deliveryData()->update([
            'index' => $address->getPostcode(),
            'address' => $address->getAddress(),
            'country_id' => $address->getCountry(),
            'region_id' => $address->getRegion(),
            'city_id' => $address->getCity(),
        ]);
    }
}
