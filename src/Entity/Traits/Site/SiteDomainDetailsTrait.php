<?php

declare(strict_types=1);

namespace App\Entity\Traits\Site;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SiteDomainDetailsTrait
{
    #[ORM\Column(name: 'archive_birth_year', type: Types::INTEGER, nullable: true, options: ['unsigned' => true])]
    private ?int $archiveBirthYear = null;

    #[ORM\Column(name: 'global_search_volume', type: Types::FLOAT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private float $globalSearchVolume = 0;

    #[ORM\Column(name: 'us_search_volume', type: Types::FLOAT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private float $usSearchVolume = 0;

    #[ORM\Column(name: 'moz_spam', type: Types::FLOAT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private float $mozSpam = 0;

    #[ORM\Column(name: 'ahrefs_domain_rating', type: Types::FLOAT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private float $ahrefsDomainRating = 0;

    #[ORM\Column(name: 'ahrefs_back_links', type: Types::FLOAT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private float $ahrefsBackLinks = 0;

    #[ORM\Column(name: 'ahrefs_ref_domains', type: Types::FLOAT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private float $ahrefsRefDomains = 0;

    #[ORM\Column(name: 'semrush_authority_score', type: Types::FLOAT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private float $semrushAuthorityScore = 0;

    #[ORM\Column(name: 'semrush_back_links', type: Types::FLOAT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private float $semrushBackLinks = 0;

    #[ORM\Column(name: 'semrush_ref_domains', type: Types::FLOAT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private float $semrushRefDomains = 0;

    #[ORM\Column(name: 'wikipedia_link', type: Types::STRING, length: 255, nullable: true)]
    private ?string $wikipediaLink = null;

    #[ORM\Column(name: 'is_penalty', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $isPenalty = false;

    public function getArchiveBirthYear(): ?int
    {
        return $this->archiveBirthYear;
    }

    public function setArchiveBirthYear(?int $archiveBirthYear): static
    {
        $this->archiveBirthYear = $archiveBirthYear;

        return $this;
    }

    public function getGlobalSearchVolume(): float
    {
        return $this->globalSearchVolume;
    }

    public function setGlobalSearchVolume(float $globalSearchVolume): static
    {
        $this->globalSearchVolume = $globalSearchVolume;

        return $this;
    }

    public function getUsSearchVolume(): float
    {
        return $this->usSearchVolume;
    }

    public function setUsSearchVolume(float $usSearchVolume): static
    {
        $this->usSearchVolume = $usSearchVolume;

        return $this;
    }

    public function getMozSpam(): float
    {
        return $this->mozSpam;
    }

    public function setMozSpam(float $mozSpam): static
    {
        $this->mozSpam = $mozSpam;

        return $this;
    }

    public function getAhrefsDomainRating(): float
    {
        return $this->ahrefsDomainRating;
    }

    public function setAhrefsDomainRating(float $ahrefsDomainRating): static
    {
        $this->ahrefsDomainRating = $ahrefsDomainRating;

        return $this;
    }

    public function getAhrefsBackLinks(): float
    {
        return $this->ahrefsBackLinks;
    }

    public function setAhrefsBackLinks(float $ahrefsBackLinks): static
    {
        $this->ahrefsBackLinks = $ahrefsBackLinks;

        return $this;
    }

    public function getAhrefsRefDomains(): float
    {
        return $this->ahrefsRefDomains;
    }

    public function setAhrefsRefDomains(float $ahrefsRefDomains): static
    {
        $this->ahrefsRefDomains = $ahrefsRefDomains;

        return $this;
    }

    public function getSemrushAuthorityScore(): float
    {
        return $this->semrushAuthorityScore;
    }

    public function setSemrushAuthorityScore(float $semrushAuthorityScore): static
    {
        $this->semrushAuthorityScore = $semrushAuthorityScore;

        return $this;
    }

    public function getSemrushBackLinks(): float
    {
        return $this->semrushBackLinks;
    }

    public function setSemrushBackLinks(float $semrushBackLinks): static
    {
        $this->semrushBackLinks = $semrushBackLinks;

        return $this;
    }

    public function getSemrushRefDomains(): float
    {
        return $this->semrushRefDomains;
    }

    public function setSemrushRefDomains(float $semrushRefDomains): static
    {
        $this->semrushRefDomains = $semrushRefDomains;

        return $this;
    }

    public function getWikipediaLink(): ?string
    {
        return $this->wikipediaLink;
    }

    public function setWikipediaLink(?string $wikipediaLink): static
    {
        $this->wikipediaLink = $wikipediaLink;

        return $this;
    }

    public function isPenalty(): bool
    {
        return $this->isPenalty;
    }

    public function setIsPenalty(bool $isPenalty): static
    {
        $this->isPenalty = $isPenalty;

        return $this;
    }
}
