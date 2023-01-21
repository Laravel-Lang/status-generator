<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Objects;

use DragonCode\SimpleDataTransferObject\DataTransferObject;
use DragonCode\Support\Facades\Helpers\Str;

class Translatable extends DataTransferObject
{
    public ?string $value = null;

    public array $replaces = [];

    public function compile(string $translated): string
    {
        return Str::replace($translated, array_values($this->replaces), array_keys($this->replaces));
    }

    protected function castValue(string $value): string
    {
        $this->extractReplaces($value);

        return $this->replaceValue($value);
    }

    protected function extractReplaces(string $value): void
    {
        Str::of($value)
            ->trim()
            ->trim('.?!')
            ->explode(' ')
            ->map(function (string $item) {
                if (Str::startsWith($item, ':')) {
                    return $this->numerify($item);
                }

                return $item;
            });
    }

    protected function replaceValue(string $value): string
    {
        return Str::replace($value, array_keys($this->replaces), array_values($this->replaces));
    }

    protected function numerify(string $value): int
    {
        if (isset($this->replaces[$value])) {
            return $this->replaces[$value];
        }

        return $this->replaces[$value] = (count($this->replaces) + 1) * 100;
    }
}
