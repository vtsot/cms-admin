<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Site\Site;
use App\Entity\Traits\EmailEntityTrait;
use App\Entity\Traits\MessageEntityTrait;
use App\Entity\Traits\NameEntityTrait;
use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

use function array_filter;
use function implode;

#[ORM\Table(name: 'contacts')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact extends AbstractEntity
{
    use NameEntityTrait;
    use EmailEntityTrait;
    use MessageEntityTrait;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'contacts')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getId() === null ? 'New Entity' : null;
        $labels[] = $this->getName();

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
}
