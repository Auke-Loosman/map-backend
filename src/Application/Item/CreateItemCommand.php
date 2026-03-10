<?php

declare(strict_types=1);

namespace App\Application\Item;

class CreateItemCommand
{
    public function __construct(
        public string $name,
        public string $description,
        public string $categoryId,
        public ?float $latitude,
        public ?float $longitude,
        public array $metadata = []
    ) {}
}
