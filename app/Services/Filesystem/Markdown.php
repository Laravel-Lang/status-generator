<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use Helldar\Contracts\Support\Stringable;
use Helldar\Support\Facades\Helpers\Filesystem\File;
use Helldar\Support\Tools\Stub;

class Markdown extends Base
{
    public function store(string $path, array|string|Stringable $content, bool $is_simple = false, string $stub = Stub::PHP_ARRAY): void
    {
        $content = $this->prepareToStore($content);

        File::store($path, $content);
    }
}
