<?php

declare(strict_types=1);

namespace App\Domain\Category\Repository;

use App\Domain\Category\Entity\Category;

interface CategoryRepositoryInterface
{
    public function saveCategory(Category $category): void;

    public function findCategoryById(int $id): ?Category;

    public function findCategoriesByUserId(int $userId): array;
}
