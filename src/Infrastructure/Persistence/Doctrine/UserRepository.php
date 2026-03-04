<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Entity\User;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function saveUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }

    public function findUserById(int $id): ?User
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->find($id);
    }
}
