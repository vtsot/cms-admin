<?php

declare(strict_types=1);

namespace App\EntityListener\HtmlSanitizer;

use App\Contract\Entity\EntityListenerInterface;
use App\Entity\Page\Page;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

use function html_entity_decode;
use function htmlentities;
use function strip_tags;

// preFlush, not prePersist/preUpdate: it must run before the Gedmo TranslatableListener (onFlush)
// moves values of non-default locales into page_translations, otherwise translations stay unsanitized.
#[AsEntityListener(event: Events::preFlush, method: 'preFlush', entity: Page::class)]
class PageHtmlSanitizerListener implements EntityListenerInterface
{
    public function __construct(
        private HtmlSanitizerInterface $sanitizer,
    ) {
    }

    public function preFlush(Page $entity): void
    {
        $this->sanitize($entity);
    }

    private function sanitize(Page $entity): void
    {
        if ($entity->getContent()) {
            $entity->setContent(html_entity_decode($this->sanitizer->sanitize(htmlentities($entity->getContent()))));
        }

        if ($entity->getOgTitle()) {
            $entity->setOgTitle(strip_tags($entity->getOgTitle()));
        }

        if ($entity->getOgDescription()) {
            $entity->setOgDescription(strip_tags($entity->getOgDescription()));
        }
    }
}
