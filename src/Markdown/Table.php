<?php

namespace LaravelLang\StatusGenerator\Markdown;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use DragonCode\Support\Helpers\Ables\Arrayable;

class Table extends Base
{
    protected bool $with_header = false;

    protected array $headers = [];

    public function __toString()
    {
        $content = $this->compileHeaders() . $this->compileData();

        return '<table width="100%">' . PHP_EOL . $content . PHP_EOL . '</table>';
    }

    public function withHeader(): self
    {
        $this->with_header = true;

        return $this;
    }

    public function withCustomHeaders(string ...$headers): self
    {
        $this->headers = $headers;

        return $this->withHeader();
    }

    protected function compileHeaders(): ?string
    {
        if (! $this->with_header) {
            return null;
        }

        $columns = Arr::of($this->headers ?: $this->data[0])
            ->when(empty($this->headers), fn (Arrayable $arr) => $arr->keys())
            ->map(fn (string $value) => Str::title($value))
            ->toArray();

        return $this->row($columns, 'th') . PHP_EOL;
    }

    protected function compileData(): string
    {
        return Arr::of($this->data)
            ->map(fn (array $row): string => $this->row($row))
            ->implode(PHP_EOL);
    }

    protected function getWidth(): int
    {
        $columns = count($this->data[0]);

        return round(100 / $columns, PHP_ROUND_HALF_DOWN);
    }

    protected function row(array $columns, string $operator = 'td'): string
    {
        return Arr::of($columns)
            ->map(fn (mixed $value) => $this->cell($value, $operator))
            ->implode('')
            ->prepend('<tr>')
            ->append('</tr>');
    }

    protected function cell(string $value, string $operator = 'td'): string
    {
        return '<' . $operator . ' width="' . $this->getWidth() . '%">' . PHP_EOL . PHP_EOL . $value . PHP_EOL . PHP_EOL . '</' . $operator . '>';
    }
}
