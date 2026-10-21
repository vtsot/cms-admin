<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use App\Contract\Dictionary\Review\ReviewRateType;
use Symfony\Component\Uid\Uuid;

/**
 * @see UpdateSiteReviewFeedbackHandler
 */
readonly class UpdateSiteReviewFeedbackCommand
{
    public function __construct(
        public string $siteToken,
        public Uuid $siteId,
        public Uuid $reviewId,
        public ReviewRateType $feedbackType,
    ) {
    }
}
