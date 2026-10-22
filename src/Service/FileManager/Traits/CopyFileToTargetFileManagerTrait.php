<?php

declare(strict_types=1);

namespace App\Service\FileManager\Traits;

use App\Service\FileManager\AbstractFileManager;
use League\Flysystem\FilesystemException;

trait CopyFileToTargetFileManagerTrait
{
    /**
     * @throws FilesystemException
     */
    private function copyFileToTargetFileManager(
        AbstractFileManager $sourceManager,
        AbstractFileManager $targetManager,
        string $sourceFilename,
        ?string $targetFilename = null,
        ?bool $throwException = false,
    ): ?string {
        try {
            $targetFilename ??= $sourceFilename;
            $targetManager->delete($targetFilename, false);
            $targetManager->write($targetFilename, $sourceManager->read($sourceFilename), $throwException);

            return $targetFilename;
        } catch (FilesystemException $e) {
            if ($throwException) {
                throw $e;
            }
        }

        return null;
    }
}
