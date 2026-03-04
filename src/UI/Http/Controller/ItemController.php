<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

use App\Application\Item\CreateItemCommand;
use App\Application\Item\CreateItemHandler;
use App\Application\Item\GetItemsByCategoryHandler;

class ItemController
{
    public function __construct(
        private CreateItemHandler $createItemHandler,
        private GetItemsByCategoryHandler $getItemsHandler
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
        $categoryIds = $request->query->all('categories');

        $uuids = array_map(
            fn ($id) => \Symfony\Component\Uid\Uuid::fromString($id),
            $categoryIds
        );

        $bboxParam = $request->query->get('bbox');
        $bbox = null;

        if ($bboxParam) {
            $parts = explode(',', $bboxParam);

            if (count($parts) === 4) {
                $bbox = array_map('floatval', $parts);
            }
        }

        $limit = $request->query->get('limit');

        $limit = $limit !== null ? (int) $limit : null;

        $items = $this->getItemsHandler->handle($uuids, $bbox, $limit);

        $result = [];

        foreach ($items as $item) {
            $result[] = [
                'id' => $item->getId()->toRfc4122(),
                'name' => $item->getName(),
                'description' => $item->getDescription(),
                'latitude' => $item->getLatitude(),
                'longitude' => $item->getLongitude(),
                'categoryId' => $item->getCategoryId()->toRfc4122(),
            ];
        }

        return new JsonResponse($result);
    }
}
