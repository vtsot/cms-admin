<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

class CommunicationException extends AppException
{
    public static function createFromPrevious(Throwable $e): self
    {
        return new self('Third-party service error: ' . $e->getMessage(), $e->getCode(), $e);
    }
}
