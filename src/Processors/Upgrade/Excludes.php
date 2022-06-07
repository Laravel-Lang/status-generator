<?php

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\StatusGenerator\Processors\Processor;

class Excludes extends Processor
{
    public function handle(): void
    {
        foreach ($this->directories() as $locale) {
            $source = $this->getSourceFilename($locale);
            $target = $this->getTargetFilename($locale);

            if ($source && File::exists($source)) {
                $this->store($target, $this->load($source));
            }
        }
    }

    protected function store(string $path, array $values): void
    {
        $this->filesystem->store($path, $values, true);
    }

    protected function getSourceFilename(string $locale): string|bool
    {
        return $this->getPath(true, $this->base_path, 'excludes', $locale . '.php');
    }

    protected function getTargetFilename(string $locale): string
    {
        return $this->getLocalesPath($locale . '/_excludes.json', false);
    }
}
