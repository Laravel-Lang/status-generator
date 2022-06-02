<?php

namespace LaravelLang\StatusGenerator\Processors;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Concerns\Arrayable;

class Upgrade extends Processor
{
    use Arrayable;

    protected array $files = [];

    public function handle(): void
    {
        $this->collect();
        $this->store();
        $this->clean();
    }

    protected function collect(): void
    {
        foreach ($this->directories() as $locale) {
            $this->output->writeln('Processing: ' . $locale);

            foreach ($this->files($locale) as $file) {
                $path = $this->getLocalesPath($locale . '/' . $file, false);

                $is_json   = $this->isJson($path);
                $is_inline = $this->isInline($path);

                $this->setTranslations($locale, $path, $is_json, $is_inline);
            }
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

    protected function setTranslations(string $locale, string $path, bool $is_json, bool $is_inline): void
    {
        $this->translations->merge($locale, $this->load($path), $is_json, $is_inline);
    }

    protected function load(string $path): array
    {
        return $this->filesystem->load($path, true);
    }

    protected function directories(): array
    {
        return Directory::names($this->getLocalesPath());
    }

    protected function files(string $locale): array
    {
        if (Arr::exists($this->files, $locale)) {
            return Arr::get($this->files, $locale);
        }

        return $this->files[$locale] = File::names($this->getLocalesPath($locale));
    }
}
