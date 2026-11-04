<?php

declare(strict_types=1);

namespace App\Entity\Traits\Site;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SiteSettingsApiLogActiveEntityTrait
{
    #[ORM\Column(name: 'api_log_enabled', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $apiLogEnabled = true;

    public function isApiLogEnabled(): bool
    {
        return $this->apiLogEnabled;
    }

    public function setApiLogEnabled(bool $apiLogEnabled): static
    {
        $this->apiLogEnabled = $apiLogEnabled;

        return $this;
    }
}
