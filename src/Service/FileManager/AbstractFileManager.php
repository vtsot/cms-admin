<?php

declare(strict_types=1);

namespace App\Service\FileManager;

use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;

use function pathinfo;
use function str_contains;
use function str_pad;
use function strrpos;
use function substr;

use const PATHINFO_EXTENSION;
use const PATHINFO_FILENAME;
use const STR_PAD_LEFT;

abstract readonly class AbstractFileManager
{
    public const int FOLDER_AMOUNT      = 3;
    public const int FOLDER_NAME_LENGTH = 2;

    public function __construct(
        private FilesystemOperator $operator,
        protected bool $ignoreNormalizer,
    ) {
    }

    final public function getOperator(): FilesystemOperator
    {
        return $this->operator;
    }

    /**
     * @throws FilesystemException
     */
    final public function fileExists(string $filename, bool $throwException = true): bool
    {
        try {
            return $this->operator->fileExists($this->normalizeFilePath($filename));
        } catch (FilesystemException $e) {
            if ($throwException) {
                throw $e;
            }

            return false;
        }
    }

    /**
     * @throws FilesystemException
     */
    final public function lastModified(string $filename, bool $throwException = true): ?int
    {
        try {
            return $this->operator->lastModified($this->normalizeFilePath($filename));
        } catch (FilesystemException $e) {
            if ($throwException) {
                throw $e;
            }

            return null;
        }
    }

    /**
     * @throws FilesystemException
     */
    final public function readStream(string $filename, bool $throwException = true)
    {
        try {
            return $this->operator->readStream($this->normalizeFilePath($filename));
        } catch (FilesystemException $e) {
            if ($throwException) {
                throw $e;
            }

            return null;
        }
    }

    /**
     * @throws FilesystemException
     */
    final public function read(string $filename, bool $throwException = true): ?string
    {
        try {
            return $this->operator->read($this->normalizeFilePath($filename));
        } catch (FilesystemException $e) {
            if ($throwException) {
                throw $e;
            }

            return null;
        }
    }

    /**
     * @throws FilesystemException
     */
    final public function fileSize(string $filename, bool $throwException = true): ?int
    {
        try {
            return $this->operator->fileSize($this->normalizeFilePath($filename)) ?: null;
        } catch (FilesystemException $e) {
            if ($throwException) {
                throw $e;
            }

            return null;
        }
    }

    /**
     * @throws FilesystemException
     */
    final public function write(string $filename, string $content, bool $throwException = true): void
    {
        try {
            $this->operator->write($this->normalizeFilePath($filename), $content);
        } catch (FilesystemException $e) {
            if ($throwException) {
                throw $e;
            }
        }
    }

    /**
     * @throws FilesystemException
     */
    final public function delete(string $filename, bool $throwException = true): void
    {
        try {
            $this->operator->delete($this->normalizeFilePath($filename));
        } catch (FilesystemException $e) {
            if ($throwException) {
                throw $e;
            }
        }
    }

    final public function getFilename(string $filename): string
    {
        return substr($filename, strrpos($filename, '/') + 1);
    }

    final public function normalizeFilePath(string $filename): string
    {
        if ($this->ignoreNormalizer) {
            return $filename;
        }

        if (str_contains($filename, '.')) {
            $name      = pathinfo($filename, PATHINFO_FILENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
        } else {
            $name      = $filename;
            $extension = null;
        }

        $normalizedName = str_pad($name, static::FOLDER_AMOUNT * static::FOLDER_NAME_LENGTH, '0', STR_PAD_LEFT);

        $path = '';

        for ($i = 0; $i < static::FOLDER_AMOUNT; $i++) {
            $path .= substr($normalizedName, $i * static::FOLDER_NAME_LENGTH, static::FOLDER_NAME_LENGTH) . '/';
        }

        return $path . $name . ($extension !== null ? '.' . $extension : '');
    }
}
