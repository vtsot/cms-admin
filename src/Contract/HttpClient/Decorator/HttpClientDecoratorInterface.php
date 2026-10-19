<?php

declare(strict_types=1);

namespace App\Contract\HttpClient\Decorator;

use Symfony\Contracts\HttpClient\HttpClientInterface;

interface HttpClientDecoratorInterface extends HttpClientInterface
{
    public const HEADER_REQUEST_NAME          = 'x-request-name';
    public const HEADER_IGNORE_DATABASE_CACHE = 'x-ignore-database-cache';
    public const FOLDER_NO_REQUEST_NAME       = 'no-request-name';
    public const HEADER_FIELDS_NO_CACHE       = 'x-fields-no-cache';
}
