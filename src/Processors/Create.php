<?php

namespace LaravelLang\StatusGenerator\Processors;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
use Exception;

class Create extends Processor
{
    protected string $default_locale = 'en';

    public function handle(): void
    {
        if ($this->exists()) {
            throw new Exception('Localization with this code already exists.');
        }

        $this->copy();
    }

    protected function copy(): void
    {
        foreach ($this->sourceFiles() as $filename) {
            File::copy(
                $this->makePath($filename, $this->default_locale),
                $this->makePath($filename, $this->getLocale())
            );
        }
    }

    protected function sourceFiles(): array
    {
        return File::names($this->getLocalesPath($this->default_locale));
    }

    protected function exists(): bool
    {
        return Directory::exists($this->getLocalesPath($this->getLocale()));
    }

    protected function getLocale(): string
    {
        return Str::replace($this->getLocaleParameter(), '-', '_');
    }

    protected function makePath(string $filename, string $locale): string
    {
        return $this->getLocalesPath($locale . '/' . $filename, false);
    }
}
