<?php

declare(strict_types=1);

namespace App\Model\Order\Repository;

use App\Model\Order\Entity\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    public function paginate(int $limit): LengthAwarePaginator
    {
        return Order::with('deliveryMethod')->orderBy('created_at', 'DESC')->paginate($limit);
    }

    public function getTotalUserPendingPrice(int $userId)
    {
        return Order::where('user_id', $userId)
            ->where('current_payment_status', Order\PaymentStatus::WAIT)
            ->sum(\DB::raw('delivery_cost + cost'));
    }

    public function getTotalUserHoldBalance(int $userId)
    {
        return Order::where('user_id', $userId)
            ->where('current_payment_status', Order\PaymentStatus::COMPLETED)
            ->where('current_status', Order\Status::NEW)
            ->sum(\DB::raw('delivery_cost + cost'));
    }

    public function findForUser(int $userId): Collection
    {
        return Order::with('details', 'deliveryMethod')
            ->where('user_id',  $userId)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
