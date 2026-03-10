<?php

declare(strict_types=1);

namespace App\Application\Auth;

class RegisterCommand
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
