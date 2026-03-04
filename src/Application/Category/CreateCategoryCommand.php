<?php

declare(strict_types=1);

namespace App\Application\Category;

use Symfony\Component\Uid\Uuid;

class CreateCategoryCommand
{
    public function __construct(
        public string $name,
        public Uuid $userId
    ) {}
}
