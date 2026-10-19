<?php

declare(strict_types=1);

namespace App\Contract\Entity;

use Symfony\Component\Uid\Uuid;

interface EntityInterface
{
    public function getId(): ?Uuid;
}
