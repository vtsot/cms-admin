<?php

declare(strict_types=1);

namespace App\Contract\Repository;

use App\Entity\AbstractEntity;
use Symfony\Component\Uid\Uuid;

interface FindByIdInterface
{
    public function findOneById(Uuid $id): ?AbstractEntity;
}
