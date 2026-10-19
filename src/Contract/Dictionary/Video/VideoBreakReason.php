<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Video;

enum VideoBreakReason: string
{
    case Frozen        = 'Frozen';
    case Failed        = 'Failed'; // unable to create timestamps for some reason
    case OpeningFailed = 'Opening failed'; // from ffmpeg: unable to probe
    case NoFilename    = 'No filename';
    case NoLocalFile   = 'No local file';
}
