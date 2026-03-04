<?php

declare(strict_types=1);

namespace App\Application\Item;

use App\Domain\Item\Repository\ItemRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class GetItemsByCategoryHandler
{
    public function __construct(
        private ItemRepositoryInterface $repository
    ) {}

    public function handle(
        array $categoryIds = [],
        ?array $bbox = null,
        ?int $limit = null,
        ?string $sort = null
    ): array {

        if ($bbox && !empty($categoryIds)) {

            $items = $this->repository->findItemsByCategoriesAndBoundingBox(
                $categoryIds,
                $bbox[0],
                $bbox[1],
                $bbox[2],
                $bbox[3],
                $limit,
                $sort
            );

        } elseif ($bbox) {

            $items = $this->repository->findItemsInBoundingBox(
                $bbox[0],
                $bbox[1],
                $bbox[2],
                $bbox[3],
                $limit,
                $sort
            );

        } elseif (!empty($categoryIds)) {

            $items = $this->repository->findItemsByCategories($categoryIds, $limit, $sort);

        } else {

            $items = $this->repository->findAllItems($limit, $sort);
        }

        if ($limit !== null) {
            return array_slice($items, 0, $limit);
        }

        return $items;
    }
}
