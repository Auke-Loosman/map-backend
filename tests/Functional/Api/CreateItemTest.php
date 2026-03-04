<?php

declare(strict_types=1);

namespace App\Tests\Functional\Api;

use PHPUnit\Framework\Attributes\DataProvider;
use App\Tests\Functional\DatabaseTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\User\Entity\User;
use App\Domain\Category\Entity\Category;
use App\Domain\Item\Entity\ItemMetadata;

class CreateItemTest extends DatabaseTestCase
{
    #[DataProvider('itemCreationProvider')]
    public function testItemCanBeCreated(array $payload, int $expectedMetadataCount): void
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

        $payload['categoryId'] = $category->getId()->toRfc4122();

        $client->request(
            'POST',
            '/api/items',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );

        $this->assertResponseStatusCodeSame(201);

        // Clear EM so we read fresh data
        $em->clear();

        $metadataEntries = $em
            ->getRepository(ItemMetadata::class)
            ->findAll();

        $this->assertCount($expectedMetadataCount, $metadataEntries);
    }

    public static function itemCreationProvider(): array
    {
        return [

            'restaurant with metadata' => [
                [
                    'name' => 'Pizza Place',
                    'description' => 'Great pizza',
                    'latitude' => 52.52,
                    'longitude' => 13.405,
                    'metadata' => [
                        'website' => 'https://pizza.com',
                        'opening_hours' => '10:00-23:00'
                    ]
                ],
                2
            ],

            'event item metadata' => [
                [
                    'name' => 'Music Festival',
                    'description' => 'Outdoor event',
                    'latitude' => 48.85,
                    'longitude' => 2.35,
                    'metadata' => [
                        'event_date' => '2026-08-01'
                    ]
                ],
                1
            ],

            'item without metadata' => [
                [
                    'name' => 'Simple Place',
                    'description' => 'No metadata',
                    'latitude' => 50.0,
                    'longitude' => 8.0
                ],
                0
            ]
        ];
    }
}
