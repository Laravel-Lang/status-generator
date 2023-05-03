<?php

namespace LaravelLang\StatusGenerator\Concerns;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Filesystem\Path;
use DragonCode\Support\Facades\Helpers\Str;

trait Files
{
    protected function isJson(string $path, bool $extension = true): bool
    {
        return $extension
            ? Path::extension($path) === 'json'
            : Str::contains(Path::filename($path), 'json');
    }

    protected function isInline(string $path): bool
    {
        $name = Path::filename($path);

        return Str::of($name)->lower()->contains('inline');
    }

    protected function isExcludes(string $path): bool
    {
        return Path::filename($path) === '_excludes';
    }

    protected function isNotTranslatable(string $path): bool
    {
        return Path::filename($path) === '_not_translatable';
    }

    protected function isExists(string $path): bool
    {
        return File::exists($path);
    }
}
