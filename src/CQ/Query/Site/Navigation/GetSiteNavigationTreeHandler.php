<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Navigation;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\NavigationTreeCollectionDTO;
use App\DTO\Entity\NavigationDTO;
use App\DTOFactory\Entity\Navigation\NavigationDTOFactory;
use App\Entity\Navigation\AbstractNavigation;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Navigation\NavigationRepository;
use App\Repository\Site\SiteRepository;
use Symfony\Contracts\Translation\TranslatorInterface;

use function array_key_exists;

readonly class GetSiteNavigationTreeHandler implements QueryHandlerInterface
{
    public function __construct(
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private NavigationRepository $navigationRepository,
        private NavigationDTOFactory $navigationDTOFactory,
    ) {
    }

    public function __invoke(GetSiteNavigationTreeQuery $query): NavigationTreeCollectionDTO
    {
        $site = $this->siteRepository->findOneActiveByTokenAndId($query->siteToken, $query->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $navigations = $this->navigationRepository->findAllBySiteTokenAndSiteIdAndType($query->siteToken, $query->siteId, $query->type);

        $items = [];

        // determine root entries and children entries
        foreach ($navigations as $item) {
            $parentId           = $item->getParent()?->getId() ? (string) $item->getParent()?->getId() : 0;
            $items[$parentId][] = $item;
        }

        // resolve tree with pass root items as a parameter
        $tree = $this->resolveNavigationTree($items, $items[0] ?? []);

        return new NavigationTreeCollectionDTO($tree);
    }

    /**
     * @param AbstractNavigation[] $fullNavigationList
     * @param AbstractNavigation[] $parentNavigations
     *
     * @return array<int, NavigationDTO>
     */
    private function resolveNavigationTree(
        array $fullNavigationList,
        array $parentNavigations,
    ): array {
        $tree = [];

        foreach ($parentNavigations as $item) {
            $id                    = (string) $item->getId();
            $childrenCollectionDTO = [];

            if (array_key_exists($id, $fullNavigationList)) {
                /** @var AbstractNavigation[] $childrenNavigationList */
                $childrenNavigationList = $fullNavigationList[$id];
                $childrenCollectionDTO  = $this->resolveNavigationTree(
                    $fullNavigationList,
                    $childrenNavigationList
                );
            }

            $tree[] = $this->navigationDTOFactory->fromEntity(
                $item,
                $childrenCollectionDTO
            );
        }

        return $tree;
    }
}
