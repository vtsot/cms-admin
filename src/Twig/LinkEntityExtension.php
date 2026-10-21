<?php

declare(strict_types=1);

namespace App\Twig;

use App\Contract\Entity\LinkEntityInterface;
use App\Service\LinkEntityHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LinkEntityExtension extends AbstractExtension
{
    public function __construct(
        private readonly LinkEntityHelper $linkEntityHelper,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getLinkEntityUrl', [$this, 'getLinkEntityUrl']),
        ];
    }

    public function getLinkEntityUrl(
        LinkEntityInterface $entity,
    ): ?string {
        return $this->linkEntityHelper->getPrimaryLinkUrl($entity);
    }
}
