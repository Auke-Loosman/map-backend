<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use App\Domain\Category\Entity\Category;
use App\Domain\Item\Entity\Item;
use App\Domain\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Tests\Functional\DatabaseTestCase;

class GetItemsLimitTest extends DatabaseTestCase
{
    public function testItemsCanBeLimited(): void
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

        for ($i = 0; $i < 5; $i++) {

            $item = new Item(
                'Item '.$i,
                'Test item',
                $category->getId(),
                52.52,
                13.405
            );

            $em->persist($item);
        }

        $em->flush();

        $client->request(
            'GET',
            '/api/items?limit=2'
        );

        $this->assertResponseIsSuccessful();

        $data = json_decode(
            $client->getResponse()->getContent(),
            true
        );

        $this->assertCount(2, $data);
    }
}
