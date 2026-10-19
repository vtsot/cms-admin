<?php

declare(strict_types=1);

namespace App\Contract\Repository;

interface ElasticSearchIndexable
{
    public function findAllIdsForIndexing(): iterable;
}
