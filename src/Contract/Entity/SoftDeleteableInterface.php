<?php

declare(strict_types=1);

namespace App\Contract\Entity;

use DateTimeInterface;

interface SoftDeleteableInterface
{
    public function getDeletedAt(): ?DateTimeInterface;

    public function setDeletedAt(?DateTimeInterface $deletedAt): self;

    public function isDeleted(): bool;
}
