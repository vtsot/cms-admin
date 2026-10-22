<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Page;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\Service\FileManager\ArticleImageCacheFileManager;
use App\Service\FileManager\ArticleImageFileManager;
use App\Service\ImageStorageService;
use Intervention\Image\Exceptions\DriverException;
use Intervention\Image\Exceptions\ImageDecoderException;
use Intervention\Image\Exceptions\InvalidArgumentException;
use League\Flysystem\FilesystemException;
use SplFileInfo;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class GetArticleImageHandler implements QueryHandlerInterface
{
    public function __construct(
        private ImageStorageService $imageStorageService,
        private ArticleImageFileManager $articleImageFileManager,
        private ArticleImageCacheFileManager $articleImageCacheFileManager,
        #[Autowire(param: 'article_no_image_path')]
        private string $noImagePath,
    ) {
    }

    /**
     * @throws ImageDecoderException
     * @throws FilesystemException
     * @throws DriverException
     * @throws InvalidArgumentException
     */
    public function __invoke(GetArticleImageQuery $query): SplFileInfo
    {
        return $this->imageStorageService->getImageFromLocalFileManager(
            $query->image,
            $query->crop,
            $query->width,
            $query->height,
            $this->articleImageFileManager,
            $this->articleImageCacheFileManager,
            new SplFileInfo($this->noImagePath),
        );
    }
}
