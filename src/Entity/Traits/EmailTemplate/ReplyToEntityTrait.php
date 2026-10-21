<?php

declare(strict_types=1);

namespace App\Entity\Traits\EmailTemplate;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ReplyToEntityTrait
{
    #[ORM\Column(name: 'reply_to', type: Types::STRING, length: 255, nullable: true)]
    private ?string $replyTo = null;

    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    public function setReplyTo(?string $replyTo): static
    {
        $this->replyTo = $replyTo;

        return $this;
    }
}
