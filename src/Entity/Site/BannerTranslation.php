<?php

declare(strict_types=1);

namespace App\Entity\Site;

use App\Repository\Site\BannerTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Stores translatable fields of Banner for all locales except the default one.
 */
#[ORM\Table(name: 'banner_translations')]
#[ORM\UniqueConstraint(name: 'uniq_locale_object_field', columns: ['locale', 'object_id', 'field'])]
#[ORM\Entity(repositoryClass: BannerTranslationRepository::class)]
class BannerTranslation extends AbstractPersonalTranslation
{
    #[ORM\ManyToOne(targetEntity: Banner::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    protected $object;

    public function __construct(?string $locale = null, ?string $field = null, ?string $value = null)
    {
        if ($locale !== null) {
            $this->setLocale($locale);
        }

        if ($field !== null) {
            $this->setField($field);
        }

        if ($value !== null) {
            $this->setContent($value);
        }
    }
}
