<?php

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\StatusGenerator\Concerns\Arrayable;
use LaravelLang\StatusGenerator\Processors\Processor;

class Locales extends Processor
{
    use Arrayable;

    public function handle(): void
    {
        $this->collectLocales();
        $this->collectEnglish();

        $this->store();
    }

    protected function collectLocales(): void
    {
        foreach ($this->directories() as $locale) {
            $this->output->task('Collect locale: ' . $locale, fn () => $this->collect($locale));
        }
    }

    protected function collectEnglish(string $locale = 'en'): void
    {
        $this->output->task('Collect source', fn () => $this->collect($locale));
    }

    protected function collect(string $locale): void
    {
        $is_english = $locale === 'en';

        $lang_path = $is_english ? $this->getSourcePath() : $this->getLocalesPath($locale);

        foreach ($this->files($lang_path) as $file) {
            $path = $is_english
                ? $this->getSourcePath($file)
                : $this->getLocalesPath($locale . '/' . $file);

            $is_json   = $this->isJson($path);
            $is_inline = $this->isInline($path);

            $this->setTranslations($locale, $path, $is_json, $is_inline);
        }
    }

    protected function store(): void
    {
        foreach ($this->translations->all() as $locale => $items) {
            $this->output->task('Storing locale: ' . $locale, function () use ($locale, $items) {
                foreach ($items as $filename => $values) {
                    $path = $this->getLocalesPath($locale . '/' . $filename . '.json', false);

                    $values = $this->ksort($values);

                    $this->filesystem->store($path, $values, false);
                }
            });
        }
    }

    protected function setTranslations(string $locale, string $path, bool $is_json, bool $is_inline): void
    {
        $this->translations->merge($locale, $this->load($path), $is_json, $is_inline);
    }

    protected function files(string $path): array
    {
        return File::names($path, recursive: true);
    }
}
