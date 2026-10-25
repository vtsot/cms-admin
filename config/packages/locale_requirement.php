<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use InvalidArgumentException;
use JsonException;

use function array_map;
use function implode;
use function in_array;
use function is_array;
use function json_decode;
use function sprintf;

use const JSON_THROW_ON_ERROR;

/*
 * LOCALE_REQUIREMENT is read when the container is built, not via %env()%: bundle array nodes (sonata_translation.locales)
 * and route requirements don't accept runtime env values. Run cache:clear after changing LOCALE_REQUIREMENT.
 */
return static function (ContainerConfigurator $container): void {
    $invalidLocales = 'The LOCALES env var must be a non-empty JSON array, e.g. LOCALES=\'["en_GB","uk_UA"]\'.';
    $defaultLocale  = $_SERVER['DEFAULT_LOCALE'] ?? null;

    try {
        $locales = json_decode($_SERVER['LOCALES'] ?? '[]', true, flags: JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        throw new InvalidArgumentException($invalidLocales, previous: $e);
    }

    if (!is_array($locales) || $locales === []) {
        throw new InvalidArgumentException($invalidLocales);
    }

    if (!in_array($defaultLocale, $locales, true)) {
        throw new InvalidArgumentException(
            sprintf(
                'The DEFAULT_LOCALE env var "%s" must be one of the LOCALES env var values: %s.',
                $defaultLocale,
                implode(', ', $locales),
            )
        );
    }

    $container->parameters()
        ->set('sonata_translation_locales', $locales)
        // route requirement for locale parameters, e.g. 'en_GB|uk_UA'
        ->set('locale_requirement', implode('|', array_map('preg_quote', $locales)));
};
