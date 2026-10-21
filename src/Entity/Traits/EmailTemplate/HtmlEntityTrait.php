<?php

declare(strict_types=1);

namespace App\Entity\Traits\EmailTemplate;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait HtmlEntityTrait
{
    #[ORM\Column(name: 'html', type: Types::TEXT, nullable: true)]
    private ?string $html = null;

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(?string $html): static
    {
        $this->html = $html;

        return $this;
    }
}
