<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\TecDoc;

enum ListType: int
{
    case Rest     = 0;
    case Favoured = 1;
}
