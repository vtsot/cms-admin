<?php

declare(strict_types=1);

namespace App\Entity\Traits\User;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait UserPasswordEntityTrait
{
    private ?string $plainPassword = null;

    #[ORM\Column(name: 'password', type: Types::STRING, length: 255, nullable: true)]
    private ?string $password = null;

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
