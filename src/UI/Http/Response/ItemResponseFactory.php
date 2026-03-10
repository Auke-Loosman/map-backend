<?php

declare(strict_types=1);

namespace App\UI\Http\Response;

use App\Domain\Item\Entity\Item;

class ItemResponseFactory
{
    public function create(Item $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'description' => $item->getDescription(),
            'latitude' => $item->getLatitude(),
            'longitude' => $item->getLongitude(),
            'categoryId' => $item->getCategoryId(),

        ];
    }

    public function createCollection(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $result[] = $this->create($item);
        }

        return $result;
    }
}
