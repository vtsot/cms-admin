<?php

declare(strict_types=1);

namespace App\Exception\Validation;

use App\Exception\AppException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EntityNotFoundException extends AppException
{
    public function __construct($message = 'Not Found', $code = Response::HTTP_NOT_FOUND, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
