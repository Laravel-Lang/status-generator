<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use DragonCode\Support\Facades\Filesystem\File;

class Json extends Base
{
    public function store(string $path, array $content, bool $is_simple = false, bool $correct_keys = false): void
    {
        $values = $this->simplify($content, $is_simple, $correct_keys);

        $values = $this->sort($values, $is_simple);

        File::store($path, $this->encode($values));
    }

    protected function encode(array $values): string
    {
        return json_encode($values, JSON_UNESCAPED_UNICODE ^ JSON_UNESCAPED_SLASHES ^ JSON_PRETTY_PRINT);
    }
}
