<?php

declare(strict_types=1);

namespace App\CQ\Query\Site\Image;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\Service\FileManager\SiteImageFileManager;
use SplFileInfo;

use function file_exists;

readonly class GetSiteFaviconHandler implements QueryHandlerInterface
{
    public function __construct(
        private SiteImageFileManager $siteImageFileManager,
    ) {
    }

    public function __invoke(GetSiteFaviconQuery $query): ?SplFileInfo
    {
        $imagePath = $this->siteImageFileManager->getLocalFilepath($query->image);

        if (file_exists($imagePath)) {
            return new SplFileInfo($imagePath);
        }

        return null;
    }
}
