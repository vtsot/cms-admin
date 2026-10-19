<?php

declare(strict_types=1);

namespace App\Entity\Page;

use App\Contract\Entity\PermissibleInterface;
use App\Contract\Entity\SeoAwareInterface;
use App\Contract\Entity\SluggableInterface;
use App\Entity\AbstractEntity;
use App\Entity\SubscriptionPackage;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\ContentPermissionAwareTrait;
use App\Entity\Traits\SitemapEntityTrait;
use App\Entity\Traits\SluggableEntityTrait;
use App\EntityListener\SluggableEntityListener;
use App\Repository\Page\AbstractPageRepository;
use App\ValueObject\LocaleVO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
//use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

#[ORM\Table(name: 'pages')]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\UniqueConstraint(name: 'uniq_slug', columns: ['slug'])]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'entity', type: Types::STRING)]
#[ORM\DiscriminatorMap([
    'system' => SystemPage::class,
    'common' => CommonPage::class,
])]
#[ORM\Entity(repositoryClass: AbstractPageRepository::class)]
// #[ORM\EntityListeners([SluggableEntityListener::class])]
abstract class AbstractPage extends AbstractEntity //implements PermissibleInterface, TranslatableInterface, SluggableInterface, SeoAwareInterface
{
//    use TranslatableTrait;
    use SitemapEntityTrait;
    use SluggableEntityTrait;
    use ActiveEntityTrait;
//    use ContentPermissionAwareTrait;

    public const SLUG_HOMEPAGE     = 'homepage';

//    #[ORM\Column(name: 'code_block', type: Types::TEXT, nullable: true)]
//    protected ?string $codeBlock = null;

//    #[ORM\ManyToMany(targetEntity: SubscriptionPackage::class)]
//    #[ORM\JoinTable(name: 'page_subscription_package_permissions')]
//    #[ORM\JoinColumn(name: 'page_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
//    #[ORM\InverseJoinColumn(name: 'package_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
//    protected Collection $subscriptionPackages;
//
//    public function __construct(
//    ) {
//        parent::__construct();
//
//        $this->subscriptionPackages = new ArrayCollection();
//    }
//
//
//    public function getCodeBlock(): ?string
//    {
//        return $this->codeBlock;
//    }
//
//    public function setCodeBlock(?string $codeBlock): self
//    {
//        $this->codeBlock = $codeBlock;
//
//        return $this;
//    }

//    public function getSubscriptionPackages(): Collection
//    {
//        return $this->subscriptionPackages;
//    }
//
//    public function addSubscriptionPackage(SubscriptionPackage $subscriptionPackage): self
//    {
//        if (!$this->subscriptionPackages->contains($subscriptionPackage)) {
//            $this->subscriptionPackages->add($subscriptionPackage);
//        }
//
//        return $this;
//    }
//
//    public function removeSubscriptionPackage(SubscriptionPackage $subscriptionPackage): self
//    {
//        $this->subscriptionPackages->removeElement($subscriptionPackage);
//
//        return $this;
//    }

    public function isHomepage(): bool
    {
        return $this->getSlug() === self::SLUG_HOMEPAGE;
    }

//    public static function getTranslationEntityClass(): string
//    {
//        return PageTranslation::class;
//    }
//
//    public function translate(string|LocaleVO|null $locale = null, bool $fallbackToDefault = true): TranslationInterface|PageTranslation
//    {
//        if ($locale instanceof LocaleVO) {
//            $locale = $locale->toString();
//        }
//
//        return $this->doTranslate($locale, $fallbackToDefault);
//    }
//
//    public function __call(string $method, array $arguments): mixed
//    {
//        return $this->proxyCurrentLocaleTranslation($method, $arguments);
//    }
//
//    public function __toString(): string
//    {
//        return $this->translate()->getTitle() ?: 'New entity';
//    }
}
