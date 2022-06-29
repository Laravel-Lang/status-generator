<?php

namespace LaravelLang\StatusGenerator\Services;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Facades\Helpers\ArrayMerge;

class Translations
{
    protected array $values = [];

    public function merge(string $locale, array $values, bool $is_json, bool $is_inline): void
    {
        $section = $this->getSectionName($is_json, $is_inline);

        $items = ArrayMerge::merge($this->section($locale, $section), $values);

        $this->set($locale, $section, $items);
    }

    public function all(): array
    {
        return $this->values;
    }

    public function section(string $locale, string $section): array
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

    protected function getSectionName(bool $is_json, bool $is_inline): string
    {
        return Arr::of([])
            ->push($is_json ? 'json' : 'php')
            ->push($is_inline ? 'inline' : null)
            ->filter()
            ->implode('-');
    }
}
