<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Status;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Digit;
use LaravelLang\StatusGenerator\Constants\Stub;
use LaravelLang\StatusGenerator\Contracts\Markdown;
use LaravelLang\StatusGenerator\Markdown\Page;
use LaravelLang\StatusGenerator\Markdown\Table;
use LaravelLang\StatusGenerator\Objects\Count as CountDto;

class MainPage extends Base
{
    protected int $columns = 5;

    protected string $complete_template = '[%s&nbsp;✔](statuses/%s.md)';

    protected string $missing_template = '[%s&nbsp;❗](statuses/%s.md)';

    protected int $stats_all = 0;

    protected int $stats_missing = 0;

    protected Table|Markdown $table;

    protected function prepare(): void
    {
        $this->prepareLocales();
    }

    protected function prepareLocales(): void
    {
        $data = [];

        foreach ($this->rows() as $row) {
            $columns = [];

            foreach ($row as $column) {
                $columns[] = $this->compile($column);

                $this->stats_all     += $column->all;
                $this->stats_missing += $column->missing;
            }

            $data[] = $columns;
        }

        $this->table = Table::make()->data($data);
    }

    protected function store(): void
    {
        $count_diff_percents = round(($this->stats_all         - $this->stats_missing) / $this->stats_all * 100, 2);
        $count_diff          = Digit::toShort($this->stats_all - $this->stats_missing);
        $count_all           = Digit::toShort($this->stats_all);

        $content = $this->table;

        $page = Page::make()->stub(Stub::STATUS)->data(compact('content', 'count_all', 'count_diff', 'count_diff_percents'));

        File::store($this->getTargetStatus(), (string) $page);
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
