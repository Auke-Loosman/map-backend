<?php

declare(strict_types=1);

namespace App\Application\Category;

use Symfony\Component\Uid\Uuid;

class UpdateCategoryCommand
{
    public function __construct(
        public string $categoryId,
        public ?string $name = null
    ) {}
}
