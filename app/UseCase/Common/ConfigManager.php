<?php

declare(strict_types=1);

namespace App\UseCase\Common;

use App\Entity\Common\Config;

class ConfigManager
{
    public static $list = [];

    public static function init(array $list)
    {
        self::$list = $list;
    }

    public static function get($key, $default = null)
    {
        $value = $default;
        if(isset(self::$list[$key])) {
            return self::$list[$key];
        }

        if ($config = Config::where('key', $key)->first()) {
            self::$list[$config->key] = $config->value;
            return $config->value;
        }

        self::$list[$key] = $default;

        return $value;
    }
}
