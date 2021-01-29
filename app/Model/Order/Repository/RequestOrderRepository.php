<?php

declare(strict_types=1);

namespace App\Model\Order\Repository;

use App\Model\Order\Entity\Request\RequestDetail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RequestOrderRepository
{
    public function paginate(int $limit): LengthAwarePaginator
    {
        return RequestDetail::with('detail.group.mark.model.region.category', 'user')->orderBy('created_at', 'DESC')->paginate($limit);
    }

    public function findForUser(int $userId): Collection
    {
        return RequestDetail::with('detail', 'user')
            ->orderBy('created_at', 'DESC')
            ->where('user_id', $userId)
            ->get();
    }
}
