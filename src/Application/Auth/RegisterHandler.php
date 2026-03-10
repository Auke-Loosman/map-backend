<?php

declare(strict_types=1);

namespace App\Application\Auth;

use App\Domain\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class RegisterHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function handle(RegisterCommand $command): User
    {
        $hashedPassword = password_hash(
            $command->password,
            PASSWORD_BCRYPT
        );

        $user = new User(
            $command->email,
            $hashedPassword
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
