<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\FileManager\AbstractLocalFileManager;
use Intervention\Image\Exceptions\DriverException;
use Intervention\Image\Exceptions\ImageDecoderException;
use Intervention\Image\Exceptions\InvalidArgumentException;
use Intervention\Image\FileExtension;
use Intervention\Image\ImageManager;
use League\Flysystem\FilesystemException;
use SplFileInfo;

use function pathinfo;
use function sprintf;

use const PATHINFO_EXTENSION;
use const PATHINFO_FILENAME;

class ImageStorageService
{
    public const string CROP_FIT    = 'fit';
    public const string CROP_RESIZE = 'resize';

    public function __construct(
        private readonly ImageManager $imageManager,
    ) {
    }

    /**
     * @throws FilesystemException
     * @throws DriverException
     * @throws ImageDecoderException
     * @throws InvalidArgumentException
     */
    public function getImageFromLocalFileManager(
        string $sourceName,
        string $crop,
        int $width,
        int $height,
        AbstractLocalFileManager $sourceFileManager,
        AbstractLocalFileManager $cacheFileManager,
        SplFileInfo $defaultImage,
    ): SplFileInfo {
        $filename = sprintf(
            '%s_%s_%sx%s.%s',
            pathinfo($sourceName, PATHINFO_FILENAME),
            $crop,
            $width,
            $height,
            pathinfo($sourceName, PATHINFO_EXTENSION)
        );

        if ($sourceFileManager->fileExists($sourceName, false)) {
            $originalImage          = $sourceFileManager->readStream($sourceName, false);
            $originalImageTimestamp = $sourceFileManager->lastModified($sourceName, false);
        } else {
            $originalImage          = null;
            $originalImageTimestamp = $defaultImage->getMTime();
        }

        if (!$cacheFileManager->fileExists($filename, false)
            || $cacheFileManager->lastModified($filename, false) < $originalImageTimestamp
        ) {
            $image = match (true) {
                $originalImage !== null => $this->imageManager->decodeStream($originalImage),
                default                 => $this->imageManager->decodeSplFileInfo($defaultImage),
            };

            $image = match ($crop) {
                self::CROP_RESIZE => $image->resizeDown($width, $height),
                default           => $image->cover($width, $height),
            };

            $encoded = $image->encodeUsingFileExtension(FileExtension::WEBP);
            $cacheFileManager->write($filename, $encoded->toString(), false);
        }

        return new SplFileInfo($cacheFileManager->getLocalFilepath($filename));
    }
}
