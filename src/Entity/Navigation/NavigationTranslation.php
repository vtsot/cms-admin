<?php

declare(strict_types=1);

namespace App\Entity\Navigation;

use App\Repository\Navigation\NavigationTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Stores translatable fields of every AbstractNavigation type (MainNavigation) for all locales except the default one.
 */
#[ORM\Table(name: 'navigation_translations')]
#[ORM\UniqueConstraint(name: 'uniq_locale_object_field', columns: ['locale', 'object_id', 'field'])]
#[ORM\Entity(repositoryClass: NavigationTranslationRepository::class)]
class NavigationTranslation extends AbstractPersonalTranslation
{
    #[ORM\ManyToOne(targetEntity: AbstractNavigation::class, inversedBy: 'translations')]
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

    //    public function getObject(): ?AbstractNavigation
    //    {
    //        return $this->object;
    //    }
    //
    //    public function setObject(?self $object): static
    //    {
    //        $this->object = $object;
    //
    //        return $this;
    //    }
}
