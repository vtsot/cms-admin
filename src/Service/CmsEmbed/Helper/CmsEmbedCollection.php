<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed\Helper;

use App\Contract\CmsEmbed\CmsEmbedInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

use function array_find;
use function array_multisort;

use const SORT_ASC;
use const SORT_STRING;

/**
 * @var array<int, CmsEmbedInterface> $cmsEmbed
 */
final readonly class CmsEmbedCollection
{
    public function __construct(
        #[AutowireIterator('app.cms_embed')]
        private iterable $cmsEmbed,
    ) {
    }

    /**
     * Get all active CmsEmbed in the system.
     *
     * @return array<int, CmsEmbedInterface>
     */
    public function getCmsEmbeds(): array
    {
        $cmsEmbed = [];
        $labels   = [];

        foreach ($this->cmsEmbed as $item) {
            if ($item->isActive()) {
                $cmsEmbed[] = $item;
                $labels[]   = $item->getLabel();
            }
        }

        // sort by labels
        array_multisort($labels, SORT_STRING, SORT_ASC, $cmsEmbed);

        return $cmsEmbed;
    }

    public function getOneById(string $id): ?CmsEmbedInterface
    {
        $cmsEmbed = $this->getCmsEmbeds();

        return array_find($cmsEmbed, static fn (CmsEmbedInterface $cmsEmbed) => $cmsEmbed->getId() === $id);
    }
}
