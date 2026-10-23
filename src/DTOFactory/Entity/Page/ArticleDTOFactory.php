<?php

declare(strict_types=1);

namespace App\DTOFactory\Entity\Page;

use App\DTO\Entity\Page\ArticleDTO;
use App\Entity\Page\Article;
use Symfony\Component\Routing\RouterInterface;

readonly class ArticleDTOFactory
{
    /** @var array<string, array{width: int, height: int}> */
    public const array DESKTOP_SIZE = [
        // theme code => width, height
        'default' => ['width' => 300, 'height' => 220],
    ];

    public function __construct(
        private RouterInterface $routeGenerator,
    ) {
    }

    public function fromEntity(Article $article): ArticleDTO
    {
        $desktopSize  = self::DESKTOP_SIZE['default'];
        $desktopImage = $this->getImageUrl($article->getImage(), 'resize', $desktopSize['width'], $desktopSize['height']);

        return new ArticleDTO(
            id: $article->getId(),
            slug: $article->getSlug(),
            title: $article->getTitle(),
            imageAlt: $article->getImageAlt(),
            image: $desktopImage,
            description: $article->getDescription(),
            content: $article->getContent(),
            sources: $article->getSources(),
            redirect: $article->getRedirect(),
            codeBlock: $article->getCodeBlock(),
            metaTitle: $article->getMetaTitle(),
            metaKeywords: $article->getMetaKeywords(),
            metaDescription: $article->getMetaDescription(),
            ogTitle: $article->getOgTitle(),
            ogDescription: $article->getOgDescription(),
            ogImage: $article->getOgImage(),
            indexed: $article->isIndexed(),
            sitemapChangeFrequency: $article->getSitemapChangeFrequency(),
            sitemapPriority: $article->getSitemapPriority(),
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
