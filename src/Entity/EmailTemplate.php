<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\CodeEntityTrait;
use App\Entity\Traits\EmailTemplate\HtmlEntityTrait;
use App\Entity\Traits\EmailTemplate\ReplyToEntityTrait;
use App\Entity\Traits\EmailTemplate\SendToEntityTrait;
use App\Entity\Traits\EmailTemplate\SendToManagersActiveEntityTrait;
use App\Entity\Traits\EmailTemplate\SubjectEntityTrait;
use App\Entity\Traits\EmailTemplate\TextEntityTrait;
use App\Repository\EmailTemplateRepository;
use Doctrine\ORM\Mapping as ORM;

use function array_filter;
use function implode;

#[ORM\Table(name: 'email_templates')]
#[ORM\UniqueConstraint(name: 'uniq_site_code', columns: ['code', 'site_id'])]
#[ORM\Index(name: 'fk_site_id', columns: ['site_id'])]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'idx_send_to_managers_active', columns: ['send_to_managers_active'])]
#[ORM\Entity(repositoryClass: EmailTemplateRepository::class)]
class EmailTemplate extends AbstractEntity
{
    use ActiveEntityTrait;
    use CodeEntityTrait;
    use SendToManagersActiveEntityTrait;
    use SendToEntityTrait;
    use ReplyToEntityTrait;
    use SubjectEntityTrait;
    use HtmlEntityTrait;
    use TextEntityTrait;

    public const CODE_CONTACT                   = 'CONTACT';
    public const CODE_EXPIRATION_4_WEEKS_BEFORE = 'EXPIRATION-4-WEEKS-BEFORE';
    public const CODE_EXPIRATION_2_WEEKS_BEFORE = 'EXPIRATION-2-WEEKS-BEFORE';
    public const CODE_EXPIRATION_1_DAY_BEFORE   = 'EXPIRATION-1-DAY-BEFORE';

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'emailTemplates')]
    #[ORM\JoinColumn(name: 'site_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Site $site = null;

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getCreatedAt() === null ? 'New Entity' : null;
        $labels[] = $this->getCode();

        return implode(' ', array_filter($labels));
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
