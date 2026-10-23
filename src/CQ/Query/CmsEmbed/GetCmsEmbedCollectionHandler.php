<?php

declare(strict_types=1);

namespace App\CQ\Query\CmsEmbed;

use App\Contract\CmsEmbed\CmsEmbedInterface;
use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\CmsEmbedCollectionDTO;
use App\DTOFactory\CmsEmbed\CmsEmbedDTOFactory;
use App\Service\CmsEmbed\Helper\CmsEmbedCollection;

/**
 * @param iterable<CmsEmbedInterface> $cmsEmbed
 */
readonly class GetCmsEmbedCollectionHandler implements QueryHandlerInterface
{
    public function __construct(
        private CmsEmbedCollection $cmsEmbedCollection,
        private CmsEmbedDTOFactory $cmsEmbedDTOFactory,
    ) {
    }

    public function __invoke(GetCmsEmbedCollectionQuery $query): CmsEmbedCollectionDTO
    {
        $items     = [];
        $cmsEmbeds = $this->cmsEmbedCollection->getCmsEmbeds();

        foreach ($cmsEmbeds as $cmsEmbed) {
            $items[] = $this->cmsEmbedDTOFactory->fromCmsEmbed($cmsEmbed);
        }

        return new CmsEmbedCollectionDTO($items);
    }
}
