<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Concerns\Resources;

use LaravelLang\StatusGenerator\Constants\Stub;
use LaravelLang\StatusGenerator\Contracts\Resources\Tables\Table as TableContract;
use LaravelLang\StatusGenerator\Contracts\Resources\Tables\TableColumn as TableColumnContract;
use LaravelLang\StatusGenerator\Contracts\Resources\Tables\TableRow as TableRowContract;
use LaravelLang\StatusGenerator\Resources\Tables\Table;
use LaravelLang\StatusGenerator\Resources\Tables\TableColumn;
use LaravelLang\StatusGenerator\Resources\Tables\TableRow;

trait Tableable
{
    protected array $table_stubs = [];

    protected ?Stub $table_stub = null;

    protected function getTable(?Stub $stub = null): TableContract
    {
        $key = $stub?->value ?? $this->table_stub?->value ?? 'none';

        if (isset($this->table_stubs[$key])) {
            return $this->table_stubs[$key];
        }

        return $this->table_stubs[$key] = new Table($stub ?? $this->table_stub ?? null);
    }

    protected function getTableRow(TableColumn ...$columns): TableRowContract
    {
        $row = new TableRow();

        return $row->push(...$columns);
    }

    protected function getTableColumn(mixed $value): TableColumnContract
    {
        $column = new TableColumn();

        return $column->push($value);
    }

    protected function resetTables(): void
    {
        $this->table_stubs = [];
    }
}
