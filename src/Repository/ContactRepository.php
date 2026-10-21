<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository implements FindByIdInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findOneById(Uuid $id): ?Contact
    {
        return $this->find($id);
    }

    public function findOneByIdAndActiveSiteIdAndSiteToken(Uuid $id, Uuid $siteId, string $siteToken): ?Contact
    {
        try {
            return $this->createQueryBuilder('c')
                ->join('c.site', 's', Join::WITH, 's.id = :siteId AND s.token = :siteToken AND s.active = :siteActive')
                ->setParameter('siteId', $siteId)
                ->setParameter('siteToken', $siteToken)
                ->setParameter('siteActive', true)
                ->where('c.id = :id')->setParameter('id', $id)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            return null;
        }
    }
}
