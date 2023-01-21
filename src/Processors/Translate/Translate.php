<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Translate;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Helpers\GoogleLocale;
use LaravelLang\StatusGenerator\Processors\Processor;

class Translate extends Processor
{
    public function handle(): void
    {
        $source = $this->locales()->getSource();

        foreach ($this->directories() as $locale) {
            $this->output->task($locale . ' translation', function () use ($locale, $source) {
                $locales = $this->locales()->getLocale($locale);

                foreach ($source as $file => $source_values) {
                    $path = $this->getTargetFilename($locale, $file);

                    $locale_values = Arr::get($locales, $file, []);

                    $result = $this->merge($source_values, $locale_values, $locale);

                    ! empty($result) ? $this->store($path, $result) : $this->delete($path);
                }
            });
        }

        $this->output->emptyLine();
    }

    protected function merge(array $source, array $target, string $locale): array
    {
        $target = Arr::only($target, Arr::keys($source));

        foreach ($target as $key => $value) {
            $source[$key] = $this->isSameKey($source, $key, $value) ? $this->translate($value, $locale) : $value;
        }

        return $source;
    }

    protected function translate(string $value, string $locale): string
    {
        return GoogleLocale::translate($value, $locale);
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

    protected function isSameKey(array $source, int|string $key, string $value): bool
    {
        return ($source[$key] ?? null) === $value;
    }
}
