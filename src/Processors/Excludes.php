<?php

namespace LaravelLang\StatusGenerator\Processors;

use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\StatusGenerator\Facades\Services\Locales;
use LaravelLang\StatusGenerator\Services\Locales as LocalesService;

class Excludes extends Processor
{
    public function handle(): void
    {
        $source = $this->getSourceValues();

        foreach ($this->directories() as $locale) {
            $path = $this->getTargetFilename($locale);

            $target = $this->getLocaleExcludes($locale);

            $intersect = array_intersect($source, $target);

            ! empty($intersect) ? $this->store($path, $intersect) : $this->delete($path);
        }
    }

    protected function delete(string $path): void
    {
        File::ensureDelete($path);
    }

    protected function store(string $path, array $values): void
    {
        $this->filesystem->store($path, $values, true);
    }

    protected function getSourceValues(): array
    {
        $result = [];

        foreach ($this->locales()->getSource() as $values) {
            $result = array_merge($result, array_values($values));
        }

        return $result;
    }

    protected function getLocaleExcludes(string $locale): array
    {
        return $this->locales()->getExcludes($locale);
    }

    protected function locales(): LocalesService
    {
        return Locales::load($this->getSourcePath(), $this->getLocalesPath());
    }

    protected function getTargetFilename(string $locale): string
    {
        return $this->getLocalesPath($locale . '/_excludes.json');
    }
}
