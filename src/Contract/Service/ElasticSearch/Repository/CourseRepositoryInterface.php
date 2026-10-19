<?php

declare(strict_types=1);

namespace App\Contract\Service\ElasticSearch\Repository;

use ONGR\ElasticsearchBundle\Result\ArrayIterator;
use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\ElasticsearchBundle\Result\RawIterator;
use ONGR\ElasticsearchBundle\Service\Manager;
use ONGR\ElasticsearchDSL\Search;

/**
 * @see \ONGR\ElasticsearchBundle\Service\Repository
 *
 * @method Manager          getManager()
 * @method array            getType()
 * @method object|null      find(string $id, ?string $routing = null)
 * @method DocumentIterator findByIds(array $ids)
 * @method DocumentIterator findBy(array $criteria, array $orderBy = [], ?int $limit = null, ?int $offset = null)
 * @method object|null      findOneBy(array $criteria, array $orderBy = [])
 * @method Search           createSearch()
 * @method array            getScrollConfiguration(array $raw, string $scrollDuration)
 * @method DocumentIterator findDocuments(Search $search)
 * @method ArrayIterator    findArray(Search $search)
 * @method RawIterator      findRaw(Search $search)
 * @method array|int        count(Search $search, array $params = [], bool $returnRaw = false)
 * @method array            remove(string $id, ?string $routing = null)
 * @method array            update(string $id, array $fields = [], ?string $script = null, array $params = [])
 * @method string           getClassName()
 */
interface CourseRepositoryInterface
{
}
