<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Domain\Category\Entity\Category;
use App\Domain\Item\Entity\Item;
use App\Domain\User\Entity\User;
use App\Tests\Functional\DatabaseTestCase;
use Doctrine\ORM\EntityManagerInterface;

class GetItemsByBoundingBoxTest extends DatabaseTestCase
{
    public function testItemsCanBeFilteredByBoundingBox(): void
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

        $itemInside = new Item(
            'Pizza Place',
            'Great pizza',
            $category->getId(),
            52.52,
            13.405
        );

        $itemOutside = new Item(
            'Music Festival',
            'Outdoor event',
            $category->getId(),
            48.85,
            2.35
        );

        $em->persist($itemInside);
        $em->persist($itemOutside);
        $em->flush();

        $client->request(
            'GET',
            '/api/items?bbox=52,13,53,14'
        );

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(1, $data);
        $this->assertSame('Pizza Place', $data[0]['name']);
    }
}
