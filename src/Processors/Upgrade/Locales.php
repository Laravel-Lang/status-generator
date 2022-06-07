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
        $this->clean();
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

    protected function files(string $locale, ?string $path = null): array
    {
        return File::names($path ?: $this->getLocalesPath($locale), recursive: true);
    }
}
