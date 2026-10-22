<?php

declare(strict_types=1);

namespace App\Service\FileManager;

use InvalidArgumentException;
use League\Flysystem\UnableToGeneratePublicUrl;
use Symfony\Component\Filesystem\Filesystem;

use function dirname;
use function pathinfo;
use function rtrim;
use function sprintf;

use const DIRECTORY_SEPARATOR;
use const PATHINFO_DIRNAME;

abstract readonly class AbstractLocalFileManager extends AbstractFileManager
{
    public function getLocalDirPath(string $filename): string
    {
        try {
            return pathinfo($this->getOperator()->publicUrl($filename), PATHINFO_DIRNAME);
        } catch (UnableToGeneratePublicUrl $e) {
            throw new InvalidArgumentException(
                sprintf(
                    'The required option "%s" is missing. Check the "%s" adapter for the class "%s" in the "%s" file. ',
                    'public_url',
                    'local',
                    $this::class,
                    'flysystem.yaml'
                )
            );
        }
    }

    public function getLocalFilepath(string $filename): string
    {
        $filepath = rtrim($this->getLocalDirPath($filename), DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . $this->normalizeFilePath($filename);

        // create directory if not exists
        if (!$this->ignoreNormalizer) {
            $filesystem = new Filesystem();
            $filesystem->mkdir(dirname($filepath));
        }

        return $filepath;
    }
}
