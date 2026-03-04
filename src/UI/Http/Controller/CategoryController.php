<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

use App\Application\Category\CreateCategoryCommand;
use App\Application\Category\CreateCategoryHandler;
use App\Application\Category\GetCategoriesByUserHandler;

class CategoryController
{
    public function __construct(
        private CreateCategoryHandler $createCategoryHandler,
        private GetCategoriesByUserHandler $getCategoriesHandler
    ) {}

    #[Route('/api/categories', methods: ['POST'])]
    public function createCategory(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new CreateCategoryCommand(
            $data['name'],
            Uuid::fromString($data['userId'])
        );

        $category = $this->createCategoryHandler->handle($command);

        return new JsonResponse([
            'id' => $category->getId()->toRfc4122(),
            'name' => $category->getName()
        ], 201);
    }

    #[Route('/api/categories', methods: ['GET'])]
    public function getCategories(Request $request): JsonResponse
    {
        $userId = $request->query->get('userId');

        $categories = $this->getCategoriesHandler
            ->handle(Uuid::fromString($userId));

        $data = array_map(function ($category) {
            return [
                'id' => $category->getId()->toRfc4122(),
                'name' => $category->getName()
            ];
        }, $categories);

        return new JsonResponse($data);
    }
}
