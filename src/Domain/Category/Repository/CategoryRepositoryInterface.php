<?php

declare(strict_types=1);

namespace App\Domain\Category\Repository;

use App\Domain\Category\Entity\Category;
use Symfony\Component\Uid\Uuid;

interface CategoryRepositoryInterface
{
    public function saveCategory(Category $category): void;

    public function findCategoryById(Uuid $id): ?Category;

    public function findCategoriesByUserId(Uuid $userId): array;
}
