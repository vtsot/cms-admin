<?php

declare(strict_types=1);

namespace App\Contract\Service\ElasticSearch;

use App\DTO\Data\Request\CourseCollectionFilterDTO;
use App\Entity\Course;
use App\ValueObject\LocaleVO;
use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\ElasticsearchDSL\Search;
use Ramsey\Uuid\UuidInterface;

interface CourseManagerInterface
{
    public function getFiltered(
        CourseCollectionFilterDTO $filter,
        ?bool $addAggregations = false,
        ?UuidInterface $currentUserId = null,
    ): DocumentIterator;

    public function getRelated(
        Course $course,
        LocaleVO $locale,
        ?int $page,
        ?int $perPage,
    ): DocumentIterator;

    public function incPopularity(Course $course): void;

    public function updatePopularity(Course $course, int $popularity): void;

    public function includeRecommendedCourses(Search $search, ?UuidInterface $currentUserId): void;
}
