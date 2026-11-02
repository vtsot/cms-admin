<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

abstract class ApiDocTag
{
    public const string AUTH  = '01 Auth';
    public const string SITES = '02 Sites';

    public const string ADMIN = '01 Admin';

    public const string GENERAL = '99 General';
}
