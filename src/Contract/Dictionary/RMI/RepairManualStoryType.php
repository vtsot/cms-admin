<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\RMI;

enum RepairManualStoryType: string
{
    case Header     = 'header';
    case Sentence   = 'sentence';
    case BulletList = 'bullet_list';

    case BreakContentBlock = 'break_content_block';

    case TableContentBlock = 'table_content_block';

    case ImageContentBlock = 'image_content_block';

    case TextContentBlock = 'text_content_block';

    public static function fromHP(?string $style): self
    {
        return match ($style) {
            'BULLET_LIST'  => self::BulletList,
            'HEADER_STYLE' => self::Header,
            default        => self::Sentence,
        };
    }

    public static function fromHG(?string $type): self
    {
        return match ($type) {
            'BreakContentBlock' => self::BreakContentBlock,
            'TableContentBlock' => self::TableContentBlock,
            'ImageContentBlock' => self::ImageContentBlock,
            default             => self::TextContentBlock,
        };
    }

    public function toHG(): string
    {
        return match ($this) {
            self::BreakContentBlock => 'BreakContentBlock',
            self::TableContentBlock => 'TableContentBlock',
            self::ImageContentBlock => 'ImageContentBlock',
            default                 => 'TextContentBlock',
        };
    }
}
