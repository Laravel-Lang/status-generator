<?php

namespace LaravelLang\StatusGenerator\Processors\Create;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use Exception;
use LaravelLang\Locales\Enums\Locale;
use LaravelLang\StatusGenerator\Processors\Processor;

class CreateLocale extends Processor
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
            $this->output->task($filename, function () use ($filename) {
                foreach ($this->creatingLocales() as $locale) {
                    File::copy(
                        $this->makePath($filename, $this->default_locale),
                        $this->makePath($filename, $locale)
                    );
                }
            });
        }
    }

    protected function sourceFiles(): array
    {
        return File::names($this->getLocalesPath($this->default_locale));
    }

    protected function exists(): bool
    {
        return Directory::exists($this->getLocalesPath($this->getLocaleParameter()));
    }

    protected function creatingLocales(): array
    {
        if ($this->getLocaleParameter() === 'all') {
            return Locale::values();
        }

        return [$this->getLocaleParameter()];
    }

    protected function makePath(string $filename, string $locale): string
    {
        return $this->getLocalesPath($locale . '/' . $filename, false);
    }
}
