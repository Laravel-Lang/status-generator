<?php

namespace LaravelLang\StatusGenerator\Processors;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Concerns\Files;
use LaravelLang\StatusGenerator\Concerns\Parameters;
use LaravelLang\StatusGenerator\Concerns\Resources\Tableable;
use LaravelLang\StatusGenerator\Contracts;
use LaravelLang\StatusGenerator\Exceptions\IncorrectBasePathException;
use LaravelLang\StatusGenerator\Facades\Services\Locales;
use LaravelLang\StatusGenerator\Services\Filesystem\Manager;
use LaravelLang\StatusGenerator\Services\Locales as LocalesService;
use LaravelLang\StatusGenerator\Services\Translations;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Processor implements Contracts\Processor
{
    use Files;
    use Parameters;
    use Tableable;

    public function __construct(
        protected OutputInterface $output,
        protected string          $base_path,
        protected array           $parameters = [],
        protected Translations    $translations = new Translations(),
        protected Manager         $filesystem = new Manager()
    ) {
        $this->validateBasePath();
    }

    protected function validateBasePath(): void
    {
        $this->validatePath($this->getSourcePath());
        $this->validatePath($this->getLocalesPath());
    }

    protected function validatePath(string $path): void
    {
        if (Directory::doesntExist($path)) {
            throw new IncorrectBasePathException($path);
        }
    }

    protected function getSourcePath(string $path = null, bool $use_real = true): string
    {
        return $this->getPath($use_real, $this->base_path, 'source', $path);
    }

    protected function getLocalesPath(string $path = null, bool $use_real = true): string
    {
        return $this->getPath($use_real, $this->base_path, 'locales', $path);
    }

    protected function getPath(bool $use_real, ?string ...$paths): string
    {
        $path = Arr::of($paths)->filter()->implode('/')->toString();

        return $use_real ? realpath($path) : $path;
    }

    protected function directories(): array
    {
        return Directory::names($this->getLocalesPath());
    }

    protected function locales(): LocalesService
    {
        return Locales::load($this->getSourcePath(), $this->getLocalesPath());
    }

    protected function load(string $path, bool $correct_keys = false): array
    {
        return $this->filesystem->load($path, true, $correct_keys);
    }
}
