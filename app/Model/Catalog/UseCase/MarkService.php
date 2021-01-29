<?php

declare(strict_types=1);

namespace App\Model\Catalog\UseCase;

use App\Model\Catalog\Category\Repository\MarkRepository;

class MarkService
{
    /**
     * @var MarkRepository
     */
    private MarkRepository $marks;

    public function __construct(MarkRepository $marks)
    {
        $this->marks = $marks;
    }
}
