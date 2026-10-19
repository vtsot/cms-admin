<?php

declare(strict_types=1);

namespace App\Entity\Navigation;

// use App\Contract\Dictionary\NavigationType;
// use App\Contract\Entity\LinkEntityInterface;
// use App\Contract\Entity\PermissibleInterface;
// use App\Entity\AbstractEntity;
// use App\Entity\MegaMenu\MegaMenu;
// use App\Entity\SubscriptionPackage;
// use App\Entity\Traits\ContentPermissionAwareTrait;
// use App\Entity\Traits\LinkEntityTrait;
// use App\Repository\Navigation\NavigationRepository;
// use App\ValueObject\LocaleVO;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
// use Doctrine\DBAL\Types\Types;
// use Doctrine\ORM\Mapping as ORM;
// use Gedmo\Mapping\Annotation as Gedmo;
// use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
// use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
// use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
//
// #[ORM\Table(name: 'navigations')]
// #[ORM\Index(columns: ['parent_id'], name: 'idx_parent_id')]
// #[ORM\Index(columns: ['link_page_id'], name: 'fk_link_page')]
// #[ORM\Index(columns: ['link_course_filter_id'], name: 'fk_link_course_filter')]
// #[ORM\Index(columns: ['is_active'], name: 'idx_active')]
// #[ORM\Index(columns: ['mega_menu_id'], name: 'fk_mega_menu_id')]
// #[ORM\InheritanceType('SINGLE_TABLE')]
// #[ORM\DiscriminatorColumn(name: 'entity', type: Types::STRING)]
// #[ORM\DiscriminatorMap([
//    'top'                 => TopNavigation::class,
//    'footer'              => FooterNavigation::class,
//    'top-early-access'    => TopEarlyAccessNavigation::class,
//    'footer-email'        => FooterEmailNavigation::class,
//    'footer-early-access' => FooterEarlyAccessNavigation::class,
//    'bottom'              => BottomNavigation::class,
// ])]
// #[ORM\Entity(repositoryClass: NavigationRepository::class)]
use App\Entity\AbstractEntity;

abstract class AbstractNavigation extends AbstractEntity // implements PermissibleInterface, TranslatableInterface, LinkEntityInterface
{
    //    use TranslatableTrait;
    //    use LinkEntityTrait;
    //    use ContentPermissionAwareTrait;
    //
    //    public const NAVIGATION_TYPE_HORIZONTAL = 'horizontal';
    //    public const NAVIGATION_TYPE_VERTICAL   = 'vertical';
    //
    //    #[ORM\Column(name: 'position', type: Types::INTEGER, nullable: true)]
    //    #[Gedmo\SortablePosition]
    //    private ?int $position = null;
    //
    //    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN, nullable: false, options: ['default' => true])]
    //    private bool $active = true;
    //
    //    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    //    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    //    #[Gedmo\SortableGroup]
    //    private ?AbstractNavigation $parent;
    //
    //    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    //    #[ORM\OrderBy(['position' => 'ASC'])]
    //    private Collection $children;
    //
    //    #[ORM\Column(name: 'type', type: Types::STRING, length: 255, nullable: true, enumType: NavigationType::class)]
    //    #[Gedmo\SortableGroup]
    //    private ?NavigationType $type = null;
    //
    //    #[ORM\ManyToOne(targetEntity: MegaMenu::class, inversedBy: 'navigations')]
    //    #[ORM\JoinColumn(name: 'mega_menu_id', nullable: true, onDelete: 'SET NULL')]
    //    protected ?MegaMenu $megaMenu = null;
    //
    //    #[ORM\ManyToMany(targetEntity: SubscriptionPackage::class)]
    //    #[ORM\JoinTable(name: 'navigation_subscription_package_permissions')]
    //    #[ORM\JoinColumn(name: 'navigation_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    //    #[ORM\InverseJoinColumn(name: 'package_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    //    protected Collection $subscriptionPackages;
    //
    //    public function __construct()
    //    {
    //        parent::__construct();
    //
    //        $this->children             = new ArrayCollection();
    //        $this->subscriptionPackages = new ArrayCollection();
    //    }
    //
    //    public function getPosition(): ?int
    //    {
    //        return $this->position;
    //    }
    //
    //    public function setPosition(?int $position): self
    //    {
    //        $this->position = $position;
    //
    //        return $this;
    //    }
    //
    //    public function setActive(bool $active): self
    //    {
    //        $this->active = $active;
    //
    //        return $this;
    //    }
    //
    //    public function isActive(): bool
    //    {
    //        return $this->active;
    //    }
    //
    //    public static function getTranslationEntityClass(): string
    //    {
    //        return NavigationTranslation::class;
    //    }
    //
    //    public function translate(
    //        string|LocaleVO|null $locale = null,
    //        bool $fallbackToDefault = true,
    //    ): TranslationInterface|NavigationTranslation {
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
    //    public function getParent(): ?self
    //    {
    //        return $this->parent;
    //    }
    //
    //    public function setParent(?self $parent): self
    //    {
    //        $this->parent = $parent;
    //
    //        return $this;
    //    }
    //
    //    /**
    //     * @return Collection<int, AbstractNavigation>
    //     */
    //    public function getChildren(): Collection
    //    {
    //        return $this->children;
    //    }
    //
    //    public function addChildren(AbstractNavigation $children): self
    //    {
    //        if (!$this->children->contains($children)) {
    //            $this->children->add($children);
    //            $children->setParent($this);
    //        }
    //
    //        return $this;
    //    }
    //
    //    public function removeChildren(AbstractNavigation $children): self
    //    {
    //        if ($this->children->removeElement($children)) {
    //            // set the owning side to null (unless already changed)
    //            if ($children->getParent() === $this) {
    //                $children->setParent(null);
    //            }
    //        }
    //
    //        return $this;
    //    }
    //
    //    public function getType(): ?NavigationType
    //    {
    //        return $this->type;
    //    }
    //
    //    public function setType(?NavigationType $type): self
    //    {
    //        $this->type = $type;
    //
    //        return $this;
    //    }
    //
    //    public function __toString(): string
    //    {
    //        return $this->translate()->getTitle() ?: 'New entity';
    //    }
    //
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
}
