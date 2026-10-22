<?php

declare(strict_types=1);

namespace App\Entity\Page;

use App\Contract\Entity\SeoAwareInterface;
use App\Contract\Entity\SluggableInterface;
use App\Entity\AbstractEntity;
use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\CodeBlockEntityTrait;
use App\Entity\Traits\ContentEntityTrait;
use App\Entity\Traits\RedirectEntityTrait;
use App\Entity\Traits\SeoAwareEntityTrait;
use App\Entity\Traits\SitemapEntityTrait;
use App\Entity\Traits\SluggableEntityTrait;
use App\Entity\Traits\SourcesEntityTrait;
use App\Entity\Traits\TitleEntityTrait;
use App\Repository\Page\AbstractPageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'pages')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'idx_homepage', columns: ['homepage'])]
#[ORM\UniqueConstraint(name: 'uniq_site_slug', columns: ['slug', 'site_id'])]
#[ORM\Entity(repositoryClass: AbstractPageRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'entity', type: Types::STRING)]
#[ORM\DiscriminatorMap([
    'page'    => Page::class,
    'article' => Article::class,
])]
abstract class AbstractPage extends AbstractEntity implements SluggableInterface, SeoAwareInterface
{
    use ActiveEntityTrait;
    use TitleEntityTrait;
    use ContentEntityTrait;
    use SluggableEntityTrait;
    use SeoAwareEntityTrait;
    use SitemapEntityTrait;
    use RedirectEntityTrait;
    use CodeBlockEntityTrait;
    use SourcesEntityTrait;

    #[ORM\Column(name: 'homepage', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $homepage = false;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'pages')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getCreatedAt() === null ? 'New Entity' : null;
        // $labels[] = $this->getSite()?->getDomain();
        $labels[] = $this->getTitle();

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

    public function isHomepage(): bool
    {
        return $this->homepage;
    }

    public function setHomepage(bool $homepage): static
    {
        $this->homepage = $homepage;

        return $this;
    }
}
