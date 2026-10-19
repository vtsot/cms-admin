<?php

declare(strict_types=1);

namespace App\Contract\Translation;

use Ramsey\Uuid\UuidInterface;

interface EntityTranslationInterface
{
    public function getTranslationsByEntity(UuidInterface $entityId): array;
}
