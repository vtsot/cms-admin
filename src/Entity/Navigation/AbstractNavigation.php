<?php

declare(strict_types=1);

namespace App\Entity\Navigation;

use App\Contract\Dictionary\NavigationType;
use App\Contract\Entity\LinkEntityInterface;
use App\Entity\AbstractEntity;
use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\LinkEntityTrait;
use App\Entity\Traits\PositionEntityTrait;
use App\Entity\Traits\TitleEntityTrait;
use App\Repository\Navigation\NavigationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'navigations')]
#[ORM\Index(name: 'idx_parent_id', columns: ['parent_id'])]
#[ORM\Index(name: 'fk_link_page', columns: ['link_page_id'])]
#[ORM\Index(name: 'fk_link_article', columns: ['link_article_id'])]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'entity', type: Types::STRING)]
#[ORM\DiscriminatorMap([
    'main' => MainNavigation::class,
])]
#[ORM\Entity(repositoryClass: NavigationRepository::class)]
abstract class AbstractNavigation extends AbstractEntity implements LinkEntityInterface
{
    use ActiveEntityTrait;
    use TitleEntityTrait;
    use LinkEntityTrait;
    use PositionEntityTrait;

    #[ORM\Column(name: 'type', type: Types::STRING, length: 255, nullable: true, enumType: NavigationType::class, options: ['default' => NavigationType::Main->value])]
    private ?NavigationType $type = NavigationType::Main;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?AbstractNavigation $parent = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $children;

    #[ORM\ManyToOne(targetEntity: Site::class)]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getTitle() ?: 'New entity';
    }

    public function getType(): ?NavigationType
    {
        return $this->type;
    }

    public function setType(?NavigationType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, AbstractNavigation>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(AbstractNavigation $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(AbstractNavigation $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

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
