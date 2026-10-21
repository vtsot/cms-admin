<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\Navigation\AbstractNavigationAdmin;
use App\Admin\Traits\RelatedToSite\ConfigureFormFieldLinkEntityRelatedToSiteTrait;

abstract class AbstractSiteNavigationAdmin extends AbstractNavigationAdmin
{
    use ConfigureFormFieldLinkEntityRelatedToSiteTrait;
}
