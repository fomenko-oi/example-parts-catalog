<?php

declare(strict_types=1);

namespace App\Model\Cart\Entity;

use App\Entity\Catalog\Model\Mark\Detail;
use App\Model\Order\Entity\Order;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Cart\Entity\DetailItem
 *
 * @property int $id
 * @property int $detail_id
 * @property int $quantity
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cart\Entity\DetailItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cart\Entity\DetailItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Cart\Entity\DetailItem query()
 * @mixin \Eloquent
 */
class DetailItem extends Model
{
    protected $table = 'users_cart_items';
    protected $fillable = [
        'detail_id', 'quantity', 'user_id',
    ];

    public $timestamps = false;

    public function getId(): int
    {
        return $this->detail_id;
    }

    public function detail()
    {
        return $this->belongsTo(Detail::class, 'detail_id', 'id');
    }
}
