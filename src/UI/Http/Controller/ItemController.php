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
use App\UI\Http\Response\ItemResponseFactory;

class ItemController
{
    public function __construct(
        private CreateItemHandler $createItemHandler,
        private ItemQueryService $itemQueryService,
        private ItemResponseFactory $itemResponseFactory
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

        return new JsonResponse(
            $this->itemResponseFactory->create($item),
            201
        );
    }

    #[Route('/api/items', methods: ['GET'])]
    public function getItems(Request $request): JsonResponse
    {
        $result = $this->itemQueryService->getItems($request);

        if ($result instanceof ErrorResponse) {
            return $result;
        }

        return new JsonResponse(
            $this->itemResponseFactory->createCollection($result)
        );
    }
}
