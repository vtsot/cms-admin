<?php

declare(strict_types=1);

namespace App\Entity\Faq;

use App\Entity\AbstractEntity;
use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\TitleEntityTrait;
use App\Repository\Faq\FaqGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'faq_groups')]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Entity(repositoryClass: FaqGroupRepository::class)]
class FaqGroup extends AbstractEntity
{
    use TitleEntityTrait;
    use ActiveEntityTrait;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'faqGroups')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    #[ORM\OneToMany(targetEntity: Faq::class, mappedBy: 'faqGroup')]
    private Collection $faqs;

    public function __construct()
    {
        parent::__construct();

        $this->faqs = new ArrayCollection();
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection<int, Faq>
     */
    public function getFaqs(): Collection
    {
        return $this->faqs;
    }

    public function addFaq(Faq $faq): self
    {
        if (!$this->faqs->contains($faq)) {
            $this->faqs->add($faq);
            $faq->setFaqGroup($this);
        }

        return $this;
    }

    public function removeFaq(Faq $faq): self
    {
        if ($this->faqs->removeElement($faq)) {
            // set the owning side to null (unless already changed)
            if ($faq->getFaqGroup() === $this) {
                $faq->setFaqGroup(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?: 'New entity';
    }
}
