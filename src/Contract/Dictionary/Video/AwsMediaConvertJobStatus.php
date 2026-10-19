<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Video;

enum AwsMediaConvertJobStatus: string
{
    case Submitted  = 'SUBMITTED';
    case Processing = 'PROGRESSING';
    case Complete   = 'COMPLETE';
    case Canceled   = 'CANCELED';
    case Error      = 'ERROR';
}
