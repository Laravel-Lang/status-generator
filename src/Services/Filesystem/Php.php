<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use DragonCode\PrettyArray\Services\File as Pretty;

class Php extends Base
{
    public function store(string $path, array $content, bool $non_associative = false, bool $correct_keys = false): void
    {
        $values = $this->simplify($content, $non_associative, $correct_keys);

        $values = $this->sort($values, $non_associative);

        $content = $this->format($values, $non_associative);

        Pretty::make($content)->store($path);
    }

    protected function format(array $values, bool $is_simple): string
    {
        $is_simple
            ? $this->formatter->setSimple()
            : $this->formatter->setEqualsAlign();

        $this->formatter->setKeyAsString();

        return $this->formatter->raw($values);
    }
}
