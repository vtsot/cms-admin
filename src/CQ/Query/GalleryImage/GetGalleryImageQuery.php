<?php

declare(strict_types=1);

namespace App\CQ\Query\GalleryImage;

/**
 * @see GetGalleryImageHandler
 */
readonly class GetGalleryImageQuery
{
    public function __construct(
        public string $image,
        public string $crop,
        public int $width,
        public int $height,
    ) {
    }
}
