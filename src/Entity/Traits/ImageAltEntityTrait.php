<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ImageAltEntityTrait
{
    #[ORM\Column(name: 'image_alt', type: Types::STRING, length: 255, nullable: true)]
    private ?string $imageAlt = null;

    public function getImageAlt(): ?string
    {
        return $this->imageAlt;
    }

    public function setImageAlt(?string $imageAlt): static
    {
        $this->imageAlt = $imageAlt;

        return $this;
    }
}
