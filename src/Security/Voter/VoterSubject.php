<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Contract\Entity\EntityInterface;
use Symfony\Component\Uid\Uuid;

final readonly class VoterSubject
{
    public function __construct(
        public Uuid $siteId,
        public string|EntityInterface $entry,
    ) {
    }
}
