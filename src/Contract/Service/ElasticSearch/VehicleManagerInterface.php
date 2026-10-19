<?php

declare(strict_types=1);

namespace App\Contract\Service\ElasticSearch;

use ONGR\ElasticsearchBundle\Result\DocumentIterator;

interface VehicleManagerInterface
{
    public function getSuggested(string $terms): DocumentIterator;
}
