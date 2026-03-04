<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\Functional\DatabaseTestCase;

class GetItemsValidationTest extends DatabaseTestCase
{
    public function testInvalidLimitReturnsBadRequest(): void
    {
        $client = $this->client;

        $client->request(
            'GET',
            '/api/items?limit=500'
        );

        $this->assertResponseStatusCodeSame(400);
    }

    public function testInvalidBoundingBoxReturnsBadRequest(): void
    {
        $client = $this->client;

        $client->request(
            'GET',
            '/api/items?bbox=1,2,3'
        );

        $this->assertResponseStatusCodeSame(400);
    }
}
