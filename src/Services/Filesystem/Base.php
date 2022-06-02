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

    public function load(string $path, bool $flatten = false, bool $correct_keys = false): array
    {
        $values = $this->correct($this->pretty->load($path), $correct_keys);

        return $flatten ? Arr::flattenKeys($values) : $values;
    }

    protected function correct(array $values, bool $correct = false): array
    {
        return Arr::of($values)
            ->map($this->correctValues(), true)
            ->renameKeys($correct ? $this->correctKeys() : $this->correctValues())
            ->toArray();
    }

    protected function correctValues(): callable
    {
        return static fn (string $value) => stripslashes($value);
    }

    protected function correctKeys(): callable
    {
        return static fn (int|string $key, mixed $value) => is_int($key) && ! is_array($value) ? stripslashes($value) : stripslashes($key);
    }
}
