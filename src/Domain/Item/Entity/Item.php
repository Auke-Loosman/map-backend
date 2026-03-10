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
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string', length: 36)]
    private string $categoryId;

    #[ORM\Column(nullable: true)]
    private ?float $latitude;

    #[ORM\Column(nullable: true)]
    private ?float $longitude;

    public function __construct(
        string $name,
        string $description,
        string $categoryId,
        ?float $latitude,
        ?float $longitude
    ) {
        if (trim($name) === '') {
            throw new \InvalidArgumentException('Item name cannot be empty');
        }

        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getId(): string
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

    public function getCategoryId(): string
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

    public function setName(string $name): void
    {
        if (trim($name) === '') {
            throw new \InvalidArgumentException('Item name cannot be empty');
        }

        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }
}
