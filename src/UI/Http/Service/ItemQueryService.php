<?php

declare(strict_types=1);

namespace App\UI\Http\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;

use App\Application\Item\GetItemsByCategoryHandler;
use App\UI\Http\Response\ErrorResponse;

class ItemQueryService
{
    public function __construct(
        private GetItemsByCategoryHandler $handler
    ) {}

    public function getItems(Request $request): array|ErrorResponse
    {
        $categoryIds = $request->query->all('categories');

        $uuids = array_map(
            fn ($id) => Uuid::fromString($id),
            $categoryIds
        );

        $bboxParam = $request->query->get('bbox');
        $bbox = null;

        if ($bboxParam !== null) {

            $parts = explode(',', $bboxParam);

            if (count($parts) !== 4) {
                return new ErrorResponse(
                    'invalid_request',
                    'bbox must contain 4 values'
                );
            }

            $bbox = array_map('floatval', $parts);
        }

        $limit = $request->query->get('limit');

        if ($limit !== null) {

            $limit = (int) $limit;

            if ($limit < 1 || $limit > 100) {
                return new ErrorResponse(
                    'invalid_request',
                    'limit must be between 1 and 100'
                );
            }
        }

        $sort = $request->query->get('sort');

        return $this->handler->handle(
            $uuids,
            $bbox,
            $limit,
            $sort
        );
    }
}
