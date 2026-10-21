<?php

declare(strict_types=1);

namespace App\Entity\Review;

use App\Contract\Dictionary\Review\ReviewQuestionType;
use App\Repository\Review\MedicationTimeReviewQuestionItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicationTimeReviewQuestionItemRepository::class)]
class MedicationTimeReviewQuestionItem extends AbstractReviewQuestionItem
{
    public function __construct()
    {
        $this->setType(ReviewQuestionType::MedicationTime);
    }
}
