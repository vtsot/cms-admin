<?php

declare(strict_types=1);

namespace App\Contract\Service\ElasticSearch;

use Elasticsearch\Client;
use ONGR\ElasticsearchBundle\Mapping\MetadataCollector;
use ONGR\ElasticsearchBundle\Result\Converter;
use ONGR\ElasticsearchBundle\Service\Repository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * @see \ONGR\ElasticsearchBundle\Service\Manager
 *
 * @method void              setBulkParams(array $params)
 * @method array             createIndex(bool $noMapping = false)
 * @method array             dropIndex()
 * @method array             dropAndCreateIndex(bool $noMapping = false)
 * @method bool              indexExists()
 * @method string            getIndexName()
 * @method void              setIndexName(string $name)
 * @method array             getIndexMappings()
 * @method string            getVersionNumber()
 * @method void              clearCache()
 * @method object            find(string $className, string $id, string $routing = null)
 * @method mixed             scroll(string $scrollId, string $scrollDuration = '5m')
 * @method void              clearScroll(string $scrollId)
 * @method array             getSettings()
 * @method array             getAliases(array $params = [])
 * @method Client            getClient()
 * @method string            getName()
 * @method array             getConfig()
 * @method void              setEventDispatcher(EventDispatcherInterface $eventDispatcher)
 * @method void              setStopwatch(Stopwatch $stopwatch)
 * @method Repository        getRepository(string $className)
 * @method MetadataCollector getMetadataCollector()
 * @method Converter         getConverter()
 * @method string            getCommitMode()
 * @method void              setCommitMode(string $commitMode)
 * @method int               getBulkCommitSize()
 * @method void              setBulkCommitSize(int $bulkCommitSize)
 * @method array             search(array $types, array $query, array $queryStringParams = [])
 * @method array             msearch(array $body)
 * @method void              persist(object $document)
 * @method void              remove(object $document)
 * @method array             flush(array $params = [])
 * @method array             refresh(array $params = [])
 * @method mixed             commit(array $params = []): ?array
 * @method mixed             bulk(string $operation, string|array $type, array $query): ?array
 */
interface DefaultManagerInterface
{
}
