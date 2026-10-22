<?php

declare(strict_types=1);

namespace App\Entity\Page;

use App\Entity\Traits\DescriptionEntityTrait;
use App\Entity\Traits\ImageAltEntityTrait;
use App\Repository\Page\ArticleRepository;
use Carbon\CarbonImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

use function array_filter;
use function implode;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article extends AbstractPage
{
    use DescriptionEntityTrait;
    use ImageAltEntityTrait;

    #[ORM\Column(name: 'image', type: Types::STRING, length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'article', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\OneToMany(targetEntity: PageRelatedArticle::class, mappedBy: 'article', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $relatedArticles;

    public function __construct()
    {
        $this->relatedArticles = new ArrayCollection();
    }

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getCreatedAt() === null ? 'New Entity' : null;
        $labels[] = $this->getTitle();

        return implode(' ', array_filter($labels));
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(File|UploadedFile|null $imageFile): self
    {
        $this->imageFile = $imageFile;
        $this->setUpdatedAt(new CarbonImmutable());

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
            $relatedArticle->setArticle($this);
        }

        return $this;
    }

    public function removeRelatedArticle(PageRelatedArticle $relatedArticle): static
    {
        if ($this->relatedArticles->removeElement($relatedArticle)) {
            // set the owning side to null (unless already changed)
            if ($relatedArticle->getArticle() === $this) {
                $relatedArticle->setArticle(null);
            }
        }

        return $this;
    }
}
