<?php

declare(strict_types=1);

namespace App\Contract\Entity;

use App\Contract\Dictionary\Link\LinkTarget;
use App\Contract\Dictionary\Link\LinkType;
use App\Entity\Page\Article;
use App\Entity\Page\Page;

interface LinkEntityInterface
{
    public const TARGET_TOP   = LinkTarget::Top->value;
    public const TARGET_BLANK = LinkTarget::Blank->value;

    public const LINK_TYPE_PAGE          = LinkType::Page->value;
    public const LINK_TYPE_EXTERNAL_LINK = LinkType::Link->value;
    public const LINK_TYPE_NONE          = LinkType::None->value;
    public const LINK_TYPE_ARTICLE       = LinkType::Article->value;

    public function getLinkType(): ?string;

    public function getLinkPage(): ?Page;

    public function getLinkUrl(): ?string;

    public function getLinkTarget(): ?string;

    public function isLinkNoFollow(): bool;

    public function getLinkArticle(): ?Article;
}
