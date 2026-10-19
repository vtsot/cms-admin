<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

enum CookieKey: string
{
    case SubscriptionPackageType = 'subscription_package_type';
    case FirstVisitUrl           = 'first_visit_url';
    case Oauth2Failed            = 'oauth2-failed';
}
