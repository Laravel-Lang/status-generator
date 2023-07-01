<?php

namespace LaravelLang\StatusGenerator\Services\Packages;

use DragonCode\Support\Concerns\Makeable;
use Symfony\Component\Finder\Finder as SymfonyFinder;

class Finder
{
    use Makeable;

    protected array $names = ['*.php', '*.json', '*.js', '*.ts', '*.vue', '*.stub'];

    protected array $contains = [
        '__(',
        '$t(',
        'fail',
        'lang(',
        'Lang::choice(',
        'Lang::get(',
        'tChoice(',
        'trans(',
        'trans_choice(',
        'wTrans(',
        'wTransChoice(',
    ];

    protected array $files = [];

    public function __construct(
        protected SymfonyFinder $finder = new SymfonyFinder()
    ) {}

    public function get(array|string $path): array
    {
        $this->search($path);

        return $this->files($path);
    }

    protected function search(array|string $path): void
    {
        foreach ($this->find($path) as $file) {
            $this->push($path, $file->getRealPath());
        }
    }

    protected function find(array|string $path): SymfonyFinder
    {
        return $this->finder()->in($path)->files()
            ->name($this->names)
            ->contains($this->contains);
    }

    protected function push(array|string $source, string $path): void
    {
        $this->files[$source][] = $path;
    }

    protected function files(array|string $path): array
    {
        return $this->files[$path] ?? [];
    }

    protected function finder(): SymfonyFinder
    {
        return clone $this->finder;
    }
}
