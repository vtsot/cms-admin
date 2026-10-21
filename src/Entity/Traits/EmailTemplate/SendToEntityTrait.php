<?php

declare(strict_types=1);

namespace App\Entity\Traits\EmailTemplate;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SendToEntityTrait
{
    #[ORM\Column(name: 'send_to', type: Types::STRING, length: 255, nullable: true)]
    private ?string $sendTo = null;

    public function getSendTo(): ?string
    {
        return $this->sendTo;
    }

    public function setSendTo(?string $sendTo): static
    {
        $this->sendTo = $sendTo;

        return $this;
    }
}
