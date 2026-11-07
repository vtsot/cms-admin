<?php

declare(strict_types=1);

namespace App\Entity\Site;

use App\Entity\AbstractEntity;
use App\Repository\Site\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function array_filter;
use function implode;

#[ORM\Table(name: 'site_contacts')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact extends AbstractEntity
{
    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'banners')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    #[ORM\Column(name: 'context', type: Types::JSON, nullable: true)]
    private ?array $context = null;

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getCreatedAt() === null ? 'New Entity' : null;

        return implode(' ', array_filter($labels));
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

    public function getContext(): ?array
    {
        return $this->context;
    }

    public function setContext(?array $context): static
    {
        $this->context = $context;

        return $this;
    }
}
