<?php

declare(strict_types=1);

namespace App\Entity\Traits\Site;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SiteSettingsSenderEntityTrait
{
    #[ORM\Column(name: 'sender_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $senderName = null;

    #[ORM\Column(name: 'sender_email', type: Types::STRING, length: 255, nullable: true)]
    private ?string $senderEmail = null;

    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    public function setSenderName(?string $senderName): static
    {
        $this->senderName = $senderName;

        return $this;
    }

    public function getSenderEmail(): ?string
    {
        return $this->senderEmail;
    }

    public function setSenderEmail(?string $senderEmail): static
    {
        $this->senderEmail = $senderEmail;

        return $this;
    }
}
