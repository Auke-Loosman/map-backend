<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Item\Entity\ItemMetadata;
use App\Domain\Item\Repository\ItemMetadataRepositoryInterface;

class ItemMetadataRepository implements ItemMetadataRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function saveItemMetadata(ItemMetadata $metadata): void
    {
        $this->entityManager->persist($metadata);
        $this->entityManager->flush();
    }
}
