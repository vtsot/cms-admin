<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

class GalleryImageCmsEmbed extends AbstractCmsEmbed
{
    public const string ID    = 'gallery-images';
    public const string LABEL = 'Gallery Images';
    public const string HELP  = 'Gallery Images Embed Content';
    public const bool ACTIVE  = false;
}
