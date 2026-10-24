<?php

declare(strict_types=1);

namespace App\ControllerRequest;

use App\Contract\ControllerRequest\ControllerRequestInterface;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

use function explode;
use function in_array;
use function preg_replace;
use function strtolower;
use function trim;

abstract readonly class AbstractGetCollectionRequest implements ControllerRequestInterface
{
    public const int DEFAULT_PAGE     = 1;
    public const int DEFAULT_PER_PAGE = 10;

    public ?string $orderBy;

    public ?string $orderDirection;

    public function __construct(
        #[Assert\GreaterThanOrEqual(1)]
        public ?int $page = self::DEFAULT_PAGE,

        #[Assert\GreaterThanOrEqual(1)]
        #[Assert\LessThanOrEqual(1000)]
        #[SerializedName('per_page')]
        public ?int $perPage = self::DEFAULT_PER_PAGE,

        #[Assert\Length(max: 100)]
        public ?string $query = null,

        ?string $sort = null,
    ) {
        $orderBy        = null;
        $orderDirection = null;

        if ($sort !== null && trim($sort) !== '') {
            $result = explode(' ', trim(preg_replace('/\s+/', ' ', $sort)));

            $orderBy        = $result[0];
            $orderDirection = $result[1] ?? null;
        }

        $this->orderBy = $orderBy;

        if (!$orderDirection || !in_array(strtolower($orderDirection), ['asc', 'desc'], true)) {
            $orderDirection = 'asc';
        }

        $this->orderDirection = strtolower($orderDirection);
    }
}
