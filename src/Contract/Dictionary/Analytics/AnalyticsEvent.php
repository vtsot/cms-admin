<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Analytics;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum AnalyticsEvent: int
{
    use EnumValuesTrait;

    case PageLoaded                  = 100000;
    case VideoLoaded                 = 100001;
    case CourseSearch                = 100002;
    case TextTrackChanged            = 100004;
    case VideoMuted                  = 100006;
    case SubscriptionPackageSelected = 100007;
    case SiteReferred                = 100008;
    case SiteExited                  = 100009;
    case courseTailView              = 100010;
    case courseChapterTailView       = 100011;
    case courseTailClicked           = 100012;
    case courseChapterTailClicked    = 100013;
    case EarlyAccessSubscribe        = 200000;
    case VehicleByVinLookup          = 200001;
    case VehicleByCatalogLookup      = 200002;
    case VehicleByKbaLookup          = 200003;
    case RepairGuideCategorySelected = 200004;
    case TroubleCodeLookup           = 200005;
    case RmiHPViewed                 = 200006;
    case RmiHGViewed                 = 200007;
    case NewsletterSubscribe         = 200010;
    case PressesLoginHeader          = 300000;
    case AccountCreated              = 310000;
    case UserLogin                   = 320000;

    public static function subscribeEvents(): array
    {
        return [self::NewsletterSubscribe->value, self::EarlyAccessSubscribe->value];
    }
}
