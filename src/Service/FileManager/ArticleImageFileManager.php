<?php

declare(strict_types=1);

namespace App\Service\FileManager;

use League\Flysystem\FilesystemOperator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ArticleImageFileManager extends AbstractLocalFileManager
{
    public function __construct(
        #[Autowire(service: 'article.image.storage')]
        FilesystemOperator $operator,
    ) {
        parent::__construct(operator: $operator, ignoreNormalizer: false);
    }
}
