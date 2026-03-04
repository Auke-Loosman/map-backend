<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Item\Entity\Item;
use App\Domain\Item\Repository\ItemRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class ItemRepository implements ItemRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function saveItem(Item $item): void
    {
        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }

    public function findItemsByCategory(Uuid $categoryId): array
    {
        return $this->entityManager
            ->getRepository(Item::class)
            ->findBy(['categoryId' => $categoryId]);
    }

    public function findAllItems(): array
    {
        return $this->entityManager
            ->getRepository(Item::class)
            ->findAll();
    }

    public function findItemsByCategories(array $categoryIds): array
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(Item::class, 'i');

        if (count($categoryIds) === 1) {
            $qb->where('i.categoryId = :category')
            ->setParameter('category', $categoryIds[0], 'uuid');
        } else {
            $qb->where('i.categoryId IN (:categories)')
            ->setParameter('categories', $categoryIds, 'uuid');
        }
        return $qb->getQuery()->getResult();
    }
}
