<?php

declare(strict_types=1);

namespace App\Model\Auth\UseCase;

use App\Model\Auth\Entity\Password;
use App\Model\Auth\Entity\User;
use App\Model\Auth\Repository\UserRepository;
use App\Model\Auth\Service\PasswordGenerator;
use Hash;

class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $users;
    /**
     * @var PasswordGenerator
     */
    private PasswordGenerator $password;

    public function __construct(UserRepository $users, PasswordGenerator $password)
    {
        $this->users = $users;
        $this->password = $password;
    }

    public function setRandomPassword(User $user): string
    {
        $this->users->updatePassword($user, new Password(Hash::make($str = $this->password->generate())));

        return $str;
    }
}
