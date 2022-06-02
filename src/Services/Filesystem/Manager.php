<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use LaravelLang\StatusGenerator\Concerns\Files;

class Manager
{
    use Files;

    public function load(string $path, bool $flatten = false, bool $correct_keys = false): array
    {
        return $this->processor($path)->load($path, $flatten, $correct_keys);
    }

    public function store(string $path, array $values, bool $is_simple): void
    {
        $this->processor($path)->store($path, $values, $is_simple);
    }

    protected function processor(string $path): Base
    {
        return $this->isJson($path) ? Json::make() : Php::make();
    }
}
