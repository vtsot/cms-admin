<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

class GeneralExtension extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     */
    public function getTests(): array
    {
        return [
            new TwigTest('instanceof', [$this, 'isInstanceOf']),
        ];
    }

    public function isInstanceOf(object $var, string $instance): bool
    {
        return $var instanceof $instance;
    }
}
