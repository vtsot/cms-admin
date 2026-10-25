<?php

declare(strict_types=1);

namespace App\MessageHandler\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Collection\NavigationTreeCollectionDTO;
use App\DTO\Entity\NavigationDTO;
use App\DTOFactory\Entity\Navigation\NavigationDTOFactory;
use App\Entity\Navigation\AbstractNavigation;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Query\Site\GetNavigationTreeQuery;
use App\Repository\Navigation\NavigationRepository;
use App\Repository\Site\SiteRepository;
use App\Security\Voter\ApiSite\NavigationVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Uid\NilUlid;
use Symfony\Contracts\Translation\TranslatorInterface;

use function array_key_exists;

readonly class GetNavigationTreeHandler implements QueryHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
        private NavigationRepository $navigationRepository,
        private NavigationDTOFactory $navigationDTOFactory,
    ) {
    }

    public function __invoke(GetNavigationTreeQuery $query): NavigationTreeCollectionDTO
    {
        if (!$site = $this->siteRepository->findOneActiveBySiteIdAndToken($query->siteId, $query->token)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'GENERAL.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(NavigationVoter::LIST, new VoterSubject($query->siteId, AbstractNavigation::class))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        $items       = [];
        $nil         = new NilUlid()->toString();
        $navigations = $this->navigationRepository
            ->findAllActiveBySiteIdAndTokenAndType($query->siteId, $query->token, $query->type);

        // determine root entries and children entries
        foreach ($navigations as $item) {
            $parentId           = $item->getParent()?->getId()?->toString() ?? $nil;
            $items[$parentId][] = $item;
        }

        // resolve tree with pass root items as a parameter
        $tree = $this->resolveNavigationTree($items, $items[$nil] ?? []);

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

            $tree[] = $this->navigationDTOFactory->fromEntity($item, $childrenCollectionDTO);
        }

        return $tree;
    }
}
