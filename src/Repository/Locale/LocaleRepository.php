<?php

declare(strict_types=1);

namespace App\Repository\Locale;
//
//use App\Entity\Locale;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//
///**
// * @extends ServiceEntityRepository<Locale>
// *
// * @method Locale|null find($id, $lockMode = null, $lockVersion = null)
// * @method Locale|null findOneBy(array $criteria, array $orderBy = null)
// * @method Locale[]    findAll()
// * @method Locale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
// */
//class LocaleRepository extends ServiceEntityRepository
//{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, Locale::class);
//    }
//
//    /**
//     * @return array<int, Locale>
//     */
//    public function findAllByActive(bool $activeOnly = true): array
//    {
//        $qb = $this->createQueryBuilder('l')
//            ->orderBy('l.default', 'DESC') /** First element must be the default locale. @see layout.admin.html.twig */
//            ->addOrderBy('l.prefix', 'ASC');
//
//        if ($activeOnly) {
//            $qb->where('l.active = 1');
//        }
//
//        return $qb
//            ->getQuery()
//            ->getResult();
//    }
//
//    /**
//     * @return string[]
//     */
//    public function findAllCodesByActive(bool $activeOnly = true): array
//    {
//        $qb = $this->createQueryBuilder('l')
//            ->select('l.code')
//            ->orderBy('l.default', 'DESC')
//            ->addOrderBy('l.prefix', 'ASC');
//
//        if ($activeOnly) {
//            $qb->where('l.active = 1');
//        }
//
//        return $qb
//            ->getQuery()
//            ->getSingleColumnResult();
//    }
//
//    public function findDefaultOrFirst(): ?Locale
//    {
//        return $this->createQueryBuilder('l')
//            ->where('l.active = 1')
//            ->orderBy('l.default', 'DESC')
//            ->addOrderBy('l.prefix', 'ASC')
//            ->setMaxResults(1)
//            ->getQuery()
//            ->getOneOrNullResult();
//    }
//
//    public function findOneByCode(?string $localeCode): ?Locale
//    {
//        return $this->findOneBy([
//            'code' => $localeCode,
//        ]);
//    }
//
//    public function getAdditionalLocales(Locale $defaultLocale): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.active = 1')
//            ->andWhere('l.code != :locale')
//            ->setParameter('locale', $defaultLocale->getCode())
//            ->getQuery()
//            ->getResult();
//    }
//
//    public function cancelAllDefaultStatus(): void
//    {
//        $this->createQueryBuilder('l')
//            ->update()
//            ->set('l.default', ':default')
//            ->setParameter('default', false)
//            ->getQuery()
//            ->execute();
//    }
//}
