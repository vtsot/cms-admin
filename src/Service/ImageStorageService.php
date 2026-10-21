<?php

declare(strict_types=1);

namespace App\Service;

use Closure;
use Intervention\Image\FileExtension;
use Intervention\Image\ImageManager;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use SplFileInfo;

use function extension_loaded;
use function pathinfo;
use function sprintf;

use const PATHINFO_EXTENSION;
use const PATHINFO_FILENAME;

class ImageStorageService
{
    public const CROP_FIT    = 'fit';
    public const CROP_RESIZE = 'resize';

    /**
     * @throws FilesystemException
     */
    public function getImageFromStorage(
        string $imageName,
        string $crop,
        int $width,
        int $height,
        FilesystemOperator $imageStorage,
        FilesystemOperator $imageCacheStorage,
        string $imageCacheDir,
        ?SplFileInfo $defaultImage = null,
        ?Closure $imagePathNormalizer = null,
        int $pathDepth = Util::PATH_DEPTH,
    ): SplFileInfo {
        $cacheImageName = sprintf(
            '%s_%s_%sx%s.%s',
            pathinfo($imageName, PATHINFO_FILENAME),
            $crop,
            $width,
            $height,
            pathinfo($imageName, PATHINFO_EXTENSION)
        );

        $cacheImagePath  = Util::normalizeFilePath($cacheImageName, pathDepth: $pathDepth);
        $originImagePath = $imagePathNormalizer !== null
            ? $imagePathNormalizer($imageName)
            : Util::normalizeFilePath($imageName, pathDepth: $pathDepth);

        if ($imageStorage->has($originImagePath)) {
            $originalImage          = $imageStorage->readStream($originImagePath);
            $originalImageTimestamp = $imageStorage->lastModified($originImagePath);
        } else {
            $originalImage          = null;
            $originalImageTimestamp = $defaultImage?->getMTime();
        }

        if (!$imageCacheStorage->has($cacheImagePath) || $imageCacheStorage->lastModified($cacheImagePath) < $originalImageTimestamp
        ) {
            $imageManager = extension_loaded('imagick') ? ImageManager::imagick() : ImageManager::gd();
            $image        = $imageManager->read($originalImage ?? $defaultImage);

            $image = match ($crop) {
                self::CROP_RESIZE => $image->resizeDown($width, $height),
                default           => $image->cover($width, $height),
            };

            $encoded = $image->encodeByExtension(FileExtension::WEBP);
            $imageCacheStorage->write($cacheImagePath, $encoded->toString());
        }

        return new SplFileInfo($imageCacheDir . $cacheImagePath);
    }
}
