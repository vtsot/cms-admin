<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait RedirectEntityTrait
{
    #[ORM\Column(name: 'redirect', type: Types::STRING, length: 255, nullable: true)]
    private ?string $redirect = null;

    public function getRedirect(): ?string
    {
        return $this->redirect;
    }

    public function setRedirect(?string $redirect): static
    {
        $this->redirect = $redirect;

        return $this;
    }
}
