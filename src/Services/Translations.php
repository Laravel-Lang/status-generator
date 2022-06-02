<?php

namespace LaravelLang\StatusGenerator\Services;

use DragonCode\Support\Facades\Helpers\Arr;

class Translations
{
    protected array $values = [];

    public function merge(string $locale, array $values, bool $is_json, bool $is_inline): void
    {
        $filename = $this->filename($is_json, $is_inline);

        $this->set($locale, $filename, array_merge($this->get($locale, $filename), $values));
    }

    public function all(): array
    {
        return $this->values;
    }

    public function get(string $locale, string $filename): array
    {
        return $this->values[$locale][$filename] ?? [];
    }

    protected function set(string $locale, string $filename, array $values): void
    {
        $this->values[$locale][$filename] = $values;
    }

    protected function filename(bool $is_json, bool $is_inline): string
    {
        return Arr::of([])
            ->push($is_json ? 'json' : 'php')
            ->push($is_inline ? 'inline' : null)
            ->filter()
            ->implode('-');
    }
}
