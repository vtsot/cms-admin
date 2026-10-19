<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Video;

enum VideoStatus: string
{
    case UploadedToLocalStorage    = 'uploaded_locally';
    case UploadForConversionFailed = 'upload_for_conversion_failed';
    case UploadedForConversion     = 'uploaded_for_conversion';
    case ConversionFailed          = 'conversion_failed';
    case Converting                = 'converting';
    case Converted                 = 'converted';
    case UploadForStreamingFailed  = 'upload_for_streaming_failed';
    case UploadedForStreaming      = 'uploaded_for_streaming';

    public function isConverted(): bool
    {
        return self::Converted->value === $this->value;
    }
}
