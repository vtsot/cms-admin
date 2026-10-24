<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Contract\Dictionary\PageSitemapChangeFrequency;
use App\Contract\Dictionary\PageSitemapPriority;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SitemapEntityTrait
{
    #[ORM\Column(name: 'is_indexed', type: Types::BOOLEAN, nullable: false, options: ['default' => true])]
    protected bool $indexed = true;

    #[ORM\Column(name: 'sitemap_change_frequency', type: Types::STRING, length: 255, options: ['default' => PageSitemapChangeFrequency::DEFAULT])]
    protected string $sitemapChangeFrequency = PageSitemapChangeFrequency::DEFAULT;

    #[ORM\Column(name: 'sitemap_priority', type: Types::FLOAT, options: ['default' => PageSitemapPriority::DEFAULT])]
    protected float $sitemapPriority = PageSitemapPriority::DEFAULT;

    public function getIndexed(): bool
    {
        return $this->indexed;
    }

    public function isIndexed(): bool
    {
        return $this->indexed;
    }

    public function setIndexed(bool $indexed): static
    {
        $this->indexed = $indexed;

        return $this;
    }

    public function getSitemapChangeFrequency(): ?string
    {
        return $this->sitemapChangeFrequency;
    }

    public function setSitemapChangeFrequency(string $sitemapChangeFrequency): static
    {
        $this->sitemapChangeFrequency = $sitemapChangeFrequency;

        return $this;
    }

    public function getSitemapPriority(): ?float
    {
        return $this->sitemapPriority;
    }

    public function setSitemapPriority(float $sitemapPriority): static
    {
        $this->sitemapPriority = $sitemapPriority;

        return $this;
    }
}
