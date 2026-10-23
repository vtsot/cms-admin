<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GalleryImageCmsEmbed extends AbstractCmsEmbed
{
    public const string ID    = 'gallery-images';
    public const string LABEL = 'Gallery Images';
    public const string HELP  = 'Gallery Images Embed Content';
    public const bool ACTIVE  = false;
}
