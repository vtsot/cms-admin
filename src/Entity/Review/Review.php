<?php

declare(strict_types=1);

namespace App\Entity\Review;

use App\Contract\Dictionary\Review\ReviewAuthorGender;
use App\Contract\Dictionary\Review\ReviewAuthorType;
use App\Entity\AbstractEntity;
use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\ContentEntityTrait;
use App\Repository\Review\ReviewRepository;
use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function mb_strlen;
use function mb_substr;

#[ORM\Table(name: 'reviews')]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Index(name: 'fk_reason_id', columns: ['reason_id'])]
#[ORM\Index(name: 'fk_author_age_id', columns: ['author_age_id'])]
#[ORM\Index(name: 'fk_medication_time_id', columns: ['medication_time_id'])]
#[ORM\Index(name: 'fk_product_id', columns: ['product_id'])]
#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review extends AbstractEntity
{
    use ActiveEntityTrait;
    use ContentEntityTrait;

    public const EVALUATIVE_INDICATORS = ['effectiveness', 'easeOfUse', 'satisfaction'];

    private static int $maxDescriptionLength = 40;

    #[ORM\Column(name: 'author_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $authorName = null;

    #[ORM\Column(name: 'author_gender', type: Types::STRING, length: 255, nullable: true, enumType: ReviewAuthorGender::class)]
    private ?ReviewAuthorGender $authorGender = null;

    #[ORM\Column(name: 'author_type', type: Types::STRING, length: 255, nullable: true, enumType: ReviewAuthorType::class)]
    private ?ReviewAuthorType $authorType = null;

    #[ORM\Column(name: 'effectiveness', type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private int $effectiveness = 0;

    #[ORM\Column(name: 'like_quantity', type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private int $likeQuantity = 0;

    #[ORM\Column(name: 'dislike_quantity', type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private int $dislikeQuantity = 0;

    #[ORM\Column(name: 'report_quantity', type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private int $reportQuantity = 0;

    #[ORM\Column(name: 'ease_of_use', type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private int $easeOfUse = 0;

    #[ORM\Column(name: 'satisfaction', type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private int $satisfaction = 0;

    #[ORM\ManyToOne(targetEntity: ReasonReviewQuestionItem::class)]
    #[ORM\JoinColumn(name: 'reason_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?ReasonReviewQuestionItem $reason = null;

    #[ORM\ManyToOne(targetEntity: AgeReviewQuestionItem::class)]
    #[ORM\JoinColumn(name: 'author_age_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?AgeReviewQuestionItem $authorAge = null;

    #[ORM\ManyToOne(targetEntity: MedicationTimeReviewQuestionItem::class)]
    #[ORM\JoinColumn(name: 'medication_time_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?MedicationTimeReviewQuestionItem $medicationTime = null;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    #[ORM\Column(name: 'full_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $fullName = null;

    #[ORM\Column(name: 'email', type: Types::STRING, length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToOne(targetEntity: ProductReviewQuestionItem::class)]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?ProductReviewQuestionItem $product = null;

    #[ORM\Column(name: 'other_product_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $otherProductName = null;

    #[ORM\Column(name: 'other_product_manufacturer', type: Types::STRING, length: 255, nullable: true)]
    private ?string $otherProductManufacturer = null;

    // not mapped field
    private bool $isCreatedAtChangedManual = false;

    public function changeCreatedAtManual(CarbonImmutable $createdAt): static
    {
        $this->isCreatedAtChangedManual = true;
        $this->setCreatedAt($createdAt);
        $this->setUpdatedAt($createdAt);

        return $this;
    }

    public function prePersist(): void
    {
        if ($this->isCreatedAtChangedManual === false) {
            parent::prePersist();
        }
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function setAuthorName(?string $authorName): static
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getAuthorGender(): ?ReviewAuthorGender
    {
        return $this->authorGender;
    }

    public function setAuthorGender(ReviewAuthorGender|string|null $authorGender): static
    {
        if (is_string($authorGender)) {
            $this->authorGender = ReviewAuthorGender::from($authorGender);
        } else {
            $this->authorGender = $authorGender;
        }

        return $this;
    }

    public function getAuthorType(): ?ReviewAuthorType
    {
        return $this->authorType;
    }

    public function setAuthorType(ReviewAuthorType|string|null $authorType): static
    {
        if (is_string($authorType)) {
            $this->authorType = ReviewAuthorType::from($authorType);
        } else {
            $this->authorType = $authorType;
        }

        return $this;
    }

    public function getEffectiveness(): int
    {
        return $this->effectiveness;
    }

    public function setEffectiveness(int $effectiveness): static
    {
        $this->effectiveness = $effectiveness;

        return $this;
    }

    public function getEaseOfUse(): int
    {
        return $this->easeOfUse;
    }

    public function setEaseOfUse(int $easeOfUse): static
    {
        $this->easeOfUse = $easeOfUse;

        return $this;
    }

    public function getSatisfaction(): int
    {
        return $this->satisfaction;
    }

    public function setSatisfaction(int $satisfaction): static
    {
        $this->satisfaction = $satisfaction;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): static
    {
        $this->site = $site;

        return $this;
    }

    public function getReason(): ?ReasonReviewQuestionItem
    {
        return $this->reason;
    }

    public function setReason(?ReasonReviewQuestionItem $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getAuthorAge(): ?AgeReviewQuestionItem
    {
        return $this->authorAge;
    }

    public function setAuthorAge(?AgeReviewQuestionItem $authorAge): static
    {
        $this->authorAge = $authorAge;

        return $this;
    }

    public function getMedicationTime(): ?MedicationTimeReviewQuestionItem
    {
        return $this->medicationTime;
    }

    public function setMedicationTime(?MedicationTimeReviewQuestionItem $medicationTime): static
    {
        $this->medicationTime = $medicationTime;

        return $this;
    }

    public function __toString(): string
    {
        $labels = [];

        if ($this->getAuthorName()) {
            $labels[] = $this->getAuthorName();
        }

        if ($this->getContent()) {
            $postfix  = mb_strlen($this->getContent()) > self::$maxDescriptionLength ? '...' : '';
            $labels[] = mb_substr($this->getContent(), 0, self::$maxDescriptionLength) . $postfix;
        }

        if ($labels) {
            return implode(': ', $labels);
        }

        return $this->getBriefInfo() ?? 'New Entity';
    }

    public function getBriefInfo(): ?string
    {
        $labels = [];

        if ($this->getAuthorName()) {
            $labels[] = $this->getAuthorName();
        }

        if ($this->getContent()) {
            $postfix  = mb_strlen($this->getContent()) > self::$maxDescriptionLength ? '...' : '';
            $labels[] = mb_substr($this->getContent(), 0, self::$maxDescriptionLength) . $postfix;
        }

        return $labels
            ? implode(': ', $labels)
            : null;
    }

    public function getLikeQuantity(): ?int
    {
        return $this->likeQuantity;
    }

    public function setLikeQuantity(int $likeQuantity): static
    {
        $this->likeQuantity = $likeQuantity;

        return $this;
    }

    public function getDislikeQuantity(): ?int
    {
        return $this->dislikeQuantity;
    }

    public function setDislikeQuantity(int $dislikeQuantity): static
    {
        $this->dislikeQuantity = $dislikeQuantity;

        return $this;
    }

    public function getReportQuantity(): ?int
    {
        return $this->reportQuantity;
    }

    public function setReportQuantity(int $reportQuantity): static
    {
        $this->reportQuantity = $reportQuantity;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getOtherProductName(): ?string
    {
        return $this->otherProductName;
    }

    public function setOtherProductName(?string $otherProductName): static
    {
        $this->otherProductName = $otherProductName;

        return $this;
    }

    public function getOtherProductManufacturer(): ?string
    {
        return $this->otherProductManufacturer;
    }

    public function setOtherProductManufacturer(?string $otherProductManufacturer): static
    {
        $this->otherProductManufacturer = $otherProductManufacturer;

        return $this;
    }

    public function getProduct(): ?ProductReviewQuestionItem
    {
        return $this->product;
    }

    public function setProduct(?ProductReviewQuestionItem $product): static
    {
        $this->product = $product;

        return $this;
    }
}
