<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum PageSitemapChangeFrequency: string
{
    use EnumValuesTrait;

    public const string DEFAULT = 'Weekly';

    case Always  = 'always';
    case Hourly  = 'hourly';
    case Daily   = 'daily';
    case Weekly  = 'weekly';
    case Monthly = 'monthly';
    case Yearly  = 'yearly';
    case Never   = 'never';
}
