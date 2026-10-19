<?php

declare(strict_types=1);

namespace App\Contract\Repository;

use App\Entity\AbstractEntity;
use Ramsey\Uuid\UuidInterface;

interface FindByIdInterface
{
    public function findOneById(UuidInterface $id): ?AbstractEntity;
}
