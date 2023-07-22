<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserCustomer;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationHelper
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function setUpUser(User $user): void
    {
        $this->setUpPassword($user);
        $this->createUserCustomer($user);
    }

    private function setUpPassword(User $user): void
    {
        $passoword = $user->getPassword();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $passoword);
        $user->setPassword($hashedPassword);
    }

    private function createUserCustomer(User $user): void
    {
        $userCustomer = new UserCustomer();
        $userCustomer->setUser($user);

        $user->setUserCustomer($userCustomer);
    }
}
