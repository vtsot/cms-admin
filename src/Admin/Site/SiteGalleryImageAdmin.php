<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\GalleryImageAdmin;
use App\Admin\Traits\RelatedToSite\ConfigureFormFieldLinkEntityRelatedToSiteTrait;
use App\Entity\GalleryImage;

/**
 * @method GalleryImage|null getSubject()
 */
class SiteGalleryImageAdmin extends GalleryImageAdmin
{
    use ConfigureFormFieldLinkEntityRelatedToSiteTrait;
}
