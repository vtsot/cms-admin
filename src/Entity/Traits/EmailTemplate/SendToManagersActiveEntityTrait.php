<?php

declare(strict_types=1);

namespace App\Entity\Traits\EmailTemplate;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SendToManagersActiveEntityTrait
{
    #[ORM\Column(name: 'send_to_managers_active', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $sendToManagersActive = false;

    public function isSendToManagersActive(): bool
    {
        return $this->sendToManagersActive;
    }

    public function setSendToManagersActive(bool $sendToManagersActive): static
    {
        $this->sendToManagersActive = $sendToManagersActive;

        return $this;
    }
}
