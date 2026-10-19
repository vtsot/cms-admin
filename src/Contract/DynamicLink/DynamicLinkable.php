<?php

declare(strict_types=1);

namespace App\Contract\DynamicLink;

interface DynamicLinkable
{
    public function generateDynamicLink(string $url): string;
}
