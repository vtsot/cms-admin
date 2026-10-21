<?php

declare(strict_types=1);

namespace App\Entity\Site;

use App\Entity\AbstractEntity;
use App\Entity\Traits\CodeEntityTrait;
use App\Entity\Traits\TitleEntityTrait;
use App\Repository\Site\SiteThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'site_themes')]
#[ORM\UniqueConstraint(name: 'uniq_code', columns: ['code'])]
#[ORM\Entity(repositoryClass: SiteThemeRepository::class)]
class SiteTheme extends AbstractEntity
{
    use TitleEntityTrait;
    use CodeEntityTrait;

    public const THEME_BLUE                = 'blue';
    public const THEME_BLUE_AND_YELLOW     = 'blue-and-yellow';
    public const THEME_BLUE_DARK_AND_LIGHT = 'blue-dark-and-light';
    public const THEME_BLUE_LIGHT          = 'blue-light';
    public const THEME_GREEN_LIGHT         = 'green-light';
    public const THEME_REVIEW              = 'review';
    public const THEME_SILVER_LIGHT        = 'silver-light';
    public const THEME_SIMPLE_BLACK        = 'simple-black';

    #[ORM\OneToMany(targetEntity: Site::class, mappedBy: 'siteTheme', orphanRemoval: true)]
    private Collection $sites;

    public function __construct()
    {
        parent::__construct();

        $this->sites = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getTitle() ?? $this->getCode() ?? 'New entity';
    }

    /**
     * @return Collection<int, Site>
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): static
    {
        if (!$this->sites->contains($site)) {
            $this->sites->add($site);
            $site->setSiteTheme($this);
        }

        return $this;
    }

    public function removeSite(Site $site): static
    {
        if ($this->sites->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getSiteTheme() === $this) {
                $site->setSiteTheme(null);
            }
        }

        return $this;
    }
}
