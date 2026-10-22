<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait CodeBlockEntityTrait
{
    #[ORM\Column(name: 'code_block', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $codeBlock = null;

    public function getCodeBlock(): ?string
    {
        return $this->codeBlock;
    }

    public function setCodeBlock(?string $codeBlock): static
    {
        $this->codeBlock = $codeBlock;

        return $this;
    }
}
