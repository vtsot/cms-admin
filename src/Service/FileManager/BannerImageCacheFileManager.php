<?php

declare(strict_types=1);

namespace App\Service\FileManager;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class BannerImageCacheFileManager extends AbstractLocalFileManager
{
    public function __construct(
        #[Autowire(service: 'banner.image.cache.storage')]
        FilesystemOperator $operator,
    ) {
        parent::__construct(operator: $operator, ignoreNormalizer: false);
    }
}
