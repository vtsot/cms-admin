<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use App\Contract\Dictionary\Review\ReviewAuthorGender;
use App\Contract\Dictionary\Review\ReviewAuthorType;
use Symfony\Component\Uid\Uuid;

/**
 * @see CreateSiteReviewHandler
 */
readonly class CreateSiteReviewCommand
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
        public ?Uuid $reasonId = null,
        public ?string $authorName = null,
        public ?ReviewAuthorGender $authorGender = null,
        public ?ReviewAuthorType $authorType = null,
        public ?Uuid $authorAgeId = null,
        public ?Uuid $medicationTimeId = null,
        public ?int $effectiveness = 0,
        public ?int $easeOfUse = 0,
        public ?int $satisfaction = 0,
        public ?string $content = null,
        public ?string $fullName = null,
        public ?string $email = null,
        public ?Uuid $productId = null,
        public ?string $otherProductName = null,
        public ?string $otherProductManufacturer = null,
    ) {
    }
}
