<?php

namespace LaravelLang\StatusGenerator\Services\Packages;

use DragonCode\Support\Facades\Filesystem\Directory;
use DragonCode\Support\Facades\Helpers\Str;

class Package
{
    protected ?string $path;

    protected array $filter = ['$', '::', 'auth.', 'pagination.', 'passwords.', 'validation.', 'prototype', 'constructor', 'object'];

    public function __construct(
        protected Finder $finder = new Finder(),
        protected Parser $parser = new Parser()
    ) {}

    public function some(): self
    {
        return $this;
    }

    public function path(string $path): self
    {
        Directory::validate($path);

        $this->path = $path;

        return $this;
    }

    public function content(): array
    {
        $files = $this->files();

        $items = $this->parsed($files);

        return $this->filter($items);
    }

    protected function files(): array
    {
        return $this->finder->get($this->path);
    }

    protected function parsed(array $files): array
    {
        return $this->parser->files($files)->get();
    }

    protected function filter(array $items): array
    {
        return array_filter(array_keys($items), fn ($value) => $this->doesntContainsChars($value) && $this->doesntContainsSpecialChars($value));
    }

    protected function doesntContainsChars(string $value): bool
    {
        return ! Str::contains($value, $this->filter);
    }

    protected function doesntContainsSpecialChars(string $value): bool
    {
        return ! Str::matchContains($value, '/^[\W_]+$/');
    }
}
