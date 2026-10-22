<?php

declare(strict_types=1);

namespace App\Entity\Traits\Timestampable;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtEntityTrait
{
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE, precision: 6, nullable: true)]
    protected ?CarbonImmutable $createdAt = null;

    public function getCreatedAt(): ?CarbonImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?CarbonImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
