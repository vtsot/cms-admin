<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Video;

enum VimeoTranscodeVideoStatus: string
{
    case TranscodeInProgress = 'in_progress';
    case TranscodeError      = 'error';
    case TranscodeComplete   = 'complete';
}
