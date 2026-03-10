<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'categories')]
class Category
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(type: 'string', length: 36)]
    private string $userId;

    public function __construct(string $name, string $userId)
    {
        $this->id = Uuid::v4()->toRfc4122();

        if (trim($name) === '') {
            throw new \InvalidArgumentException('Category name cannot be empty');
        }

        $this->name = $name;
        $this->userId = $userId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setName(string $name): void
    {
        if (trim($name) === '') {
            throw new \InvalidArgumentException('Category name cannot be empty');
        }

        $this->name = $name;
    }
}
