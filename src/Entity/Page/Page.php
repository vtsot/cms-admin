<?php

declare(strict_types=1);

namespace App\Entity\Page;

use App\Repository\Page\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page extends AbstractPage
{
    #[ORM\Column(name: 'related_articles_title', type: Types::STRING, length: 255, nullable: true)]
    private ?string $relatedArticlesTitle = null;

    #[ORM\OneToMany(targetEntity: PageRelatedArticle::class, mappedBy: 'page', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $relatedArticles;

    public function __construct()
    {
        $this->relatedArticles = new ArrayCollection();
    }

    public function getRelatedArticlesTitle(): ?string
    {
        return $this->relatedArticlesTitle;
    }

    public function setRelatedArticlesTitle(?string $relatedArticlesTitle): static
    {
        $this->relatedArticlesTitle = $relatedArticlesTitle;

        return $this;
    }

    /**
     * @return Collection<int, PageRelatedArticle>
     */
    public function getRelatedArticles(): Collection
    {
        return $this->relatedArticles;
    }

    public function addRelatedArticle(PageRelatedArticle $relatedArticle): static
    {
        if (!$this->relatedArticles->contains($relatedArticle)) {
            $this->relatedArticles->add($relatedArticle);
            $relatedArticle->setPage($this);
        }

        return $this;
    }

    public function removeRelatedArticle(PageRelatedArticle $relatedArticle): static
    {
        if ($this->relatedArticles->removeElement($relatedArticle)) {
            // set the owning side to null (unless already changed)
            if ($relatedArticle->getPage() === $this) {
                $relatedArticle->setPage(null);
            }
        }

        return $this;
    }
}
