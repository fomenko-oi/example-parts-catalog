<?php

declare(strict_types=1);

namespace App\Model\Catalog\Category\Repository;

use App\Entity\Catalog\Model\Mark;

class MarkRepository
{
    public function getById(int $id): Mark
    {
        return Mark::where('id', $id)->firstOrFail();
    }
}
