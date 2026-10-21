<?php

declare(strict_types=1);

namespace App\Entity\Traits\Site;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SiteDomainRegistrationTrait
{
    #[ORM\Column(name: 'registrar_email', type: Types::STRING, length: 255, nullable: true)]
    private ?string $registrarEmail = null;

    #[ORM\Column(name: 'registrar_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $registrarName = null;

    #[ORM\Column(name: 'registered_at', type: Types::DATETIME_IMMUTABLE, precision: 6, nullable: true)]
    private ?CarbonImmutable $registeredAt = null;

    #[ORM\Column(name: 'expire_at', type: Types::DATETIME_IMMUTABLE, precision: 6, nullable: true)]
    private ?CarbonImmutable $expireAt = null;

    public function getRegistrarEmail(): ?string
    {
        return $this->registrarEmail;
    }

    public function setRegistrarEmail(?string $registrarEmail): static
    {
        $this->registrarEmail = $registrarEmail;

        return $this;
    }

    public function getRegistrarName(): ?string
    {
        return $this->registrarName;
    }

    public function setRegistrarName(?string $registrarName): static
    {
        $this->registrarName = $registrarName;

        return $this;
    }

    public function getRegisteredAt(): ?CarbonImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(?CarbonImmutable $registeredAt): static
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getExpireAt(): ?CarbonImmutable
    {
        return $this->expireAt;
    }

    public function setExpireAt(?CarbonImmutable $expireAt): static
    {
        $this->expireAt = $expireAt;

        return $this;
    }
}
