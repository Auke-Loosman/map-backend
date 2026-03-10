<?php

declare(strict_types=1);

namespace App\Application\Category;

use App\Domain\Category\Repository\CategoryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UpdateCategoryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function handle(UpdateCategoryCommand $command): void
    {
        $category = $this->categoryRepository->find($command->categoryId);

        if (!$category) {
            throw new \RuntimeException('Category not found');
        }

        if ($command->name !== null) {
            $category->setName($command->name);
        }

        $this->entityManager->flush();
    }
}
