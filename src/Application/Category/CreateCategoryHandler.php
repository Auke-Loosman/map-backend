<?php

declare(strict_types=1);

namespace App\Application\Category;

use App\Domain\Category\Entity\Category;
use App\Domain\Category\Repository\CategoryRepositoryInterface;

class CreateCategoryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {}

    public function handle(CreateCategoryCommand $command): Category
    {
        $category = new Category(
            $command->name,
            $command->userId
        );

        $this->repository->saveCategory($category);

        return $category;
    }
}
