<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SeoAwareEntityTrait
{
    #[ORM\Column(name: 'meta_title', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $metaTitle = null;

    #[ORM\Column(name: 'meta_keywords', type: Types::STRING, length: 1000, nullable: true)]
    protected ?string $metaKeywords = null;

    #[ORM\Column(name: 'meta_description', type: Types::STRING, length: 1000, nullable: true)]
    protected ?string $metaDescription = null;

    #[ORM\Column(name: 'og_title', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $ogTitle = null;

    #[ORM\Column(name: 'og_description', type: Types::TEXT, nullable: true)]
    protected ?string $ogDescription = null;

    #[ORM\Column(name: 'og_image', type: Types::TEXT, nullable: true)]
    protected ?string $ogImage = null;

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(?string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(?string $metaKeywords): self
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getOgTitle(): ?string
    {
        return $this->ogTitle;
    }

    public function setOgTitle(?string $ogTitle): self
    {
        $this->ogTitle = $ogTitle;

        return $this;
    }

    public function getOgDescription(): ?string
    {
        return $this->ogDescription;
    }

    public function setOgDescription(?string $ogDescription): self
    {
        $this->ogDescription = $ogDescription;

        return $this;
    }

    public function getOgImage(): ?string
    {
        return $this->ogImage;
    }

    public function setOgImage(?string $ogImage): self
    {
        $this->ogImage = $ogImage;

        return $this;
    }
}
