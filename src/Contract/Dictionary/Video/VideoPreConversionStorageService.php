<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Video;

enum VideoPreConversionStorageService: string
{
    case AwsS3 = 'aws_s3';
    case Vimeo = 'vimeo';
}
