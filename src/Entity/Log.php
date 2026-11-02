<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Site\Site;
use App\Repository\LogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function array_filter;
use function implode;

#[ORM\Table(name: 'logs')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log extends AbstractEntity
{
    #[ORM\ManyToOne(targetEntity: Site::class)]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    #[ORM\Column(name: 'message', type: Types::STRING, length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(name: 'method', type: Types::STRING, length: 255, nullable: true)]
    private ?string $method = null;

    #[ORM\Column(name: 'url', type: Types::STRING, length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(name: 'request', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $request = null;

    #[ORM\Column(name: 'response', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $response = null;

    #[ORM\Column(name: 'content', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(name: 'entry_id', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $entryId = null;

    #[ORM\Column(name: 'payload', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $payload = null;

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = !$this->getId() ? 'New Entity' : null;
        $labels[] = $this->message;
        $labels[] = $this->method;
        $labels[] = $this->url;

        return implode(' ', array_filter($labels));
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(?string $method): static
    {
        $this->method = $method;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getRequest(): ?string
    {
        return $this->request;
    }

    public function setRequest(?string $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(?string $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getEntryId(): ?string
    {
        return $this->entryId;
    }

    public function setEntryId(?string $entryId): static
    {
        $this->entryId = $entryId;

        return $this;
    }

    public function getPayload(): ?string
    {
        return $this->payload;
    }

    public function setPayload(?string $payload): static
    {
        $this->payload = $payload;

        return $this;
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
