<?php

namespace LaravelLang\StatusGenerator\Services;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Concerns\Files;
use LaravelLang\StatusGenerator\Services\Filesystem\Manager;

class Locales
{
    use Files;

    protected string $default_locale = 'en';

    protected array $source = [];

    protected array $locales = [];

    protected array $excludes = [];

    protected array $ignore = [
        'validation' => ['attributes', 'custom'],
    ];

    protected array $inline_replaces = [
        [
            'The :attribute' => 'This field',
            'The :Attribute' => 'This field',
            'The :ATTRIBUTE' => 'This field',
        ],

        [
            ':attribute' => 'field',
            ':Attribute' => 'field',
            ':ATTRIBUTE' => 'field',
        ],

        [
            'field field' => 'field',
        ],
    ];

    protected array $skip = [
        '*',
        '-',
        '—',
        'custom.attribute-name.rule-name',
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

        $this->sort($this->source);
        $this->sort($this->locales);

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
            $key = $this->isJson($file) ? 'json' : 'php';

            $values = $this->read($file);
            $values = $this->filter($file, $values);

            $this->pushSource($key, $values);
        }

        return $this;
    }

    protected function loadLocales(string $path): Locales
    {
        foreach ($this->localesDirectories($path) as $locale) {
            foreach ($this->files($path . '/' . $locale) as $file) {
                $key = Path::filename($file);

                $values = $locale === $this->default_locale
                    ? $this->getSource()[$key]
                    : $this->read($file);

                $this->isExcludes($file)
                    ? $this->pushExcludes($locale, $values)
                    : $this->pushLocales($locale, $key, $values);
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
                foreach ($this->inline_replaces as $replaces) {
                    $flatten_value = Str::replace($flatten_value, array_keys($replaces), array_values($replaces));
                }

                $this->source[$key . '-inline'][$flatten_key] = $flatten_value;
            }
        }
    }

    protected function pushExcludes(string $locale, array $values): void
    {
        $this->excludes[$locale] = Arr::addUnique($this->excludes[$locale] ?? [], array_values($values));
    }

    protected function pushLocales(string $locale, string $key, array $values): void
    {
        foreach ($values as $locale_key => $locale_value) {
            if ($this->hasSkip($locale_key, $locale_value)) {
                continue;
            }

            $this->locales[$locale][$key][$locale_key] = $this->correctFirstChar($locale_value);
        }
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

    protected function correctFirstChar(string $value): string
    {
        if (Str::startsWith($value, ':')) {
            $start = Str::of($value)->trim()->substr(0, 2)->upper();
            $end   = Str::of($value)->trim()->substr(2);

            return $start . $end;
        }

        return trim($value);
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
