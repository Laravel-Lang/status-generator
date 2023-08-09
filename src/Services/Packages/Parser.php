<?php

namespace LaravelLang\StatusGenerator\Services\Packages;

use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;

class Parser
{
    use Makeable;

    protected string $regex = '/\b(%s)\(\r*\s*(.+)\r*\s*(\)|,\s?\[)/U';

    protected array $trans_methods = [
        '__',
        '$t',
        'fail',
        'lang',
        'Lang::choice',
        'Lang::get',
        'tChoice',
        'trans',
        'trans_choice',
        'wTrans',
        'wTransChoice',
    ];

    protected string $trim_chars = "\t\n\r\0\x0B'\"";

    protected array $files = [];

    protected array $keys = [];

    public function files(array $files): self
    {
        $this->files = $files;

        return $this;
    }

    public function get(): array
    {
        $this->clear();
        $this->each();
        $this->sort();

        return $this->keys();
    }

    protected function clear(): void
    {
        $this->keys = [];
    }

    protected function each(): void
    {
        foreach ($this->files as $file) {
            $content = file_get_contents($file);

            $this->parse($content);
        }
    }

    protected function sort(): void
    {
        Arr::ksort($this->keys);
    }

    protected function parse(string $content): void
    {
        foreach ($this->match($content) as $match) {
            $value = $match;

            if (Str::contains((string) $value, $this->subMethods())) {
                $sub_key = $this->subkey($value);

                $sub_value = $this->keys[$sub_key] ?? null;

                $this->push($sub_value);
            }

            $this->push($value);
        }
    }

    protected function match(string $content): array
    {
        preg_match_all($this->regex(), $content, $matches);

        return $matches[2] ?? [];
    }

    protected function push(mixed $value): void
    {
        $value = $this->trim($value);

        if (! isset($this->keys[$value])) {
            $this->keys[$value] = $value;
        }
    }

    protected function subkey(string $value): string
    {
        $sub_key = $this->match($value)[0];

        return $this->trim($sub_key);
    }

    protected function keys(): array
    {
        return $this->keys;
    }

    protected function trim($value): mixed
    {
        if (is_string($value)) {
            return trim(stripslashes($value), $this->trim_chars);
        }

        return $value;
    }

    protected function regex(): string
    {
        $methods
            = Arr::of($this->trans_methods)->implode('|')->replace(['$', '(', ')'], ['\$', '\(', '\)'])->toString();

        return sprintf($this->regex, $methods);
    }

    protected function subMethods(): array
    {
        return Arr::of($this->trans_methods)
            ->map(fn (string $method) => Str::finish($method, '('))
            ->toArray();
    }
}
