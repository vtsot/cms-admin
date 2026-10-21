<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Data\RandomItemDTO;
use Throwable;

use function array_column;
use function array_rand;
use function array_sum;
use function random_int;

class RandomizeService
{
    /**
     * @param array<int, RandomItemDTO> $items
     */
    public function getRandomItem(array $items): ?RandomItemDTO
    {
        // Calculate total priority
        $total = array_sum(array_column($items, 'priority'));

        try {
            // pick a random number between 1 and $total
            $rand = random_int(1, $total > 0 ? $total : 1);
        } catch (Throwable) {
            return $items ? $items[array_rand($items)] : null;
        }

        // Iterate and find the selected item
        $current = 0;

        foreach ($items as $item) {
            $current += $item->priority;

            if ($rand <= $current) {
                return $item;
            }
        }

        return null;
    }
}
