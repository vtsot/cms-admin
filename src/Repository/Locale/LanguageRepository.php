<?php

declare(strict_types=1);

namespace App\Repository\Locale;
//
//use App\Contract\Repository\FindByIdInterface;
//use App\Entity\Language;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Persistence\ManagerRegistry;
//use Ramsey\Uuid\UuidInterface;
//
///**
// * @extends ServiceEntityRepository<Language>
// *
// * @method Language|null find($id, $lockMode = null, $lockVersion = null)
// * @method Language|null findOneBy(array $criteria, array $orderBy = null)
// * @method Language[]    findAll()
// * @method Language[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
// */
//class LanguageRepository extends ServiceEntityRepository implements FindByIdInterface
//{
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, Language::class);
//    }
//
//    public function findOneById(UuidInterface $id): ?Language
//    {
//        return $this->find($id);
//    }
//
//    public function findOneByCode(string $code): ?Language
//    {
//        return $this->findOneBy(['code' => $code]);
//    }
//
//    /**
//     * @return array<string, Language>
//     */
//    public function findAllByCodes(array $codes): array
//    {
//        return $this->createQueryBuilder('l', 'l.code')
//            ->select('l', 't')
//            ->join('l.translations', 't')
//            ->where('l.code IN (:code)')->setParameter('code', $codes)
//            ->orderBy('l.code', 'ASC')
//            ->getQuery()
//            ->getResult();
//    }
//
//    /**
//     * @return array<int, Language>
//     */
//    public function findAllForList(): array
//    {
//        return $this->findBy(criteria: [], orderBy: ['code' => 'ASC']);
//    }
//
//    public function findAllByCourseId(UuidInterface $courseId): array
//    {
//        $qb = $this->createQueryBuilder('language')
//            ->join('language.videos', 'video')
//            ->join('video.chapters', 'chapter')
//            ->join('chapter.course', 'course')
//            ->where('course.id = :courseId')
//            ->setParameter('courseId', $courseId);
//
//        return $qb->getQuery()->getResult();
//    }
//}
