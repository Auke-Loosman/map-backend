<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Entity\User;

interface UserRepositoryInterface
{
    public function saveUser(User $user): void;

    public function findUserByEmail(string $email): ?User;

    public function findUserById(Uuid $id): ?User;
}
