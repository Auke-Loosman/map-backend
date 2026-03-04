<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\Functional\DatabaseTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Entity\User;
use App\Domain\Category\Entity\Category;

class CreateItemTest extends DatabaseTestCase
{
    public function testItemCanBeCreated(): void
    {
        $client = $this->client;

        $em = static::getContainer()->get(EntityManagerInterface::class);

        $user = new User(
            'user@test.com',
            password_hash('password123', PASSWORD_BCRYPT)
        );

        $em->persist($user);
        $em->flush();

        $category = new Category(
            'Restaurants',
            $user->getId()
        );

        $em->persist($category);
        $em->flush();

        $client->request(
            'POST',
            '/api/items',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'name' => 'Pizza Place',
                'description' => 'Great pizza',
                'categoryId' => $category->getId()->toRfc4122(),
                'latitude' => 52.52,
                'longitude' => 13.405
            ])
        );

        $this->assertResponseStatusCodeSame(201);
    }
}
