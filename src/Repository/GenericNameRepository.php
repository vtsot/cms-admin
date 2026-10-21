<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Repository\FindByIdInterface;
use App\Entity\GenericName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<GenericName>
 *
 * @method GenericName|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenericName|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenericName[]    findAll()
 * @method GenericName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenericNameRepository extends ServiceEntityRepository implements FindByIdInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenericName::class);
    }

    public function findOneById(Uuid $id): ?GenericName
    {
        return $this->find($id);
    }

    public function findOneByName(string $name): ?GenericName
    {
        return $this->findOneBy(['name' => $name]);
    }
}
