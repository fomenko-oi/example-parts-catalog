<?php

namespace App\Console\Commands\User\Auth;

use App\Model\Auth\Entity\Email;
use App\Model\Auth\Entity\Name;
use App\Model\Auth\Entity\Password;
use App\Model\Auth\Entity\Phone;
use App\Model\Auth\Entity\Role;
use App\Model\Auth\Repository\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    protected $signature = 'app:user:create';

    protected $description = 'Register new user';

    public function handle(UserRepository $users)
    {
        do {
            $email = new Email($this->ask('What is user email?'));

            $exists = $users->hasByEmail($email);

            if ($exists) {
                $this->error('User with email ' . $email->getValue() . ' already exists.');
            }
        } while($exists);

        do {
            $rawPassword = $this->ask('What is user password?', false);
        } while(!$rawPassword);

        $password = new Password(Hash::make($rawPassword));

        $role = new Role($this->askWithCompletion('What role do want to apply?', Role::getRoles(), Role::USER));

        do {
            $name = new Name($this->ask('What is user name?', false));
        } while(!$name);

        $phone = new Phone('+7(000) 000-00-00');

        $user = $users->create($email, $phone, $role, $name, $password);

        $this->info('User ' . $user->id . ' successful created.');
    }
}
