<?php

declare(strict_types=1);

namespace App\DTOFactory\CmsEmbed;

use App\Contract\CmsEmbed\CmsEmbedInterface;
use App\DTO\CmsEmbed\CmsEmbedDTO;

class CmsEmbedDTOFactory
{
    public function fromCmsEmbed(CmsEmbedInterface $cmsEmbed): CmsEmbedDTO
    {
        return new CmsEmbedDTO(
            $cmsEmbed->getId(),
            $cmsEmbed->getLabel(),
            $cmsEmbed->getHelp(),
            $cmsEmbed->getPlaceholder(),
            $cmsEmbed->getParams(),
        );
    }
}
