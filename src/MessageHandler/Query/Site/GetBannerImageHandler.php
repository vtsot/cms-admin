<?php

declare(strict_types=1);

namespace App\MessageHandler\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\Message\Query\Site\GetBannerImageQuery;
use App\Service\FileManager\BannerImageCacheFileManager;
use App\Service\FileManager\BannerImageFileManager;
use App\Service\ImageStorageService;
use Intervention\Image\Exceptions\DriverException;
use Intervention\Image\Exceptions\ImageDecoderException;
use Intervention\Image\Exceptions\InvalidArgumentException;
use League\Flysystem\FilesystemException;
use SplFileInfo;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class GetBannerImageHandler implements QueryHandlerInterface
{
    public function __construct(
        private ImageStorageService $imageStorageService,
        private BannerImageFileManager $bannerImageFileManager,
        private BannerImageCacheFileManager $bannerImageCacheFileManager,
        #[Autowire(param: 'banner_no_image_path')]
        private string $noImagePath,
    ) {
    }

    /**
     * @throws ImageDecoderException
     * @throws FilesystemException
     * @throws DriverException
     * @throws InvalidArgumentException
     */
    public function __invoke(GetBannerImageQuery $query): SplFileInfo
    {
        return $this->imageStorageService->getImageFromLocalFileManager(
            $query->image,
            $query->crop,
            $query->width,
            $query->height,
            $this->bannerImageFileManager,
            $this->bannerImageCacheFileManager,
            new SplFileInfo($this->noImagePath),
        );
    }
}
