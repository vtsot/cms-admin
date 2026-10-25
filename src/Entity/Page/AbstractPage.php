<?php

declare(strict_types=1);

namespace App\Entity\Page;

use App\Contract\Dictionary\PageType;
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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

#[ORM\Table(name: 'pages')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'idx_homepage', columns: ['homepage'])]
#[ORM\UniqueConstraint(name: 'uniq_site_slug', columns: ['slug', 'site_id'])]
#[ORM\Entity(repositoryClass: AbstractPageRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'entity', type: Types::STRING)]
#[ORM\DiscriminatorMap([
    PageType::Page->value    => Page::class,
    PageType::Article->value => Article::class,
])]
#[Gedmo\TranslationEntity(class: PageTranslation::class)]
abstract class AbstractPage extends AbstractEntity implements SluggableInterface, SeoAwareInterface, Translatable
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

    /*
     * Translatable fields: redeclared from the traits above to add #[Gedmo\Translatable].
     * The attribute can't go on the traits themselves, they're shared with non-translatable entities.
     * Values for the default locale stay in `pages`, other locales go to `page_translations`.
     */

    #[Gedmo\Translatable]
    #[ORM\Column(name: 'title', type: Types::STRING, length: 255, nullable: true)]
    private ?string $title = null;

    #[Gedmo\Translatable]
    #[ORM\Column(name: 'content', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $content = null;

    #[Gedmo\Translatable]
    #[ORM\Column(name: 'meta_title', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $metaTitle = null;

    #[Gedmo\Translatable]
    #[ORM\Column(name: 'meta_keywords', type: Types::STRING, length: 1000, nullable: true)]
    protected ?string $metaKeywords = null;

    #[Gedmo\Translatable]
    #[ORM\Column(name: 'meta_description', type: Types::STRING, length: 1000, nullable: true)]
    protected ?string $metaDescription = null;

    #[Gedmo\Translatable]
    #[ORM\Column(name: 'og_title', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $ogTitle = null;

    #[Gedmo\Translatable]
    #[ORM\Column(name: 'og_description', type: Types::TEXT, nullable: true)]
    protected ?string $ogDescription = null;

    /**
     * Not mapped: holds the locale the translatable fields are loaded/saved in.
     * Protected, not private: Gedmo resolves it via the subclass (Page, Article) reflection.
     */
    #[Gedmo\Locale]
    protected ?string $locale = null;

    /**
     * @var Collection<int, PageTranslation>
     */
    #[ORM\OneToMany(targetEntity: PageTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $translations;

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

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return Collection<int, PageTranslation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(PageTranslation $translation): static
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(PageTranslation $translation): static
    {
        $this->translations->removeElement($translation);

        return $this;
    }

    public function isHomepage(): ?bool
    {
        return $this->homepage;
    }

    public function setHomepage(bool $homepage): static
    {
        $this->homepage = $homepage;

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
