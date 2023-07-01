<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Translate;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Helpers\Translators\TranslateManager;
use LaravelLang\StatusGenerator\Processors\Processor;

class Translate extends Processor
{
    public function handle(): void
    {
        $source = $this->locales()->getSource();

        foreach ($this->getLocales() as $locale) {
            $this->output->task($locale, function () use ($locale, $source) {
                $locales          = $this->locales()->getLocale($locale);
                $excludes         = $this->locales()->getExcludes($locale);
                $not_translatable = $this->locales()->getNotTranslatable($locale);

                $excludes = array_merge($excludes, $not_translatable);

                foreach ($source as $file => $source_values) {
                    $path = $this->getTargetFilename($locale, $file);

                    $locale_values = Arr::get($locales, $file, []);

                    $result = $this->merge($source_values, $locale_values, $excludes, $locale);

                    ! empty($result) ? $this->store($path, $result) : $this->delete($path);
                }
            });
        }

        $this->output->emptyLine();
    }

    protected function merge(array $source, array $target, array $excludes, string $locale): array
    {
        Arr::of($target)
            ->only(Arr::keys($source))
            ->tap(function (string $value, int|string $key) use (&$source, $excludes, $locale) {
                $source[$key] = $this->isTranslatable($excludes, $source, $key, $value)
                    ? $this->translate($value, $locale)
                    : $value;
            });

        return $source;
    }

    protected function translate(string $value, string $locale): string
    {
        return TranslateManager::translate($value, $locale);
    }

    protected function store(string $path, array $values): void
    {
        $this->filesystem->store($path, $values, false);
    }

    protected function delete(string $path): void
    {
        File::ensureDelete($path);
    }

    protected function getTargetFilename(string $locale, string $filename): string
    {
        return $this->getLocalesPath($locale . '/' . $filename . '.json', false);
    }

    protected function isTranslatable(array $excludes, array $source, int|string $key, string $value): bool
    {
        return $this->isSameValue($source, $key, $value) && $this->doesntExclude($excludes, $value);
    }

    protected function isSameValue(array $source, int|string $key, string $value): bool
    {
        $value        = Str::lower($value);
        $source_value = Str::lower($source[$key] ?? '');
        $inline       = Str::replace($source_value, 'the :attribute', 'this field');

        return in_array(trim($value), [trim($source_value), trim($inline)]);
    }

    protected function doesntExclude(array $excludes, string $value): bool
    {
        return ! in_array($value, $excludes) && ! array_key_exists($value, $excludes);
    }

    protected function getLocales(): array
    {
        if ($locale = $this->getLocaleParameter()) {
            return Arr::filter($this->directories(), fn (string $dir) => $dir === $locale);
        }

        return $this->directories();
    }
}
