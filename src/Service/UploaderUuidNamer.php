<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Uid\UuidV7;
use Vich\UploaderBundle\Mapping\PropertyMappingInterface;
use Vich\UploaderBundle\Naming\ConfigurableInterface;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\Polyfill\FileExtensionTrait;

use function sprintf;

class UploaderUuidNamer implements NamerInterface, ConfigurableInterface
{
    use FileExtensionTrait;

    public function configure(array $options): void
    {
    }

    public function name(object|array $object, PropertyMappingInterface $mapping): string
    {
        $name = new UuidV7()->toString();
        $file = $mapping->getFile($object);

        if ($file && $extension = $this->getExtension($file)) {
            $name = sprintf('%s.%s', $name, $extension);
        }

        return $name;
    }
}
