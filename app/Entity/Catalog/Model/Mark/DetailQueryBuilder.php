<?php

declare(strict_types=1);

namespace App\Entity\Catalog\Model\Mark;

use Illuminate\Database\Eloquent\Builder;

class DetailQueryBuilder extends Builder
{
    public function whereVisible(): self
    {
        return $this->where('visible', true);
    }

    public function whereHidden(): self
    {
        return $this->where('visible', false);
    }
}
