<?php

declare(strict_types=1);

namespace App\Entity\Page;
//
//use App\Entity\AbstractEntity;
//use App\Entity\Traits\SeoAwareEntityTrait;
//use App\EntityListener\HtmlSanitizer\PageTranslationHtmlSanitizerListener;
//use App\Repository\PageTranslationRepository;
//use Doctrine\DBAL\Types\Types;
//use Doctrine\ORM\Mapping as ORM;
//use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
//use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
//
//#[ORM\Table(name: 'page_translations')]
//#[ORM\Entity(repositoryClass: PageTranslationRepository::class)]
//#[ORM\EntityListeners([PageTranslationHtmlSanitizerListener::class])]
class PageTranslation extends AbstractEntity //implements TranslationInterface
{
//    use TranslationTrait;
//    use SeoAwareEntityTrait;
//
//    #[ORM\Column(name: 'title', type: Types::STRING, length: 255, nullable: true)]
//    private ?string $title = null;
//
//    #[ORM\Column(name: 'content', type: Types::TEXT, nullable: true)]
//    private ?string $content = null;
//
//    #[ORM\Column(name: 'redirect', type: Types::STRING, length: 255, nullable: true)]
//    protected ?string $redirect = null;
//
//    public function getTitle(): ?string
//    {
//        return $this->title;
//    }
//
//    public function setTitle(?string $title): self
//    {
//        $this->title = $title;
//
//        return $this;
//    }
//
//    public function getContent(): ?string
//    {
//        return $this->content;
//    }
//
//    public function setContent(?string $content): self
//    {
//        $this->content = $content;
//
//        return $this;
//    }
//
//    public function getRedirect(): ?string
//    {
//        return $this->redirect;
//    }
//
//    public function setRedirect(?string $redirect): self
//    {
//        $this->redirect = $redirect;
//
//        return $this;
//    }
//
//    public static function getTranslatableEntityClass(): string
//    {
//        return AbstractPage::class;
//    }
}
