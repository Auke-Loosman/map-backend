<?php

declare(strict_types=1);

namespace App\Application\Auth;

use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use App\Domain\User\Entity\User;

class LoginHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function handle(LoginCommand $command): User
    {
        $user = $this->userRepository->findUserByEmail($command->email);

        if (!$user) {
            throw new AuthenticationException('Invalid credentials');
        }

        if (!$this->passwordHasher->isPasswordValid($user, $command->password)) {
            throw new AuthenticationException('Invalid credentials');
        }

        return $user;
    }
}
