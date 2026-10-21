<?php

declare(strict_types=1);

namespace App\Entity\Traits\Site;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SiteSettingsThemeColorsEntityTrait
{
    #[ORM\Column(name: 'theme_primary_color', type: Types::STRING, length: 7, nullable: true)]
    private ?string $themePrimaryColor = null;

    #[ORM\Column(name: 'theme_text_color', type: Types::STRING, length: 7, nullable: true)]
    private ?string $themeTextColor = null;

    #[ORM\Column(name: 'theme_top_bg_color', type: Types::STRING, length: 7, nullable: true)]
    private ?string $themeTopBgColor = null;

    #[ORM\Column(name: 'theme_footer_bg_color', type: Types::STRING, length: 7, nullable: true)]
    private ?string $themeFooterBgColor = null;

    public function getThemePrimaryColor(): ?string
    {
        return $this->themePrimaryColor;
    }

    public function setThemePrimaryColor(?string $themePrimaryColor): static
    {
        $this->themePrimaryColor = $themePrimaryColor;

        return $this;
    }

    public function getThemeTextColor(): ?string
    {
        return $this->themeTextColor;
    }

    public function setThemeTextColor(?string $themeTextColor): static
    {
        $this->themeTextColor = $themeTextColor;

        return $this;
    }

    public function getThemeTopBgColor(): ?string
    {
        return $this->themeTopBgColor;
    }

    public function setThemeTopBgColor(?string $themeTopBgColor): static
    {
        $this->themeTopBgColor = $themeTopBgColor;

        return $this;
    }

    public function getThemeFooterBgColor(): ?string
    {
        return $this->themeFooterBgColor;
    }

    public function setThemeFooterBgColor(?string $themeFooterBgColor): static
    {
        $this->themeFooterBgColor = $themeFooterBgColor;

        return $this;
    }
}
