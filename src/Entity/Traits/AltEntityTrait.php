<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait AltEntityTrait
{
    #[ORM\Column(name: 'alt', type: Types::STRING, length: 255, nullable: true)]
    private ?string $alt = null;

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }
}
