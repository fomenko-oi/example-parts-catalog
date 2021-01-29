<?php

declare(strict_types=1);

namespace App\UseCase\Common;

class CurrencyManager
{
    protected static $value;
    protected static $usd;

    public static function init(float $rub, float $usd)
    {
        self::$value = $rub;
        self::$usd = $usd;
    }

    // get rate to convert from YEN to RUB
    public static function getRate(): float
    {
        return self::$value;
    }

    // get rate to convert from YEN to USD
    public static function getDollarRate(): float
    {
        return self::$usd;
    }

    public static function getOppositeDollarRate(): float
    {
        return 1 / (self::$usd / 1);
    }

    // get opposite rate - convert from RUB to YEN
    public static function getOppositeRate(): float
    {
        return 1 / (self::$value / 1);
    }

    // convert from YEN to RUB
    public static function toRub($value)
    {
        return $value * self::getOppositeRate();
    }

    // convert from RUB to YEN
    public static function toYen($value)
    {
        return $value * self::getRate();
    }

    // convert from dollar to YEN
    public static function toDollarYen($value)
    {
        return $value * self::getOppositeDollarRate();
    }

    public static function toDollarYenDirect($value)
    {
        return $value * self::getDollarRate();
    }
}
