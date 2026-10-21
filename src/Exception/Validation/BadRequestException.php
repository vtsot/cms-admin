<?php

declare(strict_types=1);

namespace App\Exception\Validation;

use App\Exception\AppException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BadRequestException extends AppException
{
    public function __construct($message = 'Bad Request', $code = Response::HTTP_BAD_REQUEST, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
