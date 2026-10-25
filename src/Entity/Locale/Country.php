<?php

declare(strict_types=1);

namespace App\Entity\Locale;
//
//use App\Repository\CountryRepository;
//use App\ValueObject\LocaleVO;
//use Carbon\CarbonImmutable;
//use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\Common\Collections\Collection;
//use Doctrine\DBAL\Types\Types;
//use Doctrine\ORM\Mapping as ORM;
//use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
//use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
//use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
//
//#[ORM\Table(name: 'countries')]
//#[ORM\UniqueConstraint(name: 'uniq_code', columns: ['code'])]
//#[ORM\Entity(repositoryClass: CountryRepository::class)]
//class Country extends AbstractEntity implements TranslatableInterface
//{
//    use TranslatableTrait;
//
//    #[ORM\Column(name: 'code', type: Types::STRING, length: 2, unique: true, nullable: false)]
//    private ?string $code = null;
//
//    #[ORM\Column(name: 'favoured', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
//    private bool $favoured = false;
//
//    #[ORM\Column(name: '`default`', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
//    private bool $default = false;
//
//    #[ORM\Column(name: 'makes_parsed_at', type: Types::DATETIME_IMMUTABLE, precision: 6, nullable: true)]
//    private ?CarbonImmutable $makesParsedAt;
//
//    #[ORM\OneToMany(mappedBy: 'country', targetEntity: WorkshopAddress::class)]
//    private Collection $workshopAddresses;
//
//    public function __construct()
//    {
//        parent::__construct();
//        $this->workshopAddresses = new ArrayCollection();
//    }
//
//    public function getCode(): ?string
//    {
//        return $this->code;
//    }
//
//    public function setCode(string $code): self
//    {
//        $this->code = $code;
//
//        return $this;
//    }
//
//    public function isFavoured(): bool
//    {
//        return $this->favoured;
//    }
//
//    public function setFavoured(bool $favoured): self
//    {
//        $this->favoured = $favoured;
//
//        return $this;
//    }
//
//    public function isDefault(): bool
//    {
//        return $this->default;
//    }
//
//    public function setDefault(bool $default): self
//    {
//        $this->default = $default;
//
//        return $this;
//    }
//
//    public function getMakesParsedAt(): ?CarbonImmutable
//    {
//        return $this->makesParsedAt;
//    }
//
//    public function setMakesParsedAt(?CarbonImmutable $makesParsedAt): self
//    {
//        $this->makesParsedAt = $makesParsedAt;
//
//        return $this;
//    }
//
//    /**
//     * @return Collection<int, WorkshopAddress>
//     */
//    public function getWorkshopAddresses(): Collection
//    {
//        return $this->workshopAddresses;
//    }
//
//    public function addWorkshopAddress(WorkshopAddress $workshopAddress): self
//    {
//        if (!$this->workshopAddresses->contains($workshopAddress)) {
//            $this->workshopAddresses->add($workshopAddress);
//            $workshopAddress->setCountry($this);
//        }
//
//        return $this;
//    }
//
//    public function removeWorkshopAddress(WorkshopAddress $workshopAddress): self
//    {
//        if ($this->workshopAddresses->removeElement($workshopAddress)) {
//            // set the owning side to null (unless already changed)
//            if ($workshopAddress->getCountry() === $this) {
//                $workshopAddress->setCountry(null);
//            }
//        }
//
//        return $this;
//    }
//
//    public function translate(
//        string|LocaleVO|null $locale = null,
//        bool $fallbackToDefault = true,
//    ): TranslationInterface|CountryTranslation {
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
//        return $this->translate()->getTitle() ?? 'New Entity';
//    }
//}
