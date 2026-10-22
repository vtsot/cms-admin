<?php

declare(strict_types=1);

namespace App\Contract\Repository;

use App\Contract\Entity\SluggableInterface;
use Symfony\Component\Uid\Uuid;

interface SlugAwareInterface
{
    public function findOneBySlug(?string $slug, ?Uuid $exceptId = null): ?SluggableInterface;
}
