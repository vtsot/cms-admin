<?php

declare(strict_types=1);

namespace App\Exception\Validation;

use App\Exception\AppException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class PaymentRequiredException extends AppException
{
    public function __construct($message = 'Payment required', $code = Response::HTTP_PAYMENT_REQUIRED, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
