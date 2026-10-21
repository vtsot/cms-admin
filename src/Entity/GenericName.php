<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Site\Site;
use App\Entity\Traits\NameEntityTrait;
use App\Repository\GenericNameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use function array_filter;
use function implode;

#[ORM\Table(name: 'generic_names')]
#[ORM\UniqueConstraint(name: 'uniq_name', columns: ['name'])]
#[ORM\Entity(repositoryClass: GenericNameRepository::class)]
class GenericName extends AbstractEntity
{
    use NameEntityTrait;

    #[ORM\ManyToMany(targetEntity: Site::class, inversedBy: 'genericNames')]
    #[ORM\JoinTable(name: 'generic_name_sites')]
    #[ORM\JoinColumn(name: 'generic_name_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'site_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $sites;

    public function __construct()
    {
        parent::__construct();
        $this->sites = new ArrayCollection();
    }

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getId() === null ? 'New Entity' : null;
        $labels[] = $this->getName();

        return implode(' ', array_filter($labels));
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
        }

        return $this;
    }

    public function removeSite(Site $site): static
    {
        $this->sites->removeElement($site);

        return $this;
    }
}
