<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Order;

use Webmozart\Assert\Assert;

class Status
{
    const NEW = 'new';
    const DELIVERING = 'delivering';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';

    private string $status;

    public function __construct(string $status)
    {
        Assert::oneOf($status, array_keys(self::getStatusesList()));
        $this->status = $status;
    }

    public static function new(): self
    {
        return new self(self::NEW);
    }

    public static function completed(): self
    {
        return new self(self::COMPLETED);
    }

    public static function canceled(): self
    {
        return new self(self::CANCELED);
    }

    public function isNew(): bool
    {
        return $this->status === self::NEW;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::COMPLETED;
    }

    public function isCanceled(): bool
    {
        return $this->status === self::CANCELED;
    }

    public function isDelivering(): bool
    {
        return $this->status === self::DELIVERING;
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
        return self::getStatusesList()[$this->status] ?? '';
    }

    public function getClass(): string
    {
        return [
            self::NEW => 'process',
            self::COMPLETED => 'done',
            self::DELIVERING => 'done',
            self::CANCELED => 'error',
        ][$this->status] ?? '';
    }

    public static function getStatusesList(): array
    {
        return [
            self::NEW => 'New',
            self::COMPLETED => 'Completed',
            self::CANCELED => 'Canceled',
            self::DELIVERING => 'Delivering',
        ];
    }
}
