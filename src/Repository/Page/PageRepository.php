<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Page\Page;
use App\Repository\Page\Traits\PageRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Page|null findOneById(Uuid $id)
 * @method Page|null findOneBySiteIdAndSlug(Uuid $siteId, string $slug, ?Uuid $exceptId = null)
 * @method Page|null findOneActiveBySiteTokenAndSiteIdAndSlug(string $siteToken, Uuid $siteId, string $slug)
 * @method Page|null findHomepageBySiteId(Uuid $siteId)
 * @method Page|null findHomepageBySiteIdAndToken(Uuid $siteId, string $token)
 * @method Page|null findOneActiveBySiteIdAndTokenAndSlug(Uuid $siteId, string $token, string $slug)
 * @method Page[]    findAllBySiteId(Uuid $siteId)
 * @method Page[]    getChoiceListBySiteId(Uuid $siteId)
 * @method Page[]    findAllActiveForIndexing(string $siteToken, Uuid $siteId)
 */
class PageRepository extends ServiceEntityRepository implements FindByIdInterface
{
    use PageRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }
}
