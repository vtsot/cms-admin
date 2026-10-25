<?php

declare(strict_types=1);

namespace App\Entity\Locale;
//
//use App\Repository\LanguageRepository;
//use App\ValueObject\LocaleVO;
//use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\Common\Collections\Collection;
//use Doctrine\DBAL\Types\Types;
//use Doctrine\ORM\Mapping as ORM;
//use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
//use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
//use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
//
//#[ORM\Table(name: 'languages')]
//#[ORM\UniqueConstraint(name: 'uniq_code', columns: ['code'])]
//#[ORM\Entity(repositoryClass: LanguageRepository::class)]
//class Language extends AbstractEntity implements TranslatableInterface
//{
//    use TranslatableTrait;
//
//    #[ORM\Column(name: 'code', type: Types::STRING, length: 2, unique: true, nullable: false)]
//    private ?string $code = null;
//
//    #[ORM\OneToMany(mappedBy: 'language', targetEntity: Video::class, orphanRemoval: true)]
//    private Collection $videos;
//
//    public function __construct()
//    {
//        parent::__construct();
//        $this->videos = new ArrayCollection();
//    }
//
//    public function translate(string|LocaleVO|null $locale = null, bool $fallbackToDefault = true): TranslationInterface|LanguageTranslation
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
//        return $this->translate()->getTitle() ?? 'New Entity';
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
//    public function getVideos(): Collection
//    {
//        return $this->videos;
//    }
//}
