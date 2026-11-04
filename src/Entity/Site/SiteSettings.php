<?php

declare(strict_types=1);

namespace App\Entity\Site;

use App\Entity\AbstractEntity;
use App\Entity\Traits\Site\SiteSettingsApiLogActiveEntityTrait;
use App\Entity\Traits\Site\SiteSettingsFaviconEntityTrait;
use App\Entity\Traits\Site\SiteSettingsFromEntityTrait;
use App\Entity\Traits\Site\SiteSettingsImageEntityTrait;
use App\Entity\Traits\Site\SiteSettingsSenderEntityTrait;
use App\Repository\Site\SiteSettingsRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

use function array_filter;
use function implode;

#[ORM\Table(name: 'site_settings')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: SiteSettingsRepository::class)]
class SiteSettings extends AbstractEntity
{
    use SiteSettingsFaviconEntityTrait;
    use SiteSettingsImageEntityTrait;
    use SiteSettingsSenderEntityTrait;
    use SiteSettingsFromEntityTrait;
    use SiteSettingsApiLogActiveEntityTrait;

    #[ORM\OneToOne(targetEntity: Site::class, inversedBy: 'settings')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?Site $site = null;

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getId() === null ? 'New Entity' : null;
        $labels[] = 'Settings';
        $labels[] = $this->getSite()?->getDomain();

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
