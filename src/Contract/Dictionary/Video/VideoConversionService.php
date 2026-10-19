<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Video;

enum VideoConversionService: string
{
    case AwsMediaConvert = 'aws_media_convert';
    case Vimeo           = 'vimeo';
}
