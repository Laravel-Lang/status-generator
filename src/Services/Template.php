<?php

namespace LaravelLang\StatusGenerator\Services;

use LaravelLang\StatusGenerator\Constants\Stub;

class Template
{
    protected string $base_path = __DIR__ . '/../../resources/';

    public function read(Stub $stub): string
    {
        return file_get_contents($this->path($stub));
    }

    protected function path(Stub $stub): string
    {
        return realpath($this->base_path . $stub->value);
    }
}
