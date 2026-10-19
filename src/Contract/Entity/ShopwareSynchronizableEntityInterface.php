<?php

declare(strict_types=1);

namespace App\Contract\Entity;

interface ShopwareSynchronizableEntityInterface
{
    public function getExternalId(): ?string;

    public function isSynchronized(): bool;
}
