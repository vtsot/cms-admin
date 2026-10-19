<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\SupportRequest;

use App\Contract\Dictionary\Traits\EnumValuesTrait;
use App\Exception\AppException;

enum SupportRequestStatus: string
{
    use EnumValuesTrait;

    case Open             = 'open';
    case Forwarded        = 'forwarded';
    case InProcess        = 'in_process';
    case WaitingForRecall = 'waiting_for_recall';
    case Insolvable       = 'insolvable';
    case Done             = 'done';

    public static function fromHgStatus(int $hgStatus): SupportRequestStatus
    {
        return match ($hgStatus) {
            1       => self::Open,
            2       => self::Forwarded,
            3       => self::InProcess,
            4       => self::WaitingForRecall,
            5       => self::Insolvable,
            6       => self::Done,
            default => throw new AppException('Wrong status'),
        };
    }
}
