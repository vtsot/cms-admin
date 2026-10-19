<?php

declare(strict_types=1);

namespace App\Contract\Entity;

interface SluggableInterface
{
    public function getSlug(): ?string;
}
