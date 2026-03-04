<?php

declare(strict_types=1);

namespace App\Domain\Item\Repository;

use App\Domain\Item\Entity\Item;
use Symfony\Component\Uid\Uuid;

interface ItemRepositoryInterface
{
    public function saveItem(Item $item): void;

    public function findItemsByCategory(Uuid $categoryId): array;
}
