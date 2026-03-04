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

    public function findItemsByCategory(Uuid $categoryId, ?int $limit = null, ?string $sort = null): array
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(Item::class, 'i')
            ->where('i.categoryId = :category')
            ->setParameter('category', $categoryId, 'uuid');

        if ($sort !== null) {
            $qb->orderBy('i.' . $sort, 'ASC');
        }

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findAllItems(?int $limit = null, ?string $sort = null): array
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(Item::class, 'i');

        if ($sort !== null) {
            $qb->orderBy('i.' . $sort, 'ASC');
        }

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findItemsByCategories(array $categoryIds, ?int $limit = null, ?string $sort = null): array
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

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        if ($sort !== null) {
            $qb->orderBy('i.' . $sort, 'ASC');
        }

        return $qb->getQuery()->getResult();
    }

    public function findItemsInBoundingBox(
        float $minLat,
        float $minLng,
        float $maxLat,
        float $maxLng,
        ?int $limit = null,
        ?string $sort = null
    ): array {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(Item::class, 'i')
            ->where('i.latitude BETWEEN :minLat AND :maxLat')
            ->andWhere('i.longitude BETWEEN :minLng AND :maxLng')
            ->setParameter('minLat', $minLat)
            ->setParameter('maxLat', $maxLat)
            ->setParameter('minLng', $minLng)
            ->setParameter('maxLng', $maxLng);

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        if ($sort !== null) {
            $qb->orderBy('i.' . $sort, 'ASC');
        }

        return $qb->getQuery()->getResult();
    }

    public function findItemsByCategoriesAndBoundingBox(
        array $categoryIds,
        float $minLat,
        float $minLng,
        float $maxLat,
        float $maxLng,
        ?int $limit = null,
        ?string $sort = null
    ): array {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(Item::class, 'i')
            ->where('i.latitude BETWEEN :minLat AND :maxLat')
            ->andWhere('i.longitude BETWEEN :minLng AND :maxLng')
            ->setParameter('minLat', $minLat)
            ->setParameter('maxLat', $maxLat)
            ->setParameter('minLng', $minLng)
            ->setParameter('maxLng', $maxLng);

        if (count($categoryIds) === 1) {

            $qb->andWhere('i.categoryId = :category')
            ->setParameter('category', $categoryIds[0], 'uuid');

        } else {

            $qb->andWhere('i.categoryId IN (:categories)')
            ->setParameter('categories', $categoryIds, 'uuid');

        }

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        if ($sort !== null) {
            $qb->orderBy('i.' . $sort, 'ASC');
        }

        return $qb->getQuery()->getResult();
    }

    public function findItemsWithLimit(int $limit, ?string $sort = null): array
    {
        $qb = $this->entityManager
            ->createQueryBuilder()
            ->select('i')
            ->from(Item::class, 'i')
            ->setMaxResults($limit);


        if ($sort !== null) {
            $qb->orderBy('i.' . $sort, 'ASC');
        }

        return $qb->getQuery()->getResult();
    }
}
