<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait LinkActiveEntityTrait
{
    #[ORM\Column(name: 'link_active', type: Types::BOOLEAN, nullable: false, options: ['default' => true])]
    private bool $linkActive = true;

    public function isLinkActive(): bool
    {
        return $this->linkActive;
    }

    public function setLinkActive(bool $linkActive): static
    {
        $this->linkActive = $linkActive;

        return $this;
    }
}
