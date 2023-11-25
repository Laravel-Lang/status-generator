<?php

namespace LaravelLang\StatusGenerator\Processors\Create;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\LocaleList\Locale;
use LaravelLang\StatusGenerator\Exceptions\LocaleAlreadyExistException;
use LaravelLang\StatusGenerator\Processors\Processor;

class CreateLocale extends Processor
{
    protected string $default_locale = 'en';

    protected ?array $source_files = null;

    public function handle(): void
    {
        foreach ($this->creatingLocales() as $locale) {
            $this->output->task($locale, function () use ($locale) {
                if (! $this->hasMissingLocales() && $this->exists($locale)) {
                    throw new LocaleAlreadyExistException($locale);
                }

                $this->copy($locale);
            });
        }
    }

    protected function copy(string $locale): void
    {
        foreach ($this->sourceFiles() as $filename) {
            File::copy(
                $this->makePath($filename, $this->default_locale),
                $this->makePath($filename, $locale)
            );
        }
    }

    protected function sourceFiles(): array
    {
        return $this->source_files ??= File::names($this->getLocalesPath($this->default_locale));
    }

    protected function exists(string $locale): bool
    {
        return Directory::exists($this->getLocalesPath($locale));
    }

    protected function creatingLocales(): array
    {
        if ($this->hasMissingLocales()) {
            $exists = Directory::names($this->getLocalesPath(''));

            return array_diff(Locale::values(), $exists);
        }

        return [$this->getLocaleParameter()];
    }

    protected function makePath(string $filename, string $locale): string
    {
        return $this->getLocalesPath($locale . '/' . $filename, false);
    }
}
