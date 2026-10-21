<?php

declare(strict_types=1);

namespace App\CQ\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\Service\Util;
use SplFileInfo;

use function file_exists;

use const DIRECTORY_SEPARATOR;

readonly class GetSiteFaviconHandler implements QueryHandlerInterface
{
    public function __construct(
//        private string $siteStorageImageDir,
    ) {
    }

    public function __invoke(GetSiteFaviconQuery $query): ?SplFileInfo
    {
        $imagePath = $this->siteStorageImageDir . DIRECTORY_SEPARATOR . Util::normalizeFilePath($query->image);

        if (file_exists($imagePath)) {
            return new SplFileInfo($imagePath);
        }

        return null;
    }
}
