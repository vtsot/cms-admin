<?php

declare(strict_types=1);

namespace App\Entity\Traits\User;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function implode;
use function trim;

trait UserNameEntityTrait
{
    #[ORM\Column(name: 'first_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(name: 'last_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $lastName = null;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): ?string
    {
        return trim(implode(' ', [$this->firstName, $this->lastName])) ?: null;
    }
}
