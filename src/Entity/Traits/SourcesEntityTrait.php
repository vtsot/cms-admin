<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SourcesEntityTrait
{
    #[ORM\Column(name: 'sources', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $sources = null;

    public function getSources(): ?string
    {
        return $this->sources;
    }

    public function setSources(?string $sources): static
    {
        $this->sources = $sources;

        return $this;
    }
}
