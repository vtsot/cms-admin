<?php

declare(strict_types=1);

namespace App\Repository\Faq;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Faq\Faq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Faq>
 *
 * @method Faq|null find($id, $lockMode = null, $lockVersion = null)
 * @method Faq|null findOneBy(array $criteria, array $orderBy = null)
 * @method Faq[]    findAll()
 * @method Faq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaqRepository extends ServiceEntityRepository implements FindByIdInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faq::class);
    }

    public function findOneById(Uuid $id): ?Faq
    {
        return $this->find($id);
    }

    public function findAllActiveBySiteTokenAndSiteIdAndGroupId(string $siteToken, Uuid $siteId, Uuid $faqGroupId): array
    {
        $qb = $this->createQueryBuilder('f')
            ->select('f')
            ->join('f.faqGroup', 'fg', Join::WITH, 'fg.id = :faqGroupId AND fg.active = :active')
            ->join('fg.site', 's', Join::WITH, 's.token = :siteToken AND s.id = :siteId')
            ->andWhere('f.active = :active')
            ->setParameter('faqGroupId', $faqGroupId)
            ->setParameter('siteToken', $siteToken)
            ->setParameter('siteId', $siteId)
            ->setParameter('active', true)
            ->orderBy('f.position', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function getMaximumPositionForActiveItemsByFaqGroupId(Uuid $faqGroupId): int
    {
        try {
            return (int) $this->createQueryBuilder('f')
                ->select('MAX(f.position)')
                ->join('f.faqGroup', 'faqGroup', Join::WITH, 'faqGroup.id = :faqGroupId')
                ->andWhere('f.active = :active')
                ->setParameter('faqGroupId', $faqGroupId)
                ->setParameter('active', true)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return 0;
        }
    }
}
