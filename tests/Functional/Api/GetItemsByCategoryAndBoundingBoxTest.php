<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Domain\User\Entity\User;
use App\Domain\Category\Entity\Category;
use App\Domain\Item\Entity\Item;
use App\Tests\Functional\DatabaseTestCase;
use Doctrine\ORM\EntityManagerInterface;

class GetItemsByCategoryAndBoundingBoxTest extends DatabaseTestCase
{
    public function testItemsCanBeFilteredByCategoryAndBoundingBox(): void
    {
        $client = $this->client;

        $em = static::getContainer()->get(EntityManagerInterface::class);

        $user = new User(
            'user@test.com',
            password_hash('password123', PASSWORD_BCRYPT)
        );

        $em->persist($user);
        $em->flush();

        $food = new Category('Food', $user->getId());
        $events = new Category('Events', $user->getId());

        $em->persist($food);
        $em->persist($events);
        $em->flush();

        $pizza = new Item(
            'Pizza Place',
            'Great pizza',
            $food->getId(),
            52.52,
            13.405
        );

        $concert = new Item(
            'Berlin Concert',
            'Music event',
            $events->getId(),
            52.51,
            13.40
        );

        $parisFood = new Item(
            'Paris Bistro',
            'French food',
            $food->getId(),
            48.85,
            2.35
        );

        $em->persist($pizza);
        $em->persist($concert);
        $em->persist($parisFood);
        $em->flush();

        $client->request(
            'GET',
            '/api/items?categories[]=' . $food->getId()->toRfc4122() . '&bbox=52,13,53,14'
        );

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(1, $data);
        $this->assertSame('Pizza Place', $data[0]['name']);
    }
}
