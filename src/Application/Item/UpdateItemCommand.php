<?php

declare(strict_types=1);

namespace App\Application\Item;

use Symfony\Component\Uid\Uuid;

class UpdateItemCommand
{
    public function __construct(
        public string $itemId,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $categoryId = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public ?array $metadata = null
    ) {}
}
