<?php

declare(strict_types=1);

namespace App\Domain\Item\Repository;

use App\Domain\Item\Entity\ItemMetadata;

interface ItemMetadataRepositoryInterface
{
    public function saveItemMetadata(ItemMetadata $metadata): void;
}
