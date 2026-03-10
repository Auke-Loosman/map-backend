<?php

declare(strict_types=1);

namespace App\Application\Category;

use Symfony\Component\Uid\Uuid;

class DeleteCategoryCommand
{
    public function __construct(
        public Uuid $categoryId
    ) {}
}
