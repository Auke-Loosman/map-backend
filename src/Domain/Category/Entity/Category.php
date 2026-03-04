<?php

declare(strict_types=1);

namespace App\Domain\Category\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'categories')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private int $userId;

    public function __construct(string $name, int $userId)
    {
        if (trim($name) === '') {
            throw new \InvalidArgumentException('Category name cannot be empty');
        }

        $this->name = $name;
        $this->userId = $userId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
