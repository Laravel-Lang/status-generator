<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Status;

use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\StatusGenerator\Constants\Stub;

class Localization extends Base
{
    /** @var array<\LaravelLang\StatusGenerator\Resources\Tables\Table> */
    protected array $tables = [];

    protected ?Stub $table_stub = Stub::STATUS_LOCALE;

    protected function prepare(): void
    {
        foreach ($this->translations->all() as $locale => $sections) {
            $count = 0;

            foreach ($sections as $section => $values) {
                foreach ($values as $key => $value) {
                    $row = $this->getTableRow(
                        $this->getTableColumn($key),
                        $this->getTableColumn($value),
                    );

                    $this->getTable(Stub::STATUS_COMPONENT_LOCALE)->push($row)->with(compact('section', 'locale'));
                }

                $count += count($values);
            }

            $content = $this->getTable($count ? Stub::STATUS_COMPONENT_LOCALE : Stub::STATUS_COMPONENT_TRANSLATED);

            $this->tables[$locale] = $this->getTable()->with(compact('locale', 'count', 'content'));

            $this->resetTables();
        }
    }

    protected function store(): void
    {
        foreach ($this->tables as $locale => $table) {
            File::store($this->getDocsPath("statuses/$locale.md"), (string) $table);
        }
    }
}
