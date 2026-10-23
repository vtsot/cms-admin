<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Image;

/**
 * @see GetSiteImageHandler
 */
readonly class GetSiteImageQuery
{
    public function __construct(
        public string $image,
        public string $crop,
        public int $width,
        public int $height,
    ) {
    }
}
