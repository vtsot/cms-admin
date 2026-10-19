<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\RMI;

enum RepairManualType: string
{
    case Text  = 'text';
    case Image = 'image';
}
