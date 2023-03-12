<?php

namespace App\Service;

use App\Entity\User;
use DateTime;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationHelper
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function setUpUser(User $user)
    {
        $this->setUpPassword($user);
        $this->setUpRoles($user);
        $this->setUpUsername($user);

        $user->setCreatedAt(new DateTime());
        $user->setUpdatedAt(new DateTime());
    }

    private function setUpPassword(User $user)
    {
        $passoword = $user->getPassword();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $passoword);
        $user->setPassword($hashedPassword);
    }

    private function setUpRoles(User $user)
    {
        if ($user->getType() === User::TYPE_SELLER) return $user->setRoles([User::ROLE_VENDOR]);
        if ($user->getType() === User::TYPE_BUYER) return $user->setRoles([User::ROLE_CLIENT]);
    }

    private function setUpUsername(User $user)
    {
        $userName = "{$user->getFirstName()}_{$user->getLastName()} ";
        $user->setUserName($userName);
    }
}
