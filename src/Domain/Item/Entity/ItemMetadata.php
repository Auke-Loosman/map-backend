<?php

declare(strict_types=1);

namespace App\Domain\Item\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'item_metadata')]
class ItemMetadata
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $id;

    #[ORM\Column(type: 'string', length: 36)]
    private string $itemId;

    #[ORM\Column]
    private string $key;

    #[ORM\Column(type: 'text')]
    private string $value;

    public function __construct(
        string $itemId,
        string $key,
        string $value
    ) {
        if (trim($key) === '') {
            throw new \InvalidArgumentException('Metadata key cannot be empty');
        }

        $this->id = Uuid::v4()->toRfc4122();
        $this->itemId = $itemId;
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }
}
