<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contract\Dictionary\MailStatus;
use App\Entity\Site\Site;
use App\Repository\MailLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function sprintf;

#[ORM\Table(name: 'mail_logs')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Index(name: 'idx_recipient', columns: ['recipient'])]
#[ORM\Entity(repositoryClass: MailLogRepository::class)]
class MailLog extends AbstractEntity
{
    #[ORM\Column(name: 'message_id', type: Types::STRING, length: 255, nullable: true)]
    private ?string $messageId = null;

    #[ORM\Column(name: 'status', type: Types::STRING, length: 255, nullable: false, enumType: MailStatus::class)]
    private ?MailStatus $status = null;

    #[ORM\Column(name: 'debug', type: Types::TEXT, nullable: true)]
    private ?string $debug = null;

    #[ORM\Column(name: 'sender', type: Types::STRING, length: 255, nullable: true)]
    private ?string $sender = null;

    #[ORM\Column(name: 'reply_to', type: Types::STRING, length: 255, nullable: true)]
    private ?string $replyTo = null;

    #[ORM\Column(name: 'return_path', type: Types::STRING, length: 255, nullable: true)]
    private ?string $returnPath = null;

    #[ORM\Column(name: 'recipient', type: Types::STRING, length: 255, nullable: true)]
    private ?string $recipient = null;

    #[ORM\Column(name: 'cc', type: Types::STRING, length: 255, nullable: true)]
    private ?string $cc = null;

    #[ORM\Column(name: 'bcc', type: Types::STRING, length: 255, nullable: true)]
    private ?string $bcc = null;

    #[ORM\Column(name: 'subject', type: Types::STRING, length: 255, nullable: true)]
    private ?string $subject = null;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(name: 'html', type: Types::TEXT, nullable: true)]
    private ?string $html = null;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'mailLogs')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Site $site = null;

    public function setMessageId(?string $messageId): static
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function setStatus(?MailStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): ?MailStatus
    {
        return $this->status;
    }

    public function setDebug(?string $debug): static
    {
        $this->debug = $debug;

        return $this;
    }

    public function getDebug(): ?string
    {
        return $this->debug;
    }

    public function setSender(?string $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setReplyTo(?string $replyTo): static
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    public function setReturnPath(?string $returnPath): static
    {
        $this->returnPath = $returnPath;

        return $this;
    }

    public function getReturnPath(): ?string
    {
        return $this->returnPath;
    }

    public function setRecipient(?string $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setCc(?string $cc): static
    {
        $this->cc = $cc;

        return $this;
    }

    public function getCc(): ?string
    {
        return $this->cc;
    }

    public function setBcc(?string $bcc): static
    {
        $this->bcc = $bcc;

        return $this;
    }

    public function getBcc(): ?string
    {
        return $this->bcc;
    }

    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setHtml(?string $html): static
    {
        $this->html = $html;

        return $this;
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function __toString(): string
    {
        return $this->getSubject() ? sprintf('%s [%s]', $this->getSubject(), $this->createdAt->toRfc3339String()) : 'New Entity';
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): static
    {
        $this->site = $site;

        return $this;
    }
}
