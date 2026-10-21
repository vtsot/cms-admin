<?php

declare(strict_types=1);

namespace App\Entity\Review;

use App\Contract\Dictionary\Review\ReviewQuestionType;
use App\Repository\Review\ProductReviewQuestionItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductReviewQuestionItemRepository::class)]
class ProductReviewQuestionItem extends AbstractReviewQuestionItem
{
    public function __construct()
    {
        parent::__construct();
        $this->setType(ReviewQuestionType::Product);
    }
}
