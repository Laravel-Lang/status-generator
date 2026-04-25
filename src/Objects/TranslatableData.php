<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Objects;

use DragonCode\Support\Facades\Helpers\Str;

class TranslatableData
{
    public ?string $value = null;

    public function __construct(
        ?string $value = null,
        public array $replaces = [],
    ) {
        $this->value = $this->castValue($value);
    }

    public function compile(string $translated): string
    {
        return Str::replace($translated, array_values($this->replaces), array_keys($this->replaces));
    }

    protected function castValue(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        $this->extract($value);

        return Str::replace($value, array_keys($this->replaces), array_values($this->replaces));
    }

    protected function extract(?string $value): void
    {
        if (! $value) {
            return;
        }

        Str::of($value)
            ->matchAll('/:\w+/')
            ->tap(fn (string $match) => $this->keyable($match));
    }

    protected function keyable(string $value): void
    {
        if (! isset($this->replaces[$value])) {
            $this->replaces[$value] = (count($this->replaces) + 1) * 10;
        }
    }
}
