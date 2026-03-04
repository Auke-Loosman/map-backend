<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Domain\Category\Entity\Category;
use App\Domain\Item\Entity\Item;
use App\Domain\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Tests\Functional\DatabaseTestCase;

class GetItemsSortingTest extends DatabaseTestCase
{
    public function testItemsCanBeSortedByName(): void
    {
        $client = $this->client;

        $em = static::getContainer()->get(EntityManagerInterface::class);

        $user = new User(
            'user@test.com',
            password_hash('password123', PASSWORD_BCRYPT)
        );

        $em->persist($user);
        $em->flush();

        $category = new Category('Restaurants', $user->getId());
        $em->persist($category);
        $em->flush();

        $itemA = new Item(
            'Burger Place',
            'Great burgers',
            $category->getId(),
            52.52,
            13.405
        );

        $itemB = new Item(
            'Apple Cafe',
            'Nice cafe',
            $category->getId(),
            52.52,
            13.405
        );

        $em->persist($itemA);
        $em->persist($itemB);
        $em->flush();

        $client->request(
            'GET',
            '/api/items?sort=name'
        );

        $this->assertResponseIsSuccessful();

        $data = json_decode(
            $client->getResponse()->getContent(),
            true
        );

        $this->assertSame('Apple Cafe', $data[0]['name']);
        $this->assertSame('Burger Place', $data[1]['name']);
    }
}
