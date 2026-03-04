<?php

declare(strict_types=1);

namespace App\Domain\Item\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'items')]
class Item
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'uuid')]
    private Uuid $categoryId;

    #[ORM\Column(nullable: true)]
    private ?float $latitude;

    #[ORM\Column(nullable: true)]
    private ?float $longitude;

    public function __construct(
        string $name,
        string $description,
        Uuid $categoryId,
        ?float $latitude,
        ?float $longitude
    ) {
        if (trim($name) === '') {
            throw new \InvalidArgumentException('Item name cannot be empty');
        }

        $this->id = Uuid::v4();
        $this->name = $name;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategoryId(): Uuid
    {
        return $this->categoryId;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
}
