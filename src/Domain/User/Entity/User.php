<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

class User
{
    private string $email;
    private string $password;
    private string $role;

    public function __construct(
        string $email,
        string $password,
        string $role = 'ROLE_USER'
    ) {
        if (empty($email)) {
            throw new \InvalidArgumentException('Email cannot be empty');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format');
        }

        if (empty($password)) {
            throw new \InvalidArgumentException('Password cannot be empty');
        }

        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
