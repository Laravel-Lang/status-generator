<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use DragonCode\Support\Facades\Filesystem\File;

class Json extends Base
{
    public function store(string $path, array $content, bool $is_simple = false): void
    {
        if ($is_simple) {
            $content = array_values($content);
        }

        File::store($path, $this->encode($content));
    }

    protected function encode(array $values): string
    {
        return json_encode($values, JSON_UNESCAPED_UNICODE ^ JSON_UNESCAPED_SLASHES ^ JSON_PRETTY_PRINT);
    }
}
