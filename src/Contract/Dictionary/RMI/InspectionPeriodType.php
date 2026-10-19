<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\RMI;

enum InspectionPeriodType: string
{
    case Fixed    = 'fixed';
    case Flexible = 'flexible';
}
