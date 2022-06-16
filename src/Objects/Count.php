<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Objects;

use DragonCode\SimpleDataTransferObject\DataTransferObject;
use JetBrains\PhpStorm\ArrayShape;

class Count extends DataTransferObject
{
    public ?string $locale = null;

    public int $all = 0;

    public int $missing = 0;

    public function getComplete(): float
    {
        return round(($this->all - $this->missing) / $this->all * 100, 2);
    }

    public function isComplete(): bool
    {
        return empty($this->missing);
    }

    #[ArrayShape(['locale' => 'null|string', 'all' => 'int', 'missing' => 'int', 'complete' => 'float'])]
    public function toArray(): array
    {
        return [
            'locale'   => $this->locale,
            'all'      => $this->all,
            'missing'  => $this->missing,
            'complete' => $this->getComplete(),
        ];
    }
}
