<?php

declare(strict_types=1);

namespace LaravelLang\StatusGeneratorTests\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;

trait Path
{
    protected string $base_path;

    protected function getPath(string ...$path): string
    {
        return Arr::of($path)
            ->map(static fn (string $value) => trim($value, '\\/'))
            ->implode('/')
            ->prepend('/')
            ->prepend($this->base_path)
            ->toString();
    }
}
