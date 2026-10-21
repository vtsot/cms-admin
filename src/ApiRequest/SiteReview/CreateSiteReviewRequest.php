<?php

declare(strict_types=1);

namespace App\ApiRequest\SiteReview;

use App\Contract\ApiRequest\ApiRequestInterface;
use App\Contract\Dictionary\Review\ReviewAuthorGender;
use App\Contract\Dictionary\Review\ReviewAuthorType;
use App\Entity\Review\AgeReviewQuestionItem;
use App\Entity\Review\MedicationTimeReviewQuestionItem;
use App\Entity\Review\ProductReviewQuestionItem;
use App\Entity\Review\ReasonReviewQuestionItem;
use App\Validator\Constraint\EntityExists;
use Symfony\Component\Validator\Constraints as Assert;

class CreateSiteReviewRequest implements ApiRequestInterface
{
    public function __construct(
        #[Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Uuid(message: 'Wrong reason provided'),
            new EntityExists(
                entity: ReasonReviewQuestionItem::class,
                message: 'Wrong reason provided',
            ),
        ])]
        public readonly ?string $reasonId = null,

        #[Assert\NotBlank]
        public readonly ?string $authorName = null,

        #[Assert\NotBlank()]
        #[Assert\Choice(callback: [ReviewAuthorGender::class, 'values'])]
        public readonly ?string $authorGender = null,

        #[Assert\NotBlank()]
        #[Assert\Choice(callback: [ReviewAuthorType::class, 'values'])]
        public readonly ?string $authorType = null,

        #[Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Uuid(message: 'Wrong age provided'),
            new EntityExists(
                entity: AgeReviewQuestionItem::class,
                message: 'Wrong age provided',
            ),
        ])]
        public readonly ?string $authorAgeId = null,

        #[Assert\Sequentially([
            new Assert\NotBlank(),
            new Assert\Uuid(message: 'Wrong medication time provided'),
            new EntityExists(
                entity: MedicationTimeReviewQuestionItem::class,
                message: 'Wrong medication time provided',
            ),
        ])]
        public readonly ?string $medicationTimeId = null,

        #[Assert\NotBlank()]
        #[Assert\GreaterThanOrEqual(1)]
        #[Assert\LessThanOrEqual(5)]
        public readonly ?int $effectiveness = 0,

        #[Assert\NotBlank()]
        #[Assert\GreaterThanOrEqual(1)]
        #[Assert\LessThanOrEqual(5)]
        public readonly ?int $easeOfUse = 0,

        #[Assert\NotBlank()]
        #[Assert\GreaterThanOrEqual(1)]
        #[Assert\LessThanOrEqual(5)]
        public readonly ?int $satisfaction = 0,

        #[Assert\NotBlank()]
        public readonly ?string $content = null,

        // artificial property to verify that the user has agreed to the privacy policy
        #[Assert\IsTrue(
            message: 'You must agree to the Privacy policy',
        )]
        public bool $privacyAgree = false,

        #[Assert\NotBlank]
        public ?string $fullName = null,

        #[Assert\NotBlank]
        #[Assert\Email]
        public ?string $email = null,

        #[Assert\Sequentially([
            new Assert\When(
                expression: '(this.otherProductName === null || this.otherProductManufacturer === null)',
                constraints: [new Assert\NotBlank(message: 'Choose a product or fill in the required product fields')],
            ),
            new Assert\Uuid(message: 'Wrong product provided'),
            new EntityExists(
                entity: ProductReviewQuestionItem::class,
                message: 'Wrong product provided',
            ),
        ])]
        public ?string $productId = null,

        #[Assert\When(expression: 'this.productId === null', constraints: [new Assert\NotBlank()])]
        public ?string $otherProductName = null,

        #[Assert\When(expression: 'this.productId === null', constraints: [new Assert\NotBlank()])]
        public ?string $otherProductManufacturer = null,
    ) {
    }
}
