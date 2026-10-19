<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Social;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum SocialName: string
{
    use EnumValuesTrait;

    case Facebook  = 'facebook';
    case Instagram = 'instagram';
    case Linkedin  = 'linkedin';
    case Twitter   = 'twitter';
    case Whatsapp  = 'whatsapp';
}
