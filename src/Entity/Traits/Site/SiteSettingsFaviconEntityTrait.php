<?php

declare(strict_types=1);

namespace App\Entity\Traits\Site;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

trait SiteSettingsFaviconEntityTrait
{
    #[ORM\Column(name: 'favicon', type: Types::STRING, length: 255, nullable: true)]
    private ?string $favicon = null;

    #[Vich\UploadableField(mapping: 'site', fileNameProperty: 'favicon')]
    private ?File $faviconFile = null;

    public function getFavicon(): ?string
    {
        return $this->favicon;
    }

    public function setFavicon(?string $favicon): static
    {
        $this->favicon = $favicon;

        return $this;
    }

    public function getFaviconFile(): ?File
    {
        return $this->faviconFile;
    }

    public function setFaviconFile(File|UploadedFile|null $faviconFile): static
    {
        $this->faviconFile = $faviconFile;
        $this->setUpdatedAt(new CarbonImmutable());

        return $this;
    }
}
