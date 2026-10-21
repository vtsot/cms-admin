<?php

declare(strict_types=1);

namespace App\Entity\Traits\Site;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SiteSettingsFromEntityTrait
{
    #[ORM\Column(name: 'from_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $fromName = null;

    #[ORM\Column(name: 'from_email', type: Types::STRING, length: 255, nullable: true)]
    private ?string $fromEmail = null;

    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    public function setFromName(?string $fromName): static
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getFromEmail(): ?string
    {
        return $this->fromEmail;
    }

    public function setFromEmail(?string $fromEmail): static
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }
}
