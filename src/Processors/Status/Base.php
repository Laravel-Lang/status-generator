<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Status;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Processors\Processor;
use LaravelLang\StatusGenerator\Services\Counter;
use LaravelLang\StatusGenerator\Services\Translations;

abstract class Base extends Processor
{
    protected ?Translations $source_translations = null;

    protected ?Counter $counter = null;

    protected string $default_locale = 'en';

    abstract protected function prepare(): void;

    abstract protected function store(): void;

    public function handle(): void
    {
        $this->init();

        $this->collectSource();
        $this->collectLocales();

        $this->prepare();
        $this->store();
    }

    protected function init(): void
    {
        $this->source_translations = new Translations();

        $this->counter = new Counter();
    }

    protected function collectSource(): void
    {
        foreach ($this->files($this->getSourcePath()) as $file) {
            $path = $this->getSourcePath($file);

            $is_json   = $this->isJson($path);
            $is_inline = $this->isInline($path);

            $this->source_translations->merge($this->default_locale, $this->load($path), $is_json, $is_inline);
        }
    }

    protected function collectLocales(): void
    {
        foreach ($this->directories() as $locale) {
            if ($locale !== $this->default_locale) {
                $this->collectLocale($locale);
            }
        }
    }

    protected function collectLocale(string $locale): void
    {
        foreach ($this->files($this->getLocalesPath($locale)) as $file) {
            $path = $this->getLocalesPath($locale . '/' . $file);

            $is_json   = $this->isJson($path, false);
            $is_inline = $this->isInline($path);

            $section = $this->section($is_json, $is_inline);

            if ($values = $this->filter($locale, $section, $this->load($path), $this->excludes($locale))) {
                $this->translations->merge($locale, $values, $is_json, $is_inline);
            }
        }
    }

    protected function filter(string $locale, string $section, array $values, array $excludes): array
    {
        $source = $this->source_translations->section($this->default_locale, $section);

        return Arr::of($values)
            ->filter(function (string $value, string $key) use ($locale, $excludes, $source) {
                $this->counter->incrementAll($locale);

                if (! in_array($value, $excludes) && Arr::get($source, $key) === $value) {
                    $this->counter->incrementMissing($locale);

                    return true;
                }

                return false;
            }, ARRAY_FILTER_USE_BOTH)
            ->toArray();
    }

    protected function files(string $path): array
    {
        return File::names($path, fn (string $name) => ! $this->isExcludes($name), recursive: true);
    }

    protected function excludes(string $locale): array
    {
        if ($path = $this->getLocalesPath($locale . '/_excludes.json')) {
            return $this->load($path);
        }

        return [];
    }

    protected function section(bool $is_json, bool $is_inline): string
    {
        $json   = $is_json ? 'json' : 'php';
        $inline = $is_inline ? '-inline' : '';

        return $json . $inline;
    }
}
