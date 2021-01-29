<?php

declare(strict_types=1);

namespace App\Model\Auth\Entity;

use Webmozart\Assert\Assert;

class Role
{
    const ADMIN = 'admin';
    const USER = 'user';

    private string $role;

    public function __construct(string $role)
    {
        Assert::notEmpty($role);
        Assert::oneOf($role, array_keys(self::getRoles()));
        $this->role = $role;
    }

    public function getName(): string
    {
        return self::getRoles()[$this->role] ?? '';
    }

    public function getValue(): string
    {
        return $this->role;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === self::USER;
    }

    public static function getRoles(): array
    {
        return [
            self::ADMIN => 'Admin',
            self::USER => 'User',
        ];
    }
}
