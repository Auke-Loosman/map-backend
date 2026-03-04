<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\Functional\DatabaseTestCase;

class ErrorResponseTest extends DatabaseTestCase
{
    public function testErrorResponseHasStandardStructure(): void
    {
        $client = $this->client;

        $client->request(
            'GET',
            '/api/items?limit=999'
        );

        $this->assertResponseStatusCodeSame(400);

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('error', $data);
        $this->assertArrayHasKey('code', $data['error']);
        $this->assertArrayHasKey('message', $data['error']);
    }
}
