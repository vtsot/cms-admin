<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contract\Entity\LinkEntityInterface;
use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\AltEntityTrait;
use App\Entity\Traits\ContentEntityTrait;
use App\Entity\Traits\LinkEntityTrait;
use App\Entity\Traits\PositionEntityTrait;
use App\Entity\Traits\TitleEntityTrait;
use App\Repository\GalleryImageRepository;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Table(name: 'gallery_images')]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'fk_link_page', columns: ['link_page_id'])]
#[ORM\Index(name: 'fk_link_article', columns: ['link_article_id'])]
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: GalleryImageRepository::class)]
class GalleryImage extends AbstractEntity implements LinkEntityInterface
{
    use ActiveEntityTrait;
    use TitleEntityTrait;
    use PositionEntityTrait;
    use ContentEntityTrait;
    use LinkEntityTrait;
    use AltEntityTrait;

    #[ORM\Column(name: 'image', type: Types::STRING, length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'gallery', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(name: 'color', type: Types::STRING, length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(name: 'shape', type: Types::STRING, length: 255, nullable: true)]
    private ?string $shape = null;

    #[ORM\Column(name: 'imprint', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $imprint = null;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'galleryImages')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(File|UploadedFile|null $imageFile): self
    {
        $this->imageFile = $imageFile;
        $this->setUpdatedAt(new CarbonImmutable());

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getShape(): ?string
    {
        return $this->shape;
    }

    public function setShape(?string $shape): self
    {
        $this->shape = $shape;

        return $this;
    }

    public function getImprint(): ?string
    {
        return $this->imprint;
    }

    public function setImprint(?string $imprint): self
    {
        $this->imprint = $imprint;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?: 'New entity';
    }
}
