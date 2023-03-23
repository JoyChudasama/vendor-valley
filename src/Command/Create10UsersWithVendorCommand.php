<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\Vendor;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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

    public function __construct(private UserPasswordHasherInterface $passwordHasher, private UserRepository $userRepository)
    {
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
        $passowrd = 'password';

        foreach ($users as  $user) {
            $userEntity = new User();
            $userEntity->setFirstName($user['firstName']);
            $userEntity->setLastName($user['lastName']);
            $userEntity->setUserName($user['firstName']  . '_' . $user['lastName']);
            $userEntity->setEmail($user['email']);
            $userEntity->setCreatedAt(new DateTime());
            $userEntity->setUpdatedAt(new DateTime());
            $userEntity->setCreatedBy('ADMIN');
            $userEntity->setBecomeVendor(true);

            $hashedPassword = $this->passwordHasher->hashPassword($userEntity, $passowrd);
            $userEntity->setPassword($hashedPassword);

            $this->createVendor($userEntity);
            $this->userRepository->save($userEntity, true);
        }

        $io->success('Users & Vendors created successfully!!!');


        return Command::SUCCESS;
    }

    private function createVendor(User $user){
        $vendor = new Vendor();
        $vendor->setUser($user);
        $vendor->setName("{$user->getFirstName()}'s Business");
        $vendor->setDescription('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');

        $user->addVendor($vendor);
    }
}
