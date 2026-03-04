<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\Functional\DatabaseTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Entity\User;
use App\Domain\Category\Entity\Category;
use Symfony\Component\Uid\Uuid;

class GetCategoriesTest extends DatabaseTestCase
{
    public function testUserCategoriesAreReturned(): void
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
            'GET',
            '/api/categories?userId=' . $user->getId()->toRfc4122()
        );

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(1, $data);
        $this->assertSame('Restaurants', $data[0]['name']);
    }
}
