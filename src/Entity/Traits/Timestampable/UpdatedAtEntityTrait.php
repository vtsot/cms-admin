<?php

declare(strict_types=1);

namespace App\Entity\Traits\Timestampable;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait UpdatedAtEntityTrait
{
    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE, precision: 6, nullable: true)]
    protected ?CarbonImmutable $updatedAt = null;

    public function getUpdatedAt(): ?CarbonImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?CarbonImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
