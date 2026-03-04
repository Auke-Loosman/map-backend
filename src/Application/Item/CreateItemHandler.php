<?php

declare(strict_types=1);

namespace App\Application\Item;

use App\Domain\Item\Entity\Item;
use App\Domain\Item\Repository\ItemRepositoryInterface;
use App\Domain\Item\Repository\ItemMetadataRepositoryInterface;
use App\Domain\Item\Entity\ItemMetadata;

class CreateItemHandler
{
    public function __construct(
        private ItemRepositoryInterface $repository,
        private ItemMetadataRepositoryInterface $metadataRepository
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
