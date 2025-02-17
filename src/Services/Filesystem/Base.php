<?php

namespace LaravelLang\StatusGenerator\Services\Filesystem;

use DragonCode\PrettyArray\Services\File;
use DragonCode\PrettyArray\Services\Formatter;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Exceptions\FileSyntaxErrorException;
use DragonCode\Support\Facades\Helpers\Arr;

abstract class Base
{
    use Makeable;

    abstract public function store(
        string $path,
        array $content,
        bool $non_associative = false,
        bool $correct_keys = false
    ): void;

    public function __construct(
        protected File $pretty = new File(),
        protected Formatter $formatter = new Formatter()
    ) {}

    public function load(string $path, bool $flatten = false, bool $correct_keys = false): array
    {
        try {
            $values = $this->correct($this->pretty->load($path), $correct_keys);

            return $flatten ? Arr::flattenKeys($values) : $values;
        }
        catch (FileSyntaxErrorException) {
            return [];
        }
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
        return static fn (int|string $key, mixed $value) => is_int($key) && ! is_array($value) ? stripslashes($value)
            : stripslashes($key);
    }

    protected function simplify(array $values, bool $is_simple, bool $is_correct): array
    {
        return $is_simple ? array_values($values) : $this->correct($values, $is_correct);
    }

    protected function sort(array $values, bool $is_simple = false): array
    {
        return $is_simple ? Arr::sort($values) : Arr::ksort($values);
    }
}
