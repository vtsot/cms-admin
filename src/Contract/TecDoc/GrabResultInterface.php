<?php

declare(strict_types=1);

namespace App\Contract\TecDoc;

interface GrabResultInterface
{
    public function incrementNew(): void;

    public function incrementExisting(): void;

    public function append(GrabResultInterface $result): void;

    public function totalCount(): int;

    public function newCount(): int;

    public function existingCount(): int;

    public function isEmpty(): bool;
}
