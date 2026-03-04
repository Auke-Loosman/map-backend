<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\Functional\DatabaseTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Entity\User;

class CreateCategoryTest extends DatabaseTestCase
{
    public function testCategoryCanBeCreated(): void
    {
        $client = $this->client;

        $em = static::getContainer()->get(EntityManagerInterface::class);

        $user = new User(
            'user@test.com',
            password_hash('password123', PASSWORD_BCRYPT)
        );

        $em->persist($user);
        $em->flush();

        $client->request(
            'POST',
            '/api/categories',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Restaurants',
                'userId' => $user->getId()->toRfc4122()
            ])
        );

        $this->assertResponseStatusCodeSame(201);
    }
}
