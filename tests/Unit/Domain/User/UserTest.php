<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\User;

use PHPUnit\Framework\TestCase;
use App\Domain\User\Entity\User;
use PHPUnit\Framework\Attributes\DataProvider;

class UserTest extends TestCase
{
    #[DataProvider('provideValidUsers')]
    public function testUserCreationSuccess(
        string $email,
        string $password
    ): void {
        $user = new User($email, $password);

        $this->assertEquals($email, $user->getEmail());
    }

    #[DataProvider('provideInvalidEmails')]
    public function testInvalidEmailThrowsException(
        string $email
    ): void {
        $this->expectException(\InvalidArgumentException::class);

        new User($email, 'password123');
    }

    public static function provideValidUsers(): \Generator
    {
        yield 'valid email' => [
            'test@example.com',
            'password123'
        ];
    }

    public static function provideInvalidEmails(): \Generator
    {
        yield 'empty email' => [''];
        yield 'invalid email format' => ['invalid-email'];
        yield 'missing domain' => ['test@'];
    }
}
