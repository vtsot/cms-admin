<?php

declare(strict_types=1);

namespace App\Contract\Entity;

use App\Entity\MegaMenu\MegaMenu;

interface MegaMenuAwareInterface
{
    public function getMegaMenu(): ?MegaMenu;

    public function setMegaMenu(?MegaMenu $megaMenu): self;
}
