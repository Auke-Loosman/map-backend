<?php

declare(strict_types=1);

namespace App\Application\Item;

use App\Domain\Item\Entity\ItemMetadata;
use App\Domain\Item\Repository\ItemRepositoryInterface;
use App\Domain\Item\Repository\ItemMetadataRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UpdateItemHandler
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
        private ItemMetadataRepositoryInterface $metadataRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function handle(UpdateItemCommand $command): void
    {
        $item = $this->itemRepository->find($command->itemId);

        if (!$item) {
            throw new \RuntimeException('Item not found');
        }

        if ($command->name !== null) {
            $item->setName($command->name);
        }

        if ($command->description !== null) {
            $item->setDescription($command->description);
        }

        if ($command->categoryId !== null) {
            $item->setCategoryId($command->categoryId);
        }

        if ($command->latitude !== null) {
            $item->setLatitude($command->latitude);
        }

        if ($command->longitude !== null) {
            $item->setLongitude($command->longitude);
        }

        if ($command->metadata !== null) {

            $existing = $this->metadataRepository->findByItemId($command->itemId);

            foreach ($existing as $m) {
                $this->entityManager->remove($m);
            }

            foreach ($command->metadata as $key => $value) {
                $meta = new ItemMetadata(
                    $command->itemId,
                    $key,
                    (string)$value
                );

                $this->entityManager->persist($meta);
            }
        }

        $this->entityManager->flush();
    }
}
