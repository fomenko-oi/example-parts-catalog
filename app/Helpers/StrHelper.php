<?php

declare(strict_types=1);

namespace App\Helpers;

class StrHelper
{
    public static function last(string $input, string $splitBy = '/'): ?string
    {
        $segments = explode($splitBy, $input);

        return count($segments) > 0 ? last($segments) : null;
    }

    public static function lastWithout(string $input, string $splitBy = '/', array $remove = []): ?string
    {
        $segments = explode($splitBy, $input);

        return count($segments) > 0 ? str_replace($remove, '', last($segments)) : null;
    }
}
