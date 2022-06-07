<?php

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
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
        $this->excludes();
        $this->files();
    }

    protected function app(): void
    {
        $this->deleteDirectory('app');
    }

    protected function excludes(): void
    {
        $this->deleteDirectory('excludes');
    }

    protected function files(): void
    {
        File::ensureDelete($this->getFiles());
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
        return fn (string $path) => ! in_array(Path::filename($path), $this->protected_files);
    }
}
