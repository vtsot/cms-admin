<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\TecDoc;

enum FuelType: string
{
    case CNG                   = 'CNG';
    case CompressedNaturalGas  = 'Compressed Natural Gas (CNG)';
    case Diesel                = 'Diesel';
    case Electric              = 'Electric';
    case Electro               = 'Electro';
    case Elektro               = 'Elektro';
    case Ethanol               = 'Ethanol';
    case Hydrogen              = 'Hydrogen';
    case LPG                   = 'LPG';
    case LiquifiedPetroleumGas = 'Liquified Petroleum Gas (LPG)';
    case Methanol              = 'Methanol';
    case Mixture               = 'Mixture';
    case Petrol                = 'Petrol';
    case Benzin                = 'Benzin';
}
