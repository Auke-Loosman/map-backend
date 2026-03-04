<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Category\Entity\Category;
use App\Domain\Category\Repository\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function saveCategory(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function findCategoryById(Uuid $id): ?Category
    {
        return $this->entityManager
            ->getRepository(Category::class)
            ->find($id);
    }

    public function findCategoriesByUserId(Uuid $userId): array
    {
        return $this->entityManager
            ->getRepository(Category::class)
            ->findBy(['userId' => $userId]);
    }
}
