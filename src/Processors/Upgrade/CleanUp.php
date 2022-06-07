<?php

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\StatusGenerator\Processors\Processor;

class CleanUp extends Processor
{
    protected array $protected_files = [
        '_excludes.json',
        'json-inline.json',
        'json.json',
        'php-inline.json',
        'php.json',
    ];

    public function handle(): void
    {
        $this->app();
        $this->source();
        $this->excludes();
        $this->files();
    }

    protected function app(): void
    {
        $this->deleteDirectory('app');
    }

    protected function source(): void
    {
        $this->deleteDirectory('source');
    }

    protected function excludes(): void
    {
        $this->deleteDirectory('excludes');
    }

    protected function files(): void
    {
        foreach ($this->getFiles() as $filename) {
            File::ensureDelete($this->getLocalesPath($filename));
        }
    }

    protected function deleteDirectory(string $name): void
    {
        if ($path = $this->getPath(true, $name)) {
            Directory::ensureDelete($path);
        }
    }

    protected function getFiles(): array
    {
        return File::names($this->getLocalesPath(), $this->hasDelete(), true);
    }

    protected function hasDelete(): callable
    {
        return fn (string $filename) => ! in_array($filename, $this->protected_files);
    }
}
