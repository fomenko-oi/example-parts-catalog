<?php

declare(strict_types=1);

namespace App\Model\Order\Entity;

use App\Entity\Catalog\Model\Mark\Detail;
use App\Model\Auth\Entity\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Order\Entity\OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $detail_id
 * @property string $detail_name
 * @property string $detail_code
 * @property float $price
 * @property int $quantity
 * @property-read \App\Entity\Catalog\Model\Mark\Detail|null $detail
 * @property-read \App\Model\Order\Entity\Order $order
 * @property-read \App\Model\Auth\Entity\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\OrderItem query()
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    protected $table = 'order_detail_items';

    protected $fillable = [
        'order_id', 'detail_id', 'detail_name', 'detail_code', 'price', 'quantity',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detail()
    {
        return $this->belongsTo(Detail::class, 'detail_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function setQuantity(int $quantity)
    {
        if (!$this->canBeCheckout($quantity)) {
            throw new \DomainException('Unable to set this order detail quantity.');
        }

        $this->update(['quantity' => $quantity]);
    }

    public function canBeCheckout(int $quantity)
    {
        return $this->detail->quantity >= $quantity;
    }
}
