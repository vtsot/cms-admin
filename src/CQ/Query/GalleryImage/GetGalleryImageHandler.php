<?php

declare(strict_types=1);

namespace App\CQ\Query\GalleryImage;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\Service\ImageStorageService;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use SplFileInfo;

readonly class GetGalleryImageHandler implements QueryHandlerInterface
{
    public function __construct(
        private ImageStorageService $imageStorageService,
        private FilesystemOperator $galleryImageStorage,
        private FilesystemOperator $galleryImageCacheStorage,
//        private string $galleryCacheImageDir,
//        private string $galleryNoImagePath,
    ) {
    }

    /**
     * @throws FilesystemException
     */
    public function __invoke(GetGalleryImageQuery $query): SplFileInfo
    {
        return $this->imageStorageService->getImageFromStorage(
            $query->image,
            $query->crop,
            $query->width,
            $query->height,
            $this->galleryImageStorage,
            $this->galleryImageCacheStorage,
            $this->galleryCacheImageDir,
            new SplFileInfo($this->galleryNoImagePath),
        );
    }
}
