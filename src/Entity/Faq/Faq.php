<?php

declare(strict_types=1);

namespace App\Entity\Faq;

use App\Entity\AbstractEntity;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\ContentEntityTrait;
use App\Entity\Traits\PositionEntityTrait;
use App\Entity\Traits\TitleEntityTrait;
use App\Repository\Faq\FaqRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'faqs')]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'fk_faq_group_id', columns: ['faq_group_id'])]
#[ORM\Entity(repositoryClass: FaqRepository::class)]
class Faq extends AbstractEntity
{
    use PositionEntityTrait;
    use ActiveEntityTrait;
    use TitleEntityTrait;
    use ContentEntityTrait;

    #[ORM\ManyToOne(targetEntity: FaqGroup::class, inversedBy: 'faqs')]
    #[ORM\JoinColumn(name: 'faq_group_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private FaqGroup $faqGroup;

    public function getFaqGroup(): ?FaqGroup
    {
        return $this->faqGroup;
    }

    public function setFaqGroup(?FaqGroup $faqGroup): self
    {
        $this->faqGroup = $faqGroup;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?? 'New Entity';
    }
}
