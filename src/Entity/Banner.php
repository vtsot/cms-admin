<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contract\Entity\LinkEntityInterface;
use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\AltEntityTrait;
use App\Entity\Traits\LinkEntityTrait;
use App\Entity\Traits\NameEntityTrait;
use App\Entity\Traits\PriorityEntityTrait;
use App\Repository\BannerRepository;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

use function array_filter;
use function implode;

#[ORM\Table(name: 'banners')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'fk_link_page', columns: ['link_page_id'])]
#[ORM\Index(name: 'fk_link_article_id', columns: ['link_article_id'])]
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: BannerRepository::class)]
class Banner extends AbstractEntity implements LinkEntityInterface
{
    use ActiveEntityTrait;
    use NameEntityTrait;
    use PriorityEntityTrait;
    use LinkEntityTrait;
    use AltEntityTrait;

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

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getCreatedAt() === null ? 'New Entity' : null;
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

    // desktop image getters/setters
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

    // mobile image getters/setters
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
}
