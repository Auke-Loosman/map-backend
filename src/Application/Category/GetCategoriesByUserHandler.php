<?php

declare(strict_types=1);

namespace App\Application\Category;

use App\Domain\Category\Repository\CategoryRepositoryInterface;

class GetCategoriesByUserHandler
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {}

    public function handle(string $userId): array
    {
        return $this->repository->findCategoriesByUserId($userId);
    }
}
