<?php

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Concerns\Arrayable;
use LaravelLang\StatusGenerator\Processors\Processor;

class Locales extends Processor
{
    use Arrayable;

    protected array $files = [];

    public function handle(): void
    {
        $this->collectLocales();
        $this->collectEnglish();

        $this->store();
        $this->clean();

        $this->copyExcludes();
    }

    protected function collectLocales(): void
    {
        foreach ($this->directories() as $locale) {
            $this->collect($locale);
        }
    }

    protected function collectEnglish(string $locale = 'en'): void
    {
        $this->collect($locale);
    }

    protected function collect(string $locale): void
    {
        $this->output->writeln('Processing: ' . $locale);

        $is_english = $locale === 'en';

        $lang_path = $is_english ? $this->getSourcePath() : null;

        foreach ($this->files($locale, $lang_path) as $file) {
            $path = $is_english
                ? $this->getSourcePath($file)
                : $this->getLocalesPath($locale . '/' . $file);

            $is_json   = $this->isJson($path);
            $is_inline = $this->isInline($path);

            $this->setTranslations($locale, $path, $is_json, $is_inline, $is_english);
        }
    }

    protected function store(): void
    {
        foreach ($this->translations->all() as $locale => $items) {
            foreach ($items as $filename => $values) {
                $path = $this->getLocalesPath($locale . '/' . $filename . '.json', false);

                $values = $this->ksort($values);

                $this->filesystem->store($path, $values, false);
            }
        }
    }

    protected function copyExcludes(): void
    {
        foreach ($this->directories() as $locale) {
            $source = $this->getPath(true, $this->base_path, 'excludes', $locale . '.php');
            $target = $this->getLocalesPath($locale . '/_excludes.json', false);

            if ($source && File::exists($source)) {
                $values = $this->filesystem->load($source);

                if (! empty($values)) {
                    $this->filesystem->store($target, $values, true);
                }
            }
        }
    }

    protected function clean(): void
    {
        foreach ($this->directories() as $locale) {
            foreach ($this->files($locale) as $file) {
                $path = $this->getLocalesPath($locale . '/' . $file);

                File::ensureDelete($path);
            }
        }
    }

    protected function setTranslations(string $locale, string $path, bool $is_json, bool $is_inline, bool $correct_keys = false): void
    {
        $values = $this->load($path, $correct_keys);

        $this->translations->merge($locale, $values, $is_json, $is_inline);
    }

    protected function load(string $path, bool $correct_keys = false): array
    {
        return $this->filesystem->load($path, true, $correct_keys);
    }

    protected function directories(): array
    {
        return Directory::names($this->getLocalesPath());
    }

    protected function files(string $locale, ?string $path = null): array
    {
        if (Arr::exists($this->files, $locale)) {
            return Arr::get($this->files, $locale);
        }

        return $this->files[$locale] = File::names($path ?: $this->getLocalesPath($locale), recursive: true);
    }
}
