<?php

declare(strict_types=1);

namespace App\Service\FileManager\Traits;

use App\Service\FileManager\AbstractFileManager;
use League\Flysystem\FilesystemException;

trait MoveFileToTargetFileManagerTrait
{
    /**
     * @throws FilesystemException
     */
    private function moveFileToTargetFileManager(
        AbstractFileManager $sourceManager,
        AbstractFileManager $targetManager,
        string $sourceFilename,
        ?string $targetFilename = null,
        ?bool $throwException = false,
    ): ?string {
        try {
            $targetFilename ??= $sourceFilename;
            $targetManager->write($targetFilename, $sourceManager->read($sourceFilename), $throwException);
            $sourceManager->delete($sourceFilename, $throwException);

            return $targetFilename;
        } catch (FilesystemException $e) {
            if ($throwException) {
                throw $e;
            }
        }

        return null;
    }
}
