<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Contract\Entity\EntityListenerInterface;
use App\Entity\AbstractEntity;
use App\Entity\Faq\FaqGroup;
use App\Entity\GalleryImage;
use App\Entity\Navigation\BottomNavigation;
use App\Entity\Navigation\TopNavigation;
use App\Entity\Page\Article;
use App\Entity\Page\Page;
use App\Entity\Page\PageRelatedArticle;
use App\Entity\Review\Review;
use App\Entity\Site\Banner;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: Page::class)]
#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: Article::class)]
#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: TopNavigation::class)]
#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: BottomNavigation::class)]
#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: PageRelatedArticle::class)]
#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: Review::class)]
#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: GalleryImage::class)]
#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: Banner::class)]
#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: FaqGroup::class)]
final readonly class SiteClearCacheEntityListener implements EntityListenerInterface
{
    public function __construct(
        //        private string $appEnv,
        private HttpClientInterface $httpClient,
    ) {
    }

    public function preFlush(AbstractEntity $entity): void
    {
        $this->sendRequestToClearCache($entity);
    }

    private function sendRequestToClearCache(AbstractEntity $entity): void
    {
        // todo: use SiteCacheClearCommand

        return;

        if ($this->appEnv === 'test') {
            return;
        }

        $site = match (true) {
            $entity instanceof Page,
            $entity instanceof Article,
            $entity instanceof TopNavigation,
            $entity instanceof BottomNavigation,
            $entity instanceof Review,
            $entity instanceof GalleryImage,
            $entity instanceof Banner,
            $entity instanceof FaqGroup           => $entity->getSite(),
            $entity instanceof PageRelatedArticle => $entity->getPage()?->getSite(),
            default                               => null,
        };

        if ($site === null || $site->getDomain() === null || $site->getToken() === null) {
            return;
        }

        try {
            $this->httpClient->request('POST', '/cache-clear', [
                'base_uri'    => rtrim($site->getDomain(), '/'),
                'verify_peer' => false,
                'headers'     => ['X-API-KEY' => $site->getToken()],
            ]);
        } catch (Throwable $e) {
        }
    }
}
