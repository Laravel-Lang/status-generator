<?php

namespace LaravelLang\StatusGenerator\Services;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Concerns\Files;
use LaravelLang\StatusGenerator\Services\Filesystem\Manager;

class Locales
{
    use Files;

    protected array $source = [];

    protected array $locales = [];

    protected array $excludes = [];

    protected array $ignore = [
        'validation' => ['attributes', 'custom'],
    ];

    public function __construct(
        protected Manager $filesystem = new Manager()
    ) {
    }

    public function load(string $source, string $locales): Locales
    {
        if (empty($this->source)) {
            $this->loadSource($source);
        }

        if (empty($this->locales)) {
            $this->loadLocales($locales);
        }

        return $this;
    }

    public function getSource(): array
    {
        return $this->source;
    }

    public function getLocale(string $locale): array
    {
        return $this->locales[$locale] ?? [];
    }

    public function getExcludes(string $locale): array
    {
        return $this->excludes[$locale] ?? [];
    }

    protected function loadSource(string $path): Locales
    {
        foreach ($this->files($path) as $file) {
            $key = $this->getKey($file);

            $values = $this->read($file);
            $values = $this->filter($file, $values);

            $this->mergeSource($key, $values);
        }

        return $this;
    }

    protected function loadLocales(string $path): Locales
    {
        foreach ($this->localesDirectories($path) as $locale) {
            foreach ($this->files($path . '/' . $locale) as $file) {
                $key = $this->getKey($file);

                $values = $this->read($file);

                $this->isExcludes($file)
                    ? $this->mergeExcludes($locale, $values)
                    : $this->mergeLocales($locale, $key, $values);
            }
        }

        return $this;
    }

    protected function mergeSource(string $key, array $values): void
    {
        $this->source[$key] = Arr::addUnique($this->source[$key] ?? [], Arr::flattenKeys($values));
    }

    protected function mergeExcludes(string $locale, array $values): void
    {
        $this->excludes[$locale] = Arr::addUnique($this->excludes[$locale] ?? [], array_values($values));
    }

    protected function mergeLocales(string $locale, string $key, array $values): void
    {
        $this->locales[$locale][$key] = Arr::addUnique($this->locales[$locale][$key] ?? [], $values);
    }

    protected function filter(string $path, array $values): array
    {
        foreach ($this->ignore as $contains => $ignore) {
            if ($this->isFileContains($path, $contains)) {
                return Arr::except($values, $ignore);
            }
        }

        return $values;
    }

    protected function read(string $path): array
    {
        return $this->filesystem->load($path);
    }

    protected function localesDirectories(string $path): array
    {
        return Directory::names($path);
    }

    protected function files(string $path): array
    {
        $files = File::names($path, recursive: true);

        return Arr::of($files)
            ->map(static fn (string $filename) => Str::of($filename)
                ->ltrim('\\/')
                ->prepend('/')
                ->prepend(rtrim($path, '\\/'))
                ->toString())
            ->toArray();
    }

    protected function getKey(string $path): string
    {
        return match (true) {
            $this->isJson($path) && $this->isInline($path)   => 'json-inline.json',
            $this->isJson($path) && ! $this->isInline($path) => 'json.json',
            $this->isPhp($path) && $this->isInline($path)    => 'php-inline.json',
            $this->isPhp($path) && ! $this->isInline($path)  => 'php.json'
        };
    }
}
