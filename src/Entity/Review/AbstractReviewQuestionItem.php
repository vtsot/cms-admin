<?php

declare(strict_types=1);

namespace App\Entity\Review;

use App\Contract\Dictionary\Review\ReviewQuestionType;
use App\Entity\AbstractEntity;
use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\PositionEntityTrait;
use App\Entity\Traits\TitleEntityTrait;
use App\Repository\Review\AbstractReviewQuestionItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'review_question_items')]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'entity', type: Types::STRING)]
#[ORM\DiscriminatorMap([
    'reason'          => ReasonReviewQuestionItem::class,
    'age'             => AgeReviewQuestionItem::class,
    'medication_time' => MedicationTimeReviewQuestionItem::class,
    'product'         => ProductReviewQuestionItem::class,
])]
#[ORM\Entity(repositoryClass: AbstractReviewQuestionItemRepository::class)]
abstract class AbstractReviewQuestionItem extends AbstractEntity
{
    use TitleEntityTrait;
    use ActiveEntityTrait;
    use PositionEntityTrait;

    #[ORM\Column(name: 'type', type: Types::STRING, length: 255, nullable: true, enumType: ReviewQuestionType::class)]
    private ?ReviewQuestionType $type = null;

    #[ORM\ManyToOne(targetEntity: Site::class)]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    public function __toString(): string
    {
        return $this->getTitle() ?: 'New entity';
    }

    public function getType(): ?ReviewQuestionType
    {
        return $this->type;
    }

    public function setType(?ReviewQuestionType $type): self
    {
        $this->type = $type;

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
}
