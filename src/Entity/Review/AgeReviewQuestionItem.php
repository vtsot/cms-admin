<?php

declare(strict_types=1);

namespace App\Entity\Review;

use App\Contract\Dictionary\Review\ReviewQuestionType;
use App\Repository\Review\AgeReviewQuestionItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgeReviewQuestionItemRepository::class)]
class AgeReviewQuestionItem extends AbstractReviewQuestionItem
{
    public function __construct()
    {
        parent::__construct();

        $this->setType(ReviewQuestionType::Age);
    }
}
