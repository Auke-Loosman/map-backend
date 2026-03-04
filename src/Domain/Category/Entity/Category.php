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
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(type: 'uuid')]
    private Uuid $userId;

    public function __construct(string $name, Uuid $userId)
    {
        $this->id = Uuid::v4();

        if (trim($name) === '') {
            throw new \InvalidArgumentException('Category name cannot be empty');
        }

        $this->name = $name;
        $this->userId = $userId;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): Uuid
    {
        return $this->userId;
    }
}
