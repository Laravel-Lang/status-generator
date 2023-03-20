<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use LaravelLang\StatusGenerator\Concerns\Files;

class Manager
{
    use Files;

    public function loadIfExists(string $path, bool $flatten = false, bool $correct_keys = false): array
    {
        if ($this->isExists($path)) {
            return $this->processor($path)->load($path, $flatten, $correct_keys);
        }

        return [];
    }

    public function load(string $path, bool $flatten = false, bool $correct_keys = false): array
    {
        return $this->processor($path)->load($path, $flatten, $correct_keys);
    }

    public function store(string $path, array $values, bool $non_associative, bool $correct = false): void
    {
        $this->processor($path)->store($path, $values, $non_associative, $correct);
    }

    protected function processor(string $path): Base
    {
        return $this->isJson($path) ? Json::make() : Php::make();
    }
}
