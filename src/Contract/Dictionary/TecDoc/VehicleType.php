<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\TecDoc;

enum VehicleType: string
{
    case Passenger  = 'P';
    case Commercial = 'O';
    case Axles      = 'A';
    case Motor      = 'M';
    case Body       = 'K';
    case Universal  = 'U';
}
