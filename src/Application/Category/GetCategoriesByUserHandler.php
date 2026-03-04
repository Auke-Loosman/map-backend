<?php

declare(strict_types=1);

namespace App\Application\Category;

use App\Domain\Category\Repository\CategoryRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class GetCategoriesByUserHandler
{
    public function __construct(
        private CategoryRepositoryInterface $repository
    ) {}

    public function handle(Uuid $userId): array
    {
        return $this->repository->findCategoriesByUserId($userId);
    }
}
