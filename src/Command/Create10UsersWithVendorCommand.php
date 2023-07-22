<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\UserCustomer;
use App\Entity\Vendor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-10-users-with-vendor',
    description: 'Add a short description for your command',
)]
class Create10UsersWithVendorCommand extends Command
{
    protected function configure(): void
    {
        $this;
    }

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManagerInterface
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $users = [
            [
                'email' => 'ray.sin@fake.com',
                'firstName' => 'Ray',
                'lastName' => 'fake',
            ],
            [
                'email' => 'johnquil@fake.com',
                'firstName' => 'John',
                'lastName' => 'fake',
            ],
            [
                'email' => 'annethurium134@fake.com',
                'firstName' => 'Anne',
                'lastName' => 'fake',
            ],
            [
                'email' => 'perryscope@fake.com',
                'firstName' => 'Perry',
                'lastName' => 'fake',
            ],
            [
                'email' => 'percykewshun@fake.com',
                'firstName' => 'Percy',
                'lastName' => 'fake',
            ],
            [
                'email' => 'rhoda.report@fake.com',
                'firstName' => 'Rhoda',
                'lastName' => 'fake',
            ],
            [
                'email' => 'hope@fake.com',
                'firstName' => 'Hope',
                'lastName' => 'fake',
            ],
            [
                'email' => 'anne@fake.com',
                'firstName' => 'Anne',
                'lastName' => 'fake',
            ],
            [
                'email' => 'isabelle@fake.com',
                'firstName' => 'Isabelle',
                'lastName' => 'fake',
            ],
            [
                'email' => 'eileen@fake.com',
                'firstName' => 'Eileen',
                'lastName' => 'fake',
            ],
        ];
        $passowrd = 'vv';

        foreach ($users as  $user) {
            $userEntity = new User();
            $userEntity->setFirstName($user['firstName']);
            $userEntity->setLastName($user['lastName']);
            $userEntity->setEmail($user['email']);
            $userEntity->setBecomeVendor(true);
            $userEntity->setRoles([User::ROLE_VENDOR]);

            $hashedPassword = $this->passwordHasher->hashPassword($userEntity, $passowrd);
            $userEntity->setPassword($hashedPassword);

            $this->createUserCustomer($userEntity);
            $this->createVendor($userEntity);

            $this->entityManagerInterface->persist($userEntity);
        }

        $this->entityManagerInterface->flush();

        $io->success('Users & Vendors created successfully!!!');

        return Command::SUCCESS;
    }

    private function createUserCustomer(User $user): void
    {
        $userCustomer = new UserCustomer();
        $userCustomer->setUser($user);

        $user->setUserCustomer($userCustomer);
    }

    private function createVendor(User $user): void
    {
        $vendor = new Vendor();
        $vendor->setUser($user);
        $vendor->setName("{$user->getFirstName()}'s Business");
        $vendor->setEmail($user->getEmail());
        $vendor->setPhoneNumber('1234567890');
        $vendor->setAddress('15 Yemen Road');
        $vendor->setPostalCode('K2YU3H');
        $vendor->setCity('Yemen');
        $vendor->setProvince('Yemen');

        $user->setVendor($vendor);
    }
}
