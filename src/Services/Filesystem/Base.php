<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use DragonCode\PrettyArray\Services\File;
use DragonCode\PrettyArray\Services\Formatter;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;

abstract class Base
{
    use Makeable;

    public function __construct(
        protected File      $pretty = new File(),
        protected Formatter $formatter = new Formatter()
    ) {
    }

    abstract public function store(string $path, array $content, bool $is_simple = false): void;

    public function load(string $path, bool $flatten = false): array
    {
        $values = $this->correct($this->pretty->load($path));

        return $flatten ? Arr::flattenKeys($values) : $values;
    }

    protected function correct(array $values): array
    {
        return Arr::of($values)
            ->map($this->correctCallback(), true)
            ->renameKeys($this->correctCallback())
            ->toArray();
    }

    protected function correctCallback(): callable
    {
        return static fn (string $value) => stripslashes($value);
    }
}
