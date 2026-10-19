<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

enum NavigationType: string
{
    case Top = 'top';

    case topEarlyAccess    = 'top-early-access';
    case Footer            = 'footer';
    case footerEmail       = 'footer-email';
    case footerEarlyAccess = 'footer-early-access';
    case Bottom            = 'bottom';
}
