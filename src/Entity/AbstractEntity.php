<?php

declare(strict_types=1);

namespace App\Entity;

// use App\Contract\Entity\EntityInterface;
use App\Contract\Entity\EntityInterface;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\UuidInterface;

use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

use function method_exists;
use function property_exists;
use function ucfirst;

#[ORM\MappedSuperclass]
#[ORM\Index(name: 'idx_created_at', columns: ['created_at'])]
#[ORM\Index(name: 'idx_updated_at', columns: ['updated_at'])]
abstract class AbstractEntity implements EntityInterface
{
//    #[ORM\Id()]
//    #[ORM\Column(name: 'id', type: 'uuid', unique: true)]
//    protected ?UuidInterface $id = null;


    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected ?Uuid $id;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE, precision: 6, nullable: true)]
    protected ?CarbonImmutable $createdAt;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE, precision: 6, nullable: true)]
    protected ?CarbonImmutable $updatedAt;

    //    public function __construct()
    //    {
    //        $this->id = Uuid::uuid7();
    //    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setCreatedAt(CarbonImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): ?CarbonImmutable
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(CarbonImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?CarbonImmutable
    {
        return $this->updatedAt;
    }

    public static function create(array $data): static
    {
        $self = new static();
        $self->processAutoSet($data, $self);

        return $self;
    }

    public function update(array $data): static
    {
        $this->processAutoSet($data, $this);

        return $this;
    }

    protected function processAutoSet(array $data, object $instance): void
    {
        foreach ($data as $key => $item) {
            if (method_exists($instance, 'set' . ucfirst($key))) {
                $instance->{'set' . ucfirst($key)}($item);
            } elseif (property_exists($instance, $key)) {
                $instance->$key = $item;
            }
        }
    }
}
