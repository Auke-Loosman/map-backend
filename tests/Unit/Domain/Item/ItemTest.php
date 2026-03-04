<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Item;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use App\Domain\Item\Entity\Item;

class ItemTest extends TestCase
{
    public function testItemCreation(): void
    {
        $item = new Item(
            'Eiffel Tower',
            'Famous landmark',
            Uuid::v4(),
            null,
            null
        );

        $this->assertSame('Eiffel Tower', $item->getName());
        $this->assertSame('Famous landmark', $item->getDescription());
    }

    public function testItemWithCoordinates(): void
    {
        $item = new Item(
            'Restaurant',
            'Nice food',
            Uuid::v4(),
            48.8584,
            2.2945
        );

        $this->assertSame(48.8584, $item->getLatitude());
        $this->assertSame(2.2945, $item->getLongitude());
    }

    public function testInvalidNameThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Item('', 'desc', Uuid::v4(), null, null);
    }
}
