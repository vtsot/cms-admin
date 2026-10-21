<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\BannerAdmin;
use App\Admin\Traits\RelatedToSite\ConfigureFormFieldLinkEntityRelatedToSiteTrait;
use App\Entity\Banner;

/**
 * @method Banner|null getSubject()
 */
class SiteBannerAdmin extends BannerAdmin
{
    use ConfigureFormFieldLinkEntityRelatedToSiteTrait;
}
