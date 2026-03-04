<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Auth;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Application\Auth\LoginHandler;
use App\Application\Auth\LoginCommand;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginHandlerTest extends TestCase
{
    private UserRepositoryInterface $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
    }

    public function testLoginSucceedsWithValidCredentials(): void
    {
        $user = new User('test@example.com', 'hashedPassword');

        $this->userRepository
            ->method('findUserByEmail')
            ->willReturn($user);

        $this->passwordHasher
            ->method('isPasswordValid')
            ->willReturn(true);

        $handler = new LoginHandler(
            $this->userRepository,
            $this->passwordHasher
        );

        $command = new LoginCommand(
            'test@example.com',
            'password123'
        );

        $result = $handler->handle($command);

        $this->assertInstanceOf(User::class, $result);
    }

    public function testLoginFailsWhenUserDoesNotExist(): void
    {
        $this->expectException(AuthenticationException::class);

        $this->userRepository
            ->method('findUserByEmail')
            ->willReturn(null);

        $handler = new LoginHandler(
            $this->userRepository,
            $this->passwordHasher
        );

        $command = new LoginCommand(
            'unknown@example.com',
            'password'
        );

        $handler->handle($command);
    }

    public function testLoginFailsWhenPasswordIsInvalid(): void
    {
        $this->expectException(AuthenticationException::class);

        $user = new User('test@example.com', 'hashedPassword');

        $this->userRepository
            ->method('findUserByEmail')
            ->willReturn($user);

        $this->passwordHasher
            ->method('isPasswordValid')
            ->willReturn(false);

        $handler = new LoginHandler(
            $this->userRepository,
            $this->passwordHasher
        );

        $command = new LoginCommand(
            'test@example.com',
            'wrongpassword'
        );

        $handler->handle($command);
    }
}
