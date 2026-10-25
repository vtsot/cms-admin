<?php

declare(strict_types=1);

namespace App\Entity\Site;

use App\Contract\Entity\LinkEntityInterface;
use App\Entity\AbstractEntity;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\ImageAltEntityTrait;
use App\Entity\Traits\LinkEntityTrait;
use App\Entity\Traits\PriorityEntityTrait;
use App\Entity\Traits\TitleEntityTrait;
use App\Repository\Site\BannerRepository;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

use function array_filter;
use function implode;

#[ORM\Table(name: 'site_banners')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'fk_link_page', columns: ['link_page_id'])]
#[ORM\Index(name: 'fk_link_article_id', columns: ['link_article_id'])]
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: BannerRepository::class)]
#[Gedmo\TranslationEntity(class: BannerTranslation::class)]
class Banner extends AbstractEntity implements LinkEntityInterface, Translatable
{
    use ActiveEntityTrait;
    use TitleEntityTrait;
    use PriorityEntityTrait;
    use LinkEntityTrait;
    use ImageAltEntityTrait;

    /*
     * Translatable fields: redeclared from the traits above to add #[Gedmo\Translatable].
     * The attribute can't go on the traits themselves, they're shared with non-translatable entities.
     */

    #[Gedmo\Translatable]
    #[ORM\Column(name: 'title', type: Types::STRING, length: 255, nullable: true)]
    private ?string $title = null;

    #[Gedmo\Translatable]
    #[ORM\Column(name: 'image_alt', type: Types::STRING, length: 255, nullable: true)]
    private ?string $imageAlt = null;

    /**
     * Not mapped: holds the locale the translatable fields are loaded/saved in.
     */
    #[Gedmo\Locale]
    private ?string $locale = null;

    /**
     * @var Collection<int, BannerTranslation>
     */
    #[ORM\OneToMany(targetEntity: BannerTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $translations;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'banners')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    #[ORM\Column(name: 'desktop_image', type: Types::STRING, length: 255, nullable: true)]
    private ?string $desktopImage = null;

    #[Vich\UploadableField(mapping: 'banner', fileNameProperty: 'desktopImage')]
    private ?File $desktopImageFile = null;

    #[ORM\Column(name: 'mobile_image', type: Types::STRING, length: 255, nullable: true)]
    private ?string $mobileImage = null;

    #[Vich\UploadableField(mapping: 'banner', fileNameProperty: 'mobileImage')]
    private ?File $mobileImageFile = null;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getCreatedAt() === null ? 'New Entity' : null;
        $labels[] = $this->getTitle() ?? $this->getImageAlt();

        return implode(' ', array_filter($labels));
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
     * @return Collection<int, BannerTranslation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(BannerTranslation $translation): static
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(BannerTranslation $translation): static
    {
        $this->translations->removeElement($translation);

        return $this;
    }

    public function getDesktopImage(): ?string
    {
        return $this->desktopImage;
    }

    public function setDesktopImage(?string $desktopImage): static
    {
        $this->desktopImage = $desktopImage;

        return $this;
    }

    public function getDesktopImageFile(): ?File
    {
        return $this->desktopImageFile;
    }

    public function setDesktopImageFile(File|UploadedFile|null $desktopImageFile): static
    {
        $this->desktopImageFile = $desktopImageFile;
        $this->setUpdatedAt(new CarbonImmutable());

        return $this;
    }

    public function getMobileImage(): ?string
    {
        return $this->mobileImage;
    }

    public function setMobileImage(?string $mobileImage): static
    {
        $this->mobileImage = $mobileImage;

        return $this;
    }

    public function getMobileImageFile(): ?File
    {
        return $this->mobileImageFile;
    }

    public function setMobileImageFile(File|UploadedFile|null $mobileImageFile): static
    {
        $this->mobileImageFile = $mobileImageFile;
        $this->setUpdatedAt(new CarbonImmutable());

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
