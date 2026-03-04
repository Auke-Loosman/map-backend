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

    public function handle(?Uuid $categoryId): array
    {
        if ($categoryId === null) {
            return $this->repository->findAllItems();
        }

        return $this->repository->findItemsByCategory($categoryId);
    }
}
