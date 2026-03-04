<?php

declare(strict_types=1);

namespace App\UI\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorResponse extends JsonResponse
{
    public function __construct(
        string $code,
        string $message,
        int $status = 400
    ) {
        parent::__construct([
            'error' => [
                'code' => $code,
                'message' => $message
            ]
        ], $status);
    }
}
