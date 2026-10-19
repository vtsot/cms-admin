<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use App\Contract\Entity\LinkEntityInterface;
use App\Entity\Page\Article;
use App\Entity\Page\Page;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait LinkEntityTrait
{
    #[ORM\Column(name: 'link_type', type: Types::STRING, length: 15, nullable: true)]
    protected ?string $linkType = LinkEntityInterface::LINK_TYPE_EXTERNAL_LINK;

    #[ORM\Column(name: 'link_url', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $linkUrl = null;

    #[ORM\ManyToOne(targetEntity: Page::class)]
    #[ORM\JoinColumn(name: 'link_page_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    protected ?Page $linkPage = null;

    #[ORM\Column(name: 'link_target', type: Types::STRING, length: 15, nullable: true)]
    protected ?string $linkTarget = LinkEntityInterface::TARGET_TOP;

    #[ORM\Column(name: 'link_no_follow', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    protected bool $linkNoFollow = false;

    #[ORM\ManyToOne(targetEntity: Article::class)]
    #[ORM\JoinColumn(name: 'link_article_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    protected ?Article $linkArticle = null;

    public function getLinkType(): ?string
    {
        return $this->linkType;
    }

    public function setLinkType(?string $linkType): static
    {
        $this->linkType = $linkType;

        return $this;
    }

    public function getLinkUrl(): ?string
    {
        return $this->linkUrl;
    }

    public function setLinkUrl(?string $linkUrl): static
    {
        $this->linkUrl = $linkUrl;

        return $this;
    }

    public function getLinkPage(): ?Page
    {
        return $this->linkPage;
    }

    public function setLinkPage(?Page $linkPage): static
    {
        $this->linkPage = $linkPage;

        return $this;
    }

    public function getLinkTarget(): ?string
    {
        return $this->linkTarget;
    }

    public function setLinkTarget(?string $linkTarget): static
    {
        $this->linkTarget = $linkTarget;

        return $this;
    }

    public function isLinkNoFollow(): bool
    {
        return $this->linkNoFollow;
    }

    public function setLinkNoFollow(bool $linkNoFollow): static
    {
        $this->linkNoFollow = $linkNoFollow;

        return $this;
    }

    public function getLinkNoFollow(): bool
    {
        return $this->linkNoFollow;
    }

    public function getLinkArticle(): ?Article
    {
        return $this->linkArticle;
    }

    public function setLinkArticle(?Article $linkArticle): static
    {
        $this->linkArticle = $linkArticle;

        return $this;
    }
}
