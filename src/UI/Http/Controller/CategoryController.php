<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

use App\Application\Category\CreateCategoryCommand;
use App\Application\Category\CreateCategoryHandler;

class CategoryController
{
    public function __construct(
        private CreateCategoryHandler $handler
    ) {}

    #[Route('/api/categories', methods: ['POST'])]
    public function createCategory(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new CreateCategoryCommand(
            $data['name'],
            Uuid::fromString($data['userId'])
        );

        $category = $this->handler->handle($command);

        return new JsonResponse([
            'id' => $category->getId()->toRfc4122(),
            'name' => $category->getName()
        ], 201);
    }
}
