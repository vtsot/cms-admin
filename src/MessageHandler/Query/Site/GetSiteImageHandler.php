<?php

declare(strict_types=1);

namespace App\MessageHandler\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\Message\Query\Site\GetSiteImageQuery;
use App\Service\FileManager\SiteImageCacheFileManager;
use App\Service\FileManager\SiteImageFileManager;
use App\Service\ImageStorageService;
use Intervention\Image\Exceptions\DriverException;
use Intervention\Image\Exceptions\ImageDecoderException;
use Intervention\Image\Exceptions\InvalidArgumentException;
use League\Flysystem\FilesystemException;
use SplFileInfo;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class GetSiteImageHandler implements QueryHandlerInterface
{
    public function __construct(
        private ImageStorageService $imageStorageService,
        private SiteImageFileManager $siteImageFileManager,
        private SiteImageCacheFileManager $siteImageCacheFileManager,
        #[Autowire(param: 'site_no_image_path')]
        private string $noImagePath,
    ) {
    }

    /**
     * @throws ImageDecoderException
     * @throws FilesystemException
     * @throws InvalidArgumentException
     * @throws DriverException
     */
    public function __invoke(GetSiteImageQuery $query): SplFileInfo
    {
        return $this->imageStorageService->getImageFromLocalFileManager(
            $query->image,
            $query->crop,
            $query->width,
            $query->height,
            $this->siteImageFileManager,
            $this->siteImageCacheFileManager,
            new SplFileInfo($this->noImagePath),
        );
    }
}
