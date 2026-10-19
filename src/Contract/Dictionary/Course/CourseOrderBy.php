<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Course;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum CourseOrderBy: string
{
    use EnumValuesTrait;

    case CreatedAt      = 'created_at';
    case Rating         = 'rating';
    case Relevance      = 'score';
    case Popularity     = 'popularity';
    case Recommendation = 'recommendation';

    public function isRelevance(): bool
    {
        return self::Relevance->value === $this->value;
    }

    public function isRecommendation(): bool
    {
        return self::Recommendation->value === $this->value;
    }
}
