<?php

declare(strict_types=1);

namespace App\Service\Factory;

use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Exceptions\InvalidArgumentException;
use Intervention\Image\ImageManager;

use function extension_loaded;

final readonly class ImageManagerFactory
{
    /**
     * @throws InvalidArgumentException
     */
    public static function create(): ImageManager
    {
        return new ImageManager(
            extension_loaded('imagick')
                ? new ImagickDriver()
                : new GdDriver()
        );
    }
}
