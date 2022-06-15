<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Resources\Tables;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Helpers\Ables\Stringable;
use LaravelLang\StatusGenerator\Contracts\Resources\Tables\TableColumn;
use LaravelLang\StatusGenerator\Contracts\Resources\Tables\TableRow as TableRowContract;

class TableRow implements TableRowContract
{
    protected array $columns = [];

    protected bool $is_header = false;

    public function __toString(): string
    {
        return Arr::of($this->columns)
            ->map(static fn (TableColumn $column) => (string) $column)
            ->implode(' | ')
            ->start('| ')
            ->end(' |')
            ->when($this->is_header, $this->headerDividerCallback())
            ->toString();
    }

    public function asHeader(bool $is_header = true): TableRowContract
    {
        $this->is_header = $is_header;

        return $this;
    }

    public function push(TableColumn ...$columns): TableRowContract
    {
        $this->columns = $columns;

        return $this;
    }

    protected function headerDividerCallback(): callable
    {
        return fn (Stringable $str) => $str->append(PHP_EOL)->append($this->dividerLine());
    }

    protected function dividerLine(): string
    {
        return Arr::of(array_fill(0, count($this->columns), ':---'))
            ->implode('|')
            ->start('|')
            ->end('|')
            ->toString();
    }
}
