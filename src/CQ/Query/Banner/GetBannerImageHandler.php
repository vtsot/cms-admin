<?php

declare(strict_types=1);

namespace App\CQ\Query\Banner;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\Service\ImageStorageService;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use SplFileInfo;

readonly class GetBannerImageHandler implements QueryHandlerInterface
{
    public function __construct(
        private ImageStorageService $imageStorageService,
        private FilesystemOperator $bannerImageStorage,
        private FilesystemOperator $bannerImageCacheStorage,
//        private string $bannerCacheImageDir,
//        private string $bannerNoImagePath,
    ) {
    }

    /**
     * @throws FilesystemException
     */
    public function __invoke(GetBannerImageQuery $query): SplFileInfo
    {
        return $this->imageStorageService->getImageFromStorage(
            $query->image,
            $query->crop,
            $query->width,
            $query->height,
            $this->bannerImageStorage,
            $this->bannerImageCacheStorage,
            $this->bannerCacheImageDir,
            new SplFileInfo($this->bannerNoImagePath),
        );
    }
}
