<?php

declare(strict_types=1);

namespace App\Contract\Entity;

use Doctrine\Common\Collections\Collection;

interface PermissibleInterface
{
    public function getPermissionType(): ?string;

    public function getSubscriptionPackages(): Collection;
}
