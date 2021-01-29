<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Order;

use Webmozart\Assert\Assert;

class PaymentStatus
{
    const WAIT = 'wait';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';

    private string $status;

    public function __construct(string $status)
    {
        Assert::oneOf($status, array_keys(self::getStatusList()));
        $this->status = $status;
    }

    public static function wait(): self
    {
        return new self(self::WAIT);
    }

    public static function completed(): self
    {
        return new self(self::COMPLETED);
    }

    public static function canceled(): self
    {
        return new self(self::CANCELED);
    }

    public function isWait(): bool
    {
        return $this->status === self::WAIT;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::COMPLETED;
    }

    public function isCanceled(): bool
    {
        return $this->status === self::CANCELED;
    }

    public function isEqual(self $status): bool
    {
        return $this->status === $status->getValue();
    }

    public function getValue(): string
    {
        return $this->status;
    }

    public function getName(): string
    {
        return self::getStatusList()[$this->status] ?? '';
    }

    public static function getStatusList(): array
    {
        return [
            self::WAIT => 'Waiting',
            self::COMPLETED => 'Completed',
            self::CANCELED => 'Canceled',
        ];
    }
}
