<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use DragonCode\PrettyArray\Services\File as Pretty;

class Php extends Base
{
    public function store(string $path, array $content, bool $is_simple = false, bool $correct_keys = false): void
    {
        $values = $this->simplify($content, $is_simple, $correct_keys);

        $values = $this->sort($values, $is_simple);

        $content = $this->format($values, $is_simple);

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
