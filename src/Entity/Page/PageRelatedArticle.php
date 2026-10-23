<?php

declare(strict_types=1);

namespace App\Entity\Page;

use App\Entity\AbstractEntity;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\PositionEntityTrait;
use App\Repository\Page\PageRelatedArticleRepository;
use Doctrine\ORM\Mapping as ORM;

use function array_filter;
use function implode;

#[ORM\Table(name: 'page_related_articles')]
#[ORM\Index(name: 'fk_page_id', columns: ['page_id'])]
#[ORM\Index(name: 'fk_article_id', columns: ['article_id'])]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Entity(repositoryClass: PageRelatedArticleRepository::class)]
class PageRelatedArticle extends AbstractEntity
{
    use ActiveEntityTrait;
    use PositionEntityTrait;

    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: 'relatedArticles')]
    #[ORM\JoinColumn(name: 'page_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Page $page = null;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'relatedArticles')]
    #[ORM\JoinColumn(name: 'article_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Article $article = null;

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getCreatedAt() === null ? 'New Entity' : null;
        $labels[] = $this->getPage()?->getTitle() ?? 'Page';
        $labels[] = $this->getArticle()?->getTitle() ?? 'Related Article';

        return implode(' ', array_filter($labels));
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }
}
