<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin-user',
    description: 'Add a short description for your command',
)]
class CreateAdminUserCommand extends Command
{


    public function __construct(private EntityManagerInterface $entityManager, private  UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'email')
            ->addArgument('password', InputArgument::REQUIRED, 'password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user = new User();
        $user->setEmail($email);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);

        $user->setPassword($hashedPassword);
        $user->setRoles([User::ROLE_ADMIN]);
        $user->setFirstName('Joy');
        $user->setLastName('Chudasama');
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success("New Admin User Created");

        return Command::SUCCESS;
    }
}
