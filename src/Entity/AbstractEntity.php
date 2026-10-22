<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contract\Entity\EntityInterface;
use App\Entity\Traits\Timestampable\CreatedAtEntityTrait;
use App\Entity\Traits\Timestampable\UpdatedAtEntityTrait;
use Carbon\CarbonImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'uniq_id', columns: ['id'])]
#[ORM\Index(name: 'idx_created_at', columns: ['created_at'])]
#[ORM\Index(name: 'idx_updated_at', columns: ['updated_at'])]
abstract class AbstractEntity implements EntityInterface
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected ?Uuid $id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->setCreatedAt(new CarbonImmutable());
        $this->setUpdatedAt(new CarbonImmutable());
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->setUpdatedAt(new CarbonImmutable());
    }
}
