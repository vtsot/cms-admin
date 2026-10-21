<?php

declare(strict_types=1);

namespace App\Entity\Traits\EmailTemplate;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SubjectEntityTrait
{
    #[ORM\Column(name: 'subject', type: Types::STRING, length: 255, nullable: true)]
    private ?string $subject = null;

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }
}
