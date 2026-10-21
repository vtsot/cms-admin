<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Review;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum ReviewSortType: string
{
    use EnumValuesTrait;

    case MostHelpful        = 'most-helpful';
    case MostRecent         = 'most-recent';
    case HighestTotalRating = 'highest-total-rating';
    case HighSatisfaction   = 'high-satisfaction';
    case LowSatisfaction    = 'low-satisfaction';
}
