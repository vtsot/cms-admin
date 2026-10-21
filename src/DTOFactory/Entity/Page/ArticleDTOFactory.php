<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Page;

use App\DTO\Entity\Page\ArticleDTO;
use App\Entity\Page\Article;
use Symfony\Component\Routing\RouterInterface;

readonly class ArticleDTOFactory
{
    /** @var array<string, array{width: int, height: int}> */
    public const DESKTOP_SIZE = [
        // theme code => width, height
        'default' => ['width' => 300, 'height' => 220],
    ];

    public function __construct(
        private RouterInterface $routeGenerator,
    ) {
    }

    public function fromEntity(
        Article $article,
    ): ArticleDTO {
        $theme        = $article->getSite()?->getSiteTheme()?->getCode();
        $desktopSize  = self::DESKTOP_SIZE[$theme] ?? self::DESKTOP_SIZE['default'];
        $desktopImage = $this->getImageUrl($article->getImage(), 'resize', $desktopSize['width'], $desktopSize['height']);

        return new ArticleDTO(
            $article->getId(),
            $article->getSlug(),
            $article->getTitle(),
            $article->getAlt(),
            $desktopImage,
            $article->getDescription(),
        );
    }

    private function getImageUrl(?string $imageName, string $crop, int $width, int $height): ?string
    {
        return $imageName
            ? $this->routeGenerator->generate(
                'general.image',
                [
                    'type'   => 'article',
                    'crop'   => $crop,
                    'width'  => $width,
                    'height' => $height,
                    'image'  => $imageName,
                ]
            )
            : null;
    }
}
