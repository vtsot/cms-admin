<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\RMI;

enum LinkType: string
{
    // @todo need to notify about this since all type must be handled
    case Unknown      = 'unknown';
    case Info         = 'info';
    case Image        = 'image';
    case Guide        = 'guide';
    case RepairManual = 'repair_manual';
    case Lubricant    = 'lubricant';
    case Drawing      = 'drawing';
    case Equipment    = 'equipment';
    case Brakes       = 'brakes';

    public static function fromHP(?string $type): LinkType
    {
        return match ($type) {
            'getDrawings'          => self::Drawing,
            'getStoryInfo'         => self::RepairManual,
            'getLubricantsByGroup' => self::Lubricant,
            'getIdLocationV2'      => self::Equipment,
            'getAdjustments'       => self::Brakes,
            'IMAGE'                => self::Image,
            null                   => self::Info,
            default                => self::Unknown,
        };
    }
}
