<?php

declare(strict_types=1);

namespace App\DTO;

use OpenApi\Attributes as OA;

final readonly class ErrorDTO
{
    public function __construct(
        public int $code,
        public string $message,
        /** @var mixed[] */
        #[OA\Property(
            property: 'errors',
            properties: [
                new OA\Property(
                    property: 'global',
                    type: 'array',
                    items: new OA\Items(type: 'string'),
                ),
                new OA\Property(
                    property: 'fields',
                    properties: [
                        new OA\Property(
                            property: 'field_name',
                            type: 'array',
                            items: new OA\Items(type: 'string'),
                        ),
                    ],
                    type: 'object',
                ),
            ],
            type: 'object',
        )]
        public ?array $errors = null,
    ) {
    }
}
