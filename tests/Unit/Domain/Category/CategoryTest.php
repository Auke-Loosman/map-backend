<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Category;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Domain\Category\Entity\Category;

class CategoryTest extends TestCase
{
    public function testCategoryCreation(): void
    {
        $category = new Category('Restaurants', 1);

        $this->assertSame('Restaurants', $category->getName());
        $this->assertSame(1, $category->getUserId());
    }

    #[DataProvider('invalidNames')]
    public function testInvalidCategoryName(string $name): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Category($name, 1);
    }

    public static function invalidNames(): \Generator
    {
        yield 'empty name' => [''];
        yield 'spaces only' => ['   '];
    }
}
