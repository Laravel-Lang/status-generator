<?php

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
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
        $this->output->task('Clean Up', function () {
            $this->app();
            $this->excludes();
            $this->files();
        });
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
        return fn (string $filename) => ! Str::endsWith($filename, $this->protected_files);
    }
}
