<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationHelper
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function setUpUser(User $user): void
    {
        $this->setUpPassword($user);
    }

    private function setUpPassword(User $user): void
    {
        $passoword = $user->getPassword();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $passoword);
        $user->setPassword($hashedPassword);
    }
}
