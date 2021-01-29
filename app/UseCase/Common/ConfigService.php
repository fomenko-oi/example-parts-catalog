<?php

namespace App\UseCase\Common;

use App\Entity\Common\Config;
use Illuminate\Database\Eloquent\Collection;

class ConfigService
{
    public function getByKey(string $name): ?Config
    {
        return Config::where('key', $name)->first();
    }

    public function findByKey(string $name): ?Config
    {
        return Config::where('key', $name)->first();
    }

    public function common(): Collection
    {
        return Config::autoload()->get()->keyBy('key');
    }

    public function all(): Collection
    {
        return Config::all();
    }
}
