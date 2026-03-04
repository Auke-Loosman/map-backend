<?php

declare(strict_types=1);

namespace App\Application\Item;

use App\Domain\Item\Entity\Item;
use App\Domain\Item\Repository\ItemRepositoryInterface;

class CreateItemHandler
{
    public function __construct(
        private ItemRepositoryInterface $repository
    ) {}

    public function handle(CreateItemCommand $command): Item
    {
        $item = new Item(
            $command->name,
            $command->description,
            $command->categoryId,
            $command->latitude,
            $command->longitude
        );

        $this->repository->saveItem($item);

        return $item;
    }
}
