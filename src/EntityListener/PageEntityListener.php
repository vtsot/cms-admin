<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Contract\Entity\EntityListenerInterface;
use App\Entity\Page\AbstractPage;
use App\Repository\Page\PageRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Uid\Uuid;

#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: AbstractPage::class)]
final readonly class PageEntityListener implements EntityListenerInterface
{
    private AsciiSlugger $slugger;

    public function __construct(
        private PageRepository $pageRepository,
    ) {
        $this->slugger = new AsciiSlugger();
    }

    public function preFlush(AbstractPage $page): void
    {
        if ($page->getSlug() !== null) {
            return;
        }

        $this->updateSlug($page);
    }

    private function updateSlug(AbstractPage $page): void
    {
        $siteId = $page->getSite()?->getId();
        $pageId = $page->getId();
        $slug   = $siteId && $pageId ? $this->generateSlug($siteId, $pageId, $page->getTitle()) : null;

        if ($slug) {
            $page->setSlug($slug);
        }
    }

    public function generateSlug(Uuid $siteId, Uuid $pageId, ?string $title): ?string
    {
        if (!$title) {
            return null;
        }

        $slug    = $this->slug($title);
        $counter = 0;

        while (true) {
            $checkSlug = $slug . ($counter > 0 ? '-' . $counter : '');

            if ($this->pageRepository->findOneBySiteIdAndSlug($siteId, $checkSlug, $pageId) === null) {
                break;
            }

            $counter++;
        }

        $slug .= ($counter > 0 ? ('-' . $counter) : '');

        return $slug;
    }

    private function slug(string $source, string $separator = '-'): string
    {
        return $this->slugger->slug($source, $separator)->lower()->toString();
    }
}
