<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\Functional\DatabaseTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Entity\User;
use App\Domain\Category\Entity\Category;
use App\Domain\Item\Entity\Item;

class GetItemsTest extends DatabaseTestCase
{
    public function testItemsAreReturned(): void
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

        $item = new Item(
            'Pizza Place',
            'Great pizza',
            $category->getId(),
            52.52,
            13.405
        );

        $em->persist($item);
        $em->flush();

        $client->request(
            'GET',
            '/api/items?categoryId='.$category->getId()->toRfc4122()
        );

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(1, $data);
        $this->assertSame('Pizza Place', $data[0]['name']);
    }
}
