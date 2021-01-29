<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Order;

use Webmozart\Assert\Assert;

class PaymentType
{
    const DEPOSIT = 'deposit';
    const BILL = 'bill';

    private string $type;

    public function __construct(string $type)
    {
        Assert::oneOf($type, array_keys(self::getTypesList()));
        $this->type = $type;
    }

    public static function deposit(): self
    {
        return new self(self::DEPOSIT);
    }

    public static function bill(): self
    {
        return new self(self::BILL);
    }

    public function isBill(): bool
    {
        return $this->type === self::BILL;
    }

    public function isDeposit(): bool
    {
        return $this->type === self::DEPOSIT;
    }

    public function isEqual(self $type): bool
    {
        return $this->type === $type->getValue();
    }

    public function getValue(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return self::getTypesList()[$this->type] ?? '';
    }

    public static function getTypesList(): array
    {
        return [
            self::DEPOSIT => 'Deposit',
            self::BILL => 'Bill',
        ];
    }
}
