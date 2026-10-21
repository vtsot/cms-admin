<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed\Helper;

use App\Contract\CmsEmbed\CmsEmbedInterface;

use function array_multisort;

class CmsEmbedCollection
{
    /**
     * @var array<int, CmsEmbedInterface>
     */
    private array $cmsEmbeds;

    public function __construct(
//        iterable $cmsEmbedItems
    ) {
        $cmsEmbeds = [];
        $labels    = [];

//        /** @var CmsEmbedInterface[] $cmsEmbedItems */
//        foreach ($cmsEmbedItems as $cmsEmbed) {
//            if ($cmsEmbed->isActive()) {
//                $cmsEmbeds[] = $cmsEmbed;
//                $labels[]    = $cmsEmbed->getLabel();
//            }
//        }
//
//        // sort by labels
//        array_multisort($labels, SORT_STRING, SORT_ASC, $cmsEmbeds);
        $this->cmsEmbeds = $cmsEmbeds;
    }

    /**
     * Get all active CmsEmbed in the system.
     *
     * @return array<int, CmsEmbedInterface>
     */
    public function getCmsEmbeds(): array
    {
        return $this->cmsEmbeds;
    }

    public function getOneById(string $id): ?CmsEmbedInterface
    {
        foreach ($this->cmsEmbeds as $cmsEmbed) {
            if ($cmsEmbed->getId() === $id) {
                return $cmsEmbed;
            }
        }

        // not found
        return null;
    }

    public function getCmsEmbedIds(): array
    {
        return array_map(static function (CmsEmbedInterface $cmsEmbed) {
            return $cmsEmbed->getId();
        }, $this->cmsEmbeds);
    }
}
