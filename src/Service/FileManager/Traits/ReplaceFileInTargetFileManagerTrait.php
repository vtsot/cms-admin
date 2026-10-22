<?php

declare(strict_types=1);

namespace App\Service\FileManager\Traits;

use App\Service\FileManager\AbstractFileManager;
use League\Flysystem\FilesystemException;

trait ReplaceFileInTargetFileManagerTrait
{
    use MoveFileToTargetFileManagerTrait;

    /**
     * @throws FilesystemException
     */
    private function replaceFileInTargetFileManager(
        AbstractFileManager $sourceManager,
        AbstractFileManager $targetManager,
        ?string $sourceFilename,
        ?string $targetFilename,
        ?bool $throwException = false,
    ): ?string {
        if ($sourceFilename !== null
            && $targetFilename !== $targetManager->getFilename($sourceFilename)
        ) {
            // move
            $filename = $this->moveFileToTargetFileManager(
                $sourceManager,
                $targetManager,
                $sourceFilename,
                $targetFilename,
                $throwException,
            );

            // remove old
            if ($filename !== null && $targetFilename !== null) {
                $targetManager->delete($targetFilename, $throwException);
            }

            // return new filename
            return $filename;
        }

        // remove exists
        if ($sourceFilename === null && $targetFilename !== null) {
            $targetManager->delete($targetFilename, $throwException);

            // was removed
            return null;
        }

        //  was not updated return current value
        return $targetFilename;
    }
}
