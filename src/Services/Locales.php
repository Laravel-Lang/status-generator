<?php

namespace LaravelLang\StatusGenerator\Services;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Concerns\Files;
use LaravelLang\StatusGenerator\Helpers\Inline;
use LaravelLang\StatusGenerator\Services\Filesystem\Manager;

class Locales
{
    use Files;

    protected array $source = [];

    protected array $locales = [];

    protected array $excludes = [];

    protected array $not_translatable = [];

    protected array $skip = [
        '*',
        '-',
        '—',
        'custom.attribute-name.rule-name',
    ];

    public function __construct(
        protected Manager $filesystem = new Manager(),
        protected Inline $inline = new Inline()
    ) {}

    public function load(string $source, string $locales): Locales
    {
        if (empty($this->source)) {
            $this->loadSource($source);
            $this->sort($this->source);
        }

        if (empty($this->locales)) {
            $this->loadLocales($locales);
            $this->sort($this->locales);
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

    public function getNotTranslatable(string $locale): array
    {
        return $this->not_translatable[$locale] ?? [];
    }

    protected function loadSource(string $path): Locales
    {
        foreach ($this->files($path) as $file) {
            $key = $this->isJson($file) ? 'json' : 'php';

            $values = $this->read($file);

            $this->pushSource($key, $values);
        }

        return $this;
    }

    protected function loadLocales(string $path): Locales
    {
        foreach ($this->localesDirectories($path) as $locale) {
            foreach ($this->files($path . '/' . $locale) as $file) {
                $key = Path::filename($file);

                $values = $this->read($file);

                if ($this->isExcludes($file)) {
                    $this->pushExcludes($locale, $values);

                    continue;
                }

                if ($this->isNotTranslatable($file)) {
                    $this->pushNotTranslatable($locale, $values);

                    continue;
                }

                $this->pushLocales($locale, $key, $values);
            }
        }

        return $this;
    }

    protected function pushSource(string $key, array $values): void
    {
        foreach (Arr::flattenKeys($values) as $flatten_key => $flatten_value) {
            if ($this->hasSkip($flatten_key, $flatten_value)) {
                continue;
            }

            $this->source[$key][$flatten_key] = $flatten_value;

            if (Str::of($flatten_value)->lower()->contains(':attribute')) {
                $this->source[$key . '-inline'][$flatten_key] = $this->inline->resolve($flatten_value);
            }
        }
    }

    protected function pushExcludes(string $locale, array $values): void
    {
        $this->excludes[$locale] = Arr::addUnique($this->excludes[$locale] ?? [], array_values($values));
    }

    protected function pushNotTranslatable(string $locale, array $values): void
    {
        $this->not_translatable[$locale]
            = Arr::addUnique($this->not_translatable[$locale] ?? [], array_values($values));
    }

    protected function pushLocales(string $locale, string $key, array $values): void
    {
        foreach ($values as $locale_key => $locale_value) {
            if ($this->hasSkip($locale_key, $locale_value)) {
                continue;
            }

            $this->locales[$locale][$key][$locale_key] = $locale_value;
        }
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

    protected function hasSkip(string $key, mixed $value): bool
    {
        return empty($value) || in_array($key, $this->skip);
    }

    protected function sort(&$array): void
    {
        $array = Arr::ksort($array);
    }
}
