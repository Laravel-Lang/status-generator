<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Resources\Tables;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Constants\Stub;
use LaravelLang\StatusGenerator\Contracts\Resources\Tables\Table as TableContract;
use LaravelLang\StatusGenerator\Contracts\Resources\Tables\TableRow;
use LaravelLang\StatusGenerator\Facades\Template;

class Table implements TableContract
{
    protected array $rows = [];

    public function __construct(
        protected ?Stub $stub = null
    ) {
    }

    public function push(TableRow $row): TableContract
    {
        $this->rows[] = $row;

        return $this;
    }

    public function __toString(): string
    {
        $content = $this->compileContent();

        return $this->hasStub() ? $this->toStub($content) : $content;
    }

    protected function compileContent(): string
    {
        return Arr::of($this->rows)
            ->map(static fn (TableRow $row) => (string) $row)
            ->implode(PHP_EOL)
            ->toString();
    }

    protected function toStub(string $content): string
    {
        return Str::replaceFormat($this->getTemplate(), compact('content'), '{{%s}}');
    }

    protected function hasStub(): bool
    {
        return ! empty($this->stub);
    }

    protected function getTemplate(): string
    {
        return Template::read($this->stub);
    }
}
