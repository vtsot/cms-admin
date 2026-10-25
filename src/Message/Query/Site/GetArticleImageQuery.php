<?php

declare(strict_types=1);

namespace App\Message\Query\Site;

use App\MessageHandler\Query\Site\GetArticleImageHandler;

/**
 * @see GetArticleImageHandler
 */
readonly class GetArticleImageQuery
{
    public function __construct(
        public string $image,
        public string $crop,
        public int $width,
        public int $height,
    ) {
    }
}
