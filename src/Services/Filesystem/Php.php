<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use DragonCode\PrettyArray\Services\File as Pretty;

class Php extends Base
{
    public function store(string $path, array $content, bool $is_simple = false): void
    {
        $content = $this->format($content, $is_simple);

        Pretty::make($content)->store($path);
    }

    protected function format(array $values, bool $is_simple): string
    {
        $is_simple
            ? $this->formatter->setSimple()
            : $this->formatter->setEqualsAlign();

        return $this->formatter->raw($values);
    }
}
