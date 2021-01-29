<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Customer;

use App\Model\Order\Entity\Order;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Order\Entity\Customer\CustomerData
 *
 * @property int $id
 * @property int $order_id
 * @property string $phone
 * @property string $name
 * @property string $email
 * @property-read \App\Model\Order\Entity\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Customer\CustomerData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Customer\CustomerData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Customer\CustomerData query()
 * @mixin \Eloquent
 */
class CustomerData extends Model
{
    protected $table = 'order_delivery_customer_data';

    protected $fillable = [
        'order_id', 'phone', 'name', 'email'
    ];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
