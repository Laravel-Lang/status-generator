<?php

namespace LaravelLang\StatusGenerator\Services;

use DragonCode\Support\Facades\Helpers\Arr;

class Translations
{
    protected array $values = [];

    public function merge(string $locale, array $values, bool $is_json, bool $is_inline): void
    {
        $section = $this->section($is_json, $is_inline);

        $this->set($locale, $section, array_merge($this->get($locale, $section), $values));
    }

    public function all(): array
    {
        return $this->values;
    }

    public function get(string $locale, string $section): array
    {
        return $this->values[$locale][$section] ?? [];
    }

    public function value(string $locale, string $section, string $key): ?string
    {
        return $this->values[$locale][$section][$key] ?? null;
    }

    protected function set(string $locale, string $filename, array $values): void
    {
        $this->values[$locale][$filename] = $values;
    }

    protected function section(bool $is_json, bool $is_inline): string
    {
        return Arr::of([])
            ->push($is_json ? 'json' : 'php')
            ->push($is_inline ? 'inline' : null)
            ->filter()
            ->implode('-');
    }
}
