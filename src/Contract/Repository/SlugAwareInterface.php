<?php

declare(strict_types=1);

namespace App\Contract\Repository;

use App\Contract\Entity\SluggableInterface;
use Ramsey\Uuid\UuidInterface;

interface SlugAwareInterface
{
    public function findOneBySlug(?string $slug, ?UuidInterface $exceptId = null): ?SluggableInterface;
}
