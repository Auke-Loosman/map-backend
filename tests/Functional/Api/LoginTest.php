<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\Functional\DatabaseTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Entity\User;

class LoginTest extends DatabaseTestCase
{
    public function testLoginWithValidCredentials(): void
    {
        $client = $this->client;

        $container = static::getContainer();
        $em = $container->get(EntityManagerInterface::class);

        $user = new User(
            'test@example.com',
            password_hash('password123', PASSWORD_BCRYPT)
        );

        $em->persist($user);
        $em->flush();

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
}
