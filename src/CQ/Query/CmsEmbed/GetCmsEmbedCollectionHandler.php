<?php

declare(strict_types=1);

namespace App\CQ\Query\CmsEmbed;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\CmsEmbedCollectionDTO;
use App\DTOFactory\CmsEmbed\CmsEmbedDTOFactory;
use App\Service\CmsEmbed\Helper\CmsEmbedCollection;

class GetCmsEmbedCollectionHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CmsEmbedCollection $cmsEmbedCollection,
        private readonly CmsEmbedDTOFactory $cmsEmbedDTOFactory,
    ) {
    }

    public function __invoke(GetCmsEmbedCollectionQuery $query): CmsEmbedCollectionDTO
    {
        $cmsEmbeds = $this->cmsEmbedCollection->getCmsEmbeds();

        $items = [];

        foreach ($cmsEmbeds as $cmsEmbed) {
            $items[] = $this->cmsEmbedDTOFactory->fromCmsEmbed($cmsEmbed);
        }

        return new CmsEmbedCollectionDTO($items);
    }
}
