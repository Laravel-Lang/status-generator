<?php

namespace LaravelLang\StatusGenerator\Contracts;

use Helldar\Contracts\Support\Stringable;
use Helldar\Support\Tools\Stub;
use LaravelLang\StatusGenerator\Application;

interface Filesystem
{
    public function application(Application $app): self;

    public function load(string $path): array;

    public function store(string $path, array|string|Stringable $content, bool $is_simple = false, string $stub = Stub::PHP_ARRAY): void;
}
