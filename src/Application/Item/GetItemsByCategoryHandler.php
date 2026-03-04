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
        ?array $bbox = null
    ): array {

        if ($bbox) {
            return $this->repository->findItemsInBoundingBox(
                $bbox[0],
                $bbox[1],
                $bbox[2],
                $bbox[3]
            );
        }

        if (empty($categoryIds)) {
            return $this->repository->findAllItems();
        }

        return $this->repository->findItemsByCategories($categoryIds);
    }
}
