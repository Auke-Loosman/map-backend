<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

use App\Application\Item\CreateItemCommand;
use App\Application\Item\CreateItemHandler;
use App\UI\Http\Service\ItemQueryService;
use App\UI\Http\Response\ErrorResponse;

class ItemController
{
    public function __construct(
        private CreateItemHandler $createItemHandler,
        private ItemQueryService $itemQueryService
    ) {}

    #[Route('/api/items', methods: ['POST'])]
    public function createItem(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new CreateItemCommand(
            $data['name'],
            $data['description'],
            Uuid::fromString($data['categoryId']),
            $data['latitude'] ?? null,
            $data['longitude'] ?? null,
            $data['metadata'] ?? []
        );

        $item = $this->createItemHandler->handle($command);

        return new JsonResponse([
            'id' => $item->getId()->toRfc4122(),
            'name' => $item->getName()
        ], 201);
    }

    #[Route('/api/items', methods: ['GET'])]
    public function getItems(Request $request): JsonResponse
    {
        $result = $this->itemQueryService->getItems($request);

        if ($result instanceof ErrorResponse) {
            return $result;
        }

        $items = [];

        foreach ($result as $item) {
            $items[] = [
                'id' => $item->getId()->toRfc4122(),
                'name' => $item->getName(),
                'description' => $item->getDescription(),
                'latitude' => $item->getLatitude(),
                'longitude' => $item->getLongitude(),
                'categoryId' => $item->getCategoryId()->toRfc4122(),
            ];
        }

        return new JsonResponse($items);
    }
}
