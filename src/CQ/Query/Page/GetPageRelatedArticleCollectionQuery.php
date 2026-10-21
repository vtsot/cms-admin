<?php

declare(strict_types=1);

namespace App\CQ\Query\Page;


use Symfony\Component\Uid\Uuid;

/**
 * @see GetPageRelatedArticleCollectionHandler
 */
readonly class GetPageRelatedArticleCollectionQuery
{
    public function __construct(
        public Uuid $pageId,
    ) {
    }
}
