<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Status;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Digit;
use LaravelLang\StatusGenerator\Constants\Stub;
use LaravelLang\StatusGenerator\Objects\Count as CountDto;

class MainPage extends Base
{
    protected ?Stub $table_stub = Stub::STATUS;

    protected int $columns = 5;

    protected string $complete_template = '[%s&nbsp;✔](statuses/%s.md)';

    protected string $missing_template = '[%s&nbsp;❗](statuses/%s.md)';

    protected int $stats_all = 0;

    protected int $stats_missing = 0;

    protected function prepare(): void
    {
        $this->prepareHeaders();
        $this->prepareLocales();
    }

    protected function prepareHeaders(): void
    {
        $columns = array_fill(0, min($this->columns, $this->counter->count()), $this->getTableColumn(''));

        $row = $this->getTableRow(...$columns)->asHeader();

        $this->getTable()->push($row);
    }

    protected function prepareLocales(): void
    {
        foreach ($this->rows() as $row) {
            $columns = [];

            foreach ($row as $column) {
                $columns[] = $this->getTableColumn($this->compile($column));

                $this->stats_all     += $column->all;
                $this->stats_missing += $column->missing;
            }

            $table_row = $this->getTableRow(...$columns);

            $this->getTable()->push($table_row);
        }
    }

    protected function store(): void
    {
        File::store(
            $this->getTargetStatus(),
            (string) $this->getTable()->with([
                'count_diff_percents' => round(($this->stats_all - $this->stats_missing) / $this->stats_all * 100, 2),
                'count_diff'          => Digit::toShort($this->stats_all - $this->stats_missing),
                'count_all'           => Digit::toShort($this->stats_all),
            ])
        );
    }

    protected function compile(CountDto $dto): string
    {
        $template = $dto->isComplete() ? $this->complete_template : $this->missing_template;

        return sprintf($template, $dto->locale, $dto->locale);
    }

    /**
     * @return array<array<CountDto>>
     */
    protected function rows(): array
    {
        return array_chunk($this->counter->toArray(), $this->columns);
    }

    protected function getTargetStatus(): string
    {
        return $this->getDocsPath('status.md');
    }
}
