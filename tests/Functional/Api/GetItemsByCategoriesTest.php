<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Tests\Functional\DatabaseTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Entity\User;
use App\Domain\Category\Entity\Category;
use App\Domain\Item\Entity\Item;

class GetItemsByCategoriesTest extends DatabaseTestCase
{
    public function testItemsCanBeFilteredByCategories(): void
    {
        $client = $this->client;

        $em = static::getContainer()->get(EntityManagerInterface::class);

        $user = new User(
            'user@test.com',
            password_hash('password123', PASSWORD_BCRYPT)
        );

        $em->persist($user);
        $em->flush();

        $category1 = new Category('Restaurants', $user->getId());
        $category2 = new Category('Events', $user->getId());

        $em->persist($category1);
        $em->persist($category2);
        $em->flush();

        $item1 = new Item(
            'Pizza Place',
            'Great pizza',
            $category1->getId(),
            52.52,
            13.405
        );

        $item2 = new Item(
            'Music Festival',
            'Outdoor event',
            $category2->getId(),
            48.85,
            2.35
        );

        $em->persist($item1);
        $em->persist($item2);
        $em->flush();

        $client->request(
            'GET',
            '/api/items?categories[]='.$category1->getId()->toRfc4122()
        );

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(1, $data);
        $this->assertSame('Pizza Place', $data[0]['name']);
    }
}
