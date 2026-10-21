<?php

declare(strict_types=1);

namespace App\Entity\Review;

use App\Contract\Dictionary\Review\ReviewQuestionType;
use App\Repository\Review\ReasonReviewQuestionItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReasonReviewQuestionItemRepository::class)]
class ReasonReviewQuestionItem extends AbstractReviewQuestionItem
{
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'reason', orphanRemoval: true)]
    private Collection $reviews;

    public function __construct()
    {
        parent::__construct();

        $this->setType(ReviewQuestionType::Reason);
        $this->reviews = new ArrayCollection();
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setReason($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getReason() === $this) {
                $review->setReason(null);
            }
        }

        return $this;
    }
}
