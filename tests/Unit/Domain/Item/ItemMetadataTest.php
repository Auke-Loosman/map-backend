<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Item;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use App\Domain\Item\Entity\ItemMetadata;

class ItemMetadataTest extends TestCase
{
    public function testMetadataCreation(): void
    {
        $metadata = new ItemMetadata(
            Uuid::v4(),
            'website',
            'https://example.com'
        );

        $this->assertSame('website', $metadata->getKey());
        $this->assertSame('https://example.com', $metadata->getValue());
    }

    public function testEmptyKeyThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new ItemMetadata(
            Uuid::v4(),
            '',
            'value'
        );
    }
}
