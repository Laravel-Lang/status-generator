<?php

namespace LaravelLang\StatusGenerator\Concerns;

use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Str;

trait Files
{
    protected function isJson(string $path): bool
    {
        return Str::of($path)->lower()->endsWith('.json');
    }

    protected function isPhp(string $path): bool
    {
        return Str::of($path)->lower()->endsWith('.php');
    }

    protected function isInline(string $path): bool
    {
        $name = Path::filename($path);

        return Str::of($name)->lower()->contains('inline');
    }
}
