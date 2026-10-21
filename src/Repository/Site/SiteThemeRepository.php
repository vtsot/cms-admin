<?php

declare(strict_types=1);

namespace App\Repository\Site;

use App\Entity\Site\SiteTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SiteTheme>
 *
 * @method SiteTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteTheme[]    findAll()
 * @method SiteTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteTheme::class);
    }

    public function findOneByCode(string $code): ?SiteTheme
    {
        return $this->findOneBy(['code' => $code]);
    }

    /**
     * @return array<string, string>
     */
    public function getChoiceCodeList(): array
    {
        $items = $this->createQueryBuilder('q')
            ->select('q.id, q.code, q.title')
            ->orderBy('q.title', 'ASC')
            ->getQuery()
            ->getResult();

        $result = [];

        foreach ($items as $item) {
            $result[$item['title'] ?? $item['code']] = $item['code'];
        }

        return $result;
    }
}
