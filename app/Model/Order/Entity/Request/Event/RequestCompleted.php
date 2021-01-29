<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Request\Event;

use App\Model\Order\Entity\Request\RequestDetail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RequestCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var RequestDetail
     */
    private RequestDetail $request;

    public function __construct(RequestDetail $request)
    {
        $this->request = $request;
    }
}
