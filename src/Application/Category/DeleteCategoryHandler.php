<?php

declare(strict_types=1);

namespace App\Application\Category;

use App\Domain\Category\Repository\CategoryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCategoryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function handle(DeleteCategoryCommand $command): void
    {
        $category = $this->categoryRepository->find($command->categoryId);

        if (!$category) {
            throw new \RuntimeException('Category not found');
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }
}
