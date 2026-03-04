<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Category;

use PHPUnit\Framework\TestCase;
use App\Application\Category\CreateCategoryCommand;
use App\Application\Category\CreateCategoryHandler;
use App\Domain\Category\Repository\CategoryRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class CreateCategoryHandlerTest extends TestCase
{
    public function testCategoryIsCreated(): void
    {
        $repository = $this->createMock(CategoryRepositoryInterface::class);

        $repository
            ->expects($this->once())
            ->method('saveCategory');

        $handler = new CreateCategoryHandler($repository);

        $command = new CreateCategoryCommand(
            'Restaurants',
            Uuid::v4()
        );

        $category = $handler->handle($command);

        $this->assertSame('Restaurants', $category->getName());
    }
}
