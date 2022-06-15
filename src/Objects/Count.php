<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Objects;

use DragonCode\SimpleDataTransferObject\DataTransferObject;

class Count extends DataTransferObject
{
    public ?string $locale = null;

    public int $all = 0;

    public int $missing = 0;

    public float $complete = 0.0;

    public function isComplete(): bool
    {
        return empty($this->missing);
    }
}
