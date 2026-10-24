<?php

declare(strict_types=1);

namespace App\Repository\Traits;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

use function Symfony\Component\String\s;

trait QueryConditionBuilderRepositoryTrait
{
    protected function buildQueryCondition(string $query, QueryBuilder $qb, array $fields): QueryBuilder
    {
        $expr = new Expr();

        $andConditions = [];

        foreach (s($query)->split(' ') as $i => $item) {
            $orConditions = [];

            foreach ($fields as $field) {
                $orConditions[] = $expr->like($field, ':query' . $i);
            }

            $andConditions[] = $expr->orX(...$orConditions);
            $qb->setParameter('query' . $i, '%' . $item->toString() . '%');
        }

        $qb->andWhere($expr->andX(...$andConditions));

        return $qb;
    }
}
