<?php

declare(strict_types=1);

namespace App\UseCase\Common;

use App\Entity\Common\Config;
use Illuminate\Database\Eloquent\Collection;

class TestConfigService
{
    public function common(): Collection
    {
        return new Collection(['key1' => 'value1']);
    }
}
