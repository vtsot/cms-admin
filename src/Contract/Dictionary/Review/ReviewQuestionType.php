<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Review;

enum ReviewQuestionType: string
{
    case Reason         = 'reason';
    case Age            = 'age';
    case MedicationTime = 'medication_time';
    case Product        = 'product';
}
