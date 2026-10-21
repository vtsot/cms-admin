<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Link;

enum LinkType: string
{
    case Page    = 'page';
    case Link    = 'link';
    case None    = 'none';
    case Article = 'article';
}
