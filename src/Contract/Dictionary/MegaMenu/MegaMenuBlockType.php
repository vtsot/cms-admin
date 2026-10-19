<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\MegaMenu;

enum MegaMenuBlockType: string
{
    case Image = 'image';
    case Link  = 'link';
}
