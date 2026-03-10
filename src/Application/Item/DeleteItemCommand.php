<?php

declare(strict_types=1);

namespace App\Application\Item;

use Symfony\Component\Uid\Uuid;

class DeleteItemCommand
{
    public function __construct(
        public Uuid $itemId
    ) {}
}
