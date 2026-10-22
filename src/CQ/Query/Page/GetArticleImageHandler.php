<?php

declare(strict_types=1);

namespace App\CQ\Query\Page;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\Service\ImageStorageService;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use SplFileInfo;

readonly class GetArticleImageHandler implements QueryHandlerInterface
{
    public function __construct(
        //        private ImageStorageService $imageStorageService,
        //        private FilesystemOperator $articleImageStorage,
        //        private FilesystemOperator $articleImageCacheStorage,
        //        private string $articleCacheImageDir,
        //        private string $articleNoImagePath,
    ) {
    }

    /**
     * @throws FilesystemException
     */
    public function __invoke(GetArticleImageQuery $query): SplFileInfo
    {
        return $this->imageStorageService->getImageFromStorage(
            $query->image,
            $query->crop,
            $query->width,
            $query->height,
            $this->articleImageStorage,
            $this->articleImageCacheStorage,
            $this->articleCacheImageDir,
            new SplFileInfo($this->articleNoImagePath),
        );
    }
}
