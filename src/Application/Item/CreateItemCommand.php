<?php

declare(strict_types=1);

namespace App\Application\Item;

use Symfony\Component\Uid\Uuid;

class CreateItemCommand
{
    public function __construct(
        public string $name,
        public string $description,
        public Uuid $categoryId,
        public ?float $latitude,
        public ?float $longitude,
        public array $metadata = []
    ) {}
}
