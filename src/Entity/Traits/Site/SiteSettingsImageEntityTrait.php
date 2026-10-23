<?php

declare(strict_types=1);

namespace App\Entity\Traits\Site;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

trait SiteSettingsImageEntityTrait
{
    #[ORM\Column(name: 'image_title', type: Types::STRING, length: 255, nullable: true)]
    private ?string $imageTitle = null;

    #[ORM\Column(name: 'desktop_image', type: Types::STRING, length: 255, nullable: true)]
    private ?string $desktopImage = null;

    #[Vich\UploadableField(mapping: 'site', fileNameProperty: 'desktopImage')]
    private ?File $desktopImageFile = null;

    #[ORM\Column(name: 'mobile_image', type: Types::STRING, length: 255, nullable: true)]
    private ?string $mobileImage = null;

    #[Vich\UploadableField(mapping: 'site', fileNameProperty: 'mobileImage')]
    private ?File $mobileImageFile = null;

    // imageTitle getters/setters
    public function getImageTitle(): ?string
    {
        return $this->imageTitle;
    }

    public function setImageTitle(?string $imageTitle): static
    {
        $this->imageTitle = $imageTitle;

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
