<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\Service\ImageStorageService;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use SplFileInfo;

readonly class GetSiteImageHandler implements QueryHandlerInterface
{
    public function __construct(
        private ImageStorageService $imageStorageService,
        private FilesystemOperator $siteImageStorage,
        private FilesystemOperator $siteImageCacheStorage,
        //        private string $siteCacheImageDir,
        //        private string $siteNoImagePath,
    ) {
    }

    /**
     * @throws FilesystemException
     */
    public function __invoke(GetSiteImageQuery $query): SplFileInfo
    {
        return $this->imageStorageService->getImageFromStorage(
            $query->image,
            $query->crop,
            $query->width,
            $query->height,
            $this->siteImageStorage,
            $this->siteImageCacheStorage,
            $this->siteCacheImageDir,
            new SplFileInfo($this->siteNoImagePath),
        );
    }
}
