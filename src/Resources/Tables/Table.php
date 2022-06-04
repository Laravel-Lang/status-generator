<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Resources\Tables;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Contracts\Resources\Table as TableContract;
use LaravelLang\StatusGenerator\Contracts\Resources\TableRow;

class Table implements TableContract
{
    protected array $rows = [];

    public function push(TableRow $row): TableContract
    {
        $this->rows[] = $row;

        return $this;
    }

    public function __toString(): string
    {
        return Arr::of($this->rows)
            ->map(static fn (TableRow $row) => (string) $row)
            ->implode(PHP_EOL)
            ->toString();
    }
}
