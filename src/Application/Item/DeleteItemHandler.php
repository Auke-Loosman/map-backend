<?php

declare(strict_types=1);

namespace App\Application\Item;

use App\Domain\Item\Repository\ItemRepositoryInterface;
use App\Domain\Item\Repository\ItemMetadataRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DeleteItemHandler
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
        private ItemMetadataRepositoryInterface $metadataRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function handle(DeleteItemCommand $command): void
    {
        $item = $this->itemRepository->find($command->itemId);

        if (!$item) {
            throw new \RuntimeException('Item not found');
        }

        $metadata = $this->metadataRepository->findByItemId($command->itemId);

        foreach ($metadata as $m) {
            $this->entityManager->remove($m);
        }

        $this->entityManager->remove($item);

        $this->entityManager->flush();
    }
}
