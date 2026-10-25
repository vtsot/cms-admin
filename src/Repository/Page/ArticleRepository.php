<?php

declare(strict_types=1);

namespace App\Repository\Page;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Page\Article;
use App\Repository\Page\Traits\PageRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Article|null findOneById(Uuid $id)
 * @method Article|null findOneBySiteIdAndPageId(Uuid $siteId, Uuid $pageId)
 * @method Article|null findOneBySiteIdAndSlug(Uuid $siteId, string $slug, ?Uuid $exceptId = null)
 * @method Article|null findOneActiveBySiteTokenAndSiteIdAndSlug(string $siteToken, Uuid $siteId, string $slug)
 * @method Article|null findHomepageBySiteId(Uuid $siteId)
 * @method Article|null findHomepageBySiteIdAndToken(Uuid $siteId, string $token)
 * @method Article|null findOneActiveBySiteIdAndTokenAndSlug(Uuid $siteId, string $token, string $slug)
 * @method Article[]    findAllBySiteId(Uuid $siteId)
 * @method Article[]    getChoiceListBySiteId(Uuid $siteId)
 * @method Article[]    findAllActiveForIndexing(string $siteToken, Uuid $siteId)
 */
class ArticleRepository extends ServiceEntityRepository implements FindByIdInterface
{
    use PageRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
}
