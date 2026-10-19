<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait LinkTitleEntityTrait
{
    #[ORM\Column(name: 'link_title', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $linkTitle = null;

    public function getLinkTitle(): ?string
    {
        return $this->linkTitle;
    }

    public function setLinkTitle(?string $linkTitle): static
    {
        $this->linkTitle = $linkTitle;

        return $this;
    }
}
