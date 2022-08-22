<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Status;

use DragonCode\Support\Facades\Filesystem\File;
use LaravelLang\StatusGenerator\Constants\Stub;
use LaravelLang\StatusGenerator\Markdown\Page;
use LaravelLang\StatusGenerator\Markdown\Table;

class Localization extends Base
{
    /** @var array<\LaravelLang\StatusGenerator\Markdown\Table> */
    protected array $pages = [];

    protected function prepare(): void
    {
        foreach ($this->translations->all() as $locale => $sections) {
            $this->output->task('Processing ' . $locale, function () use ($locale, $sections) {
                $count = 0;

                $values = [];

                foreach ($sections as $section => $rows) {
                    $count += count($rows);

                    if (empty($rows)) {
                        continue;
                    }

                    $items = [];

                    foreach ($rows as $key => $value) {
                        $items[] = [$key, $value];
                    }

                    $table = Table::make()->withCustomHeaders('Key', 'Value')->data($items);

                    $values[] = Page::make()->stub(Stub::STATUS_COMPONENT_LOCALE)->data([
                        'section' => $section,
                        'count'   => count($rows),
                        'content' => $table,
                    ]);
                }

                $content = $count ? implode(PHP_EOL . PHP_EOL, $values) : Page::make()->stub(Stub::STATUS_COMPONENT_TRANSLATED);

                $this->pages[$locale] = Page::make()->stub(Stub::STATUS_LOCALE)->data(compact('locale', 'count', 'content'));
            });
        }

        $this->output->emptyLine();
    }

    protected function store(): void
    {
        foreach ($this->pages as $locale => $table) {
            $this->output->task('Storing ' . $locale, function () use ($locale, $table) {
                File::store($this->getDocsPath("statuses/$locale.md"), (string) $table);
            });
        }

        $this->output->emptyLine();
    }
}
