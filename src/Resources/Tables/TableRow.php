<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Resources\Tables;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Contracts\Resources\TableColumn;
use LaravelLang\StatusGenerator\Contracts\Resources\TableRow as TableRowContract;

class TableRow implements TableRowContract
{
    protected array $columns = [];

    public function push(TableColumn ...$columns): TableRowContract
    {
        $this->columns = $columns;

        return $this;
    }

    public function __toString(): string
    {
        return Arr::of($this->columns)
            ->map(static fn (TableColumn $column) => (string) $column)
            ->implode(' | ')
            ->start('| ')
            ->end(' |')
            ->toString();
    }
}
