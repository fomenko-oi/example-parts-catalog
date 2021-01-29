<?php

declare(strict_types=1);

namespace App\Model\Order\Entity\Customer;

use Webmozart\Assert\Assert;

class Customer
{
    private string $name;
    private string $email;
    private string $phone;

    public function __construct(string $name, string $email, string $phone)
    {
        Assert::notEmpty($name);
        Assert::email($email);
        Assert::regex($phone, '/\+[0-9]{1}\([0-9]{3}\) [0-9]{3}\-[0-9]{2}\-[0-9]{2}/', 'Mobile phone is invalid.');

        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }
}
