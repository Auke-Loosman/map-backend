<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLoginWithValidCredentials(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@example.com',
                'password' => 'password123'
            ])
        );

        $this->assertResponseIsSuccessful();
    }

    public function testLoginFailsWithInvalidPassword(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ])
        );

        $this->assertResponseStatusCodeSame(401);
    }
}
