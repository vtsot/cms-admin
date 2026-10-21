<?php

declare(strict_types=1);

namespace App\CQ\Command;

use App\Entity\AbstractEntity;

/**
 * @see SetMaximumPositionNumberHandler
 */
readonly class SetMaximumPositionNumberCommand
{
    public function __construct(
        public AbstractEntity $entity,
    ) {
    }
}
