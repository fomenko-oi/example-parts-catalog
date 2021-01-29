<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Request;

use App\Entity\Catalog\Model\Mark\Detail;
use App\Model\Auth\Entity\User;
use App\Model\Order\Entity\Request\Event\RequestCompleted;
use App\Model\Order\Entity\Request\Event\RequestCreated;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Order\Entity\Request\RequestDetail
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $status
 * @property string|null $comment
 * @property int|null $user_id
 * @property int $detail_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entity\Catalog\Model\Mark\Detail $detail
 * @property-read \App\Model\Auth\Entity\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Request\RequestDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Request\RequestDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Order\Entity\Request\RequestDetail query()
 * @mixin \Eloquent
 */
class RequestDetail extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_COMPLETED = 'completed';

    protected $table = 'detail_requests';

    protected $fillable = [
        'name', 'email', 'phone', 'status', 'user_id', 'detail_id', 'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail()
    {
        return $this->belongsTo(Detail::class, 'detail_id');
    }

    public static function createOrder(Detail $detail, string $name, string $email, string $phone, ?int $userId = null): self
    {
        if (!$detail->isByRequest()) {
            throw new \DomainException('Unable to create request with this detail.');
        }

        $request = self::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'detail_id' => $detail->id,
            'user_id' => $userId,
            'status' => self::STATUS_NEW
        ]);

        event(new RequestCreated($request));

        return $request;
    }

    public function complete(?string $comment = '')
    {
        if ($this->isCompleted()) {
            throw new \DomainException('The order is already completed.');
        }
        event(new RequestCompleted($this));

        return $this->update(['status' => self::STATUS_COMPLETED, 'comment' => $comment]);
    }

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public static function getStatusesList(): array
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_COMPLETED => 'Completed',
        ];
    }
}
