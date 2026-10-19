<?php

declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait PriorityEntityTrait
{
    #[ORM\Column(name: 'priority', type: Types::INTEGER, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    private int $priority = 0;

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }
}
