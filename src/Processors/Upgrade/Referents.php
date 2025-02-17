<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Constants\Stub;
use LaravelLang\StatusGenerator\Markdown\Page;
use LaravelLang\StatusGenerator\Markdown\Table;
use LaravelLang\StatusGenerator\Processors\Processor;

class Referents extends Processor
{
    protected array $items = [];

    public function handle(): void
    {
        $this->output->task('Referents', function () {
            if ($this->exists()) {
                $this->parse();
                $this->store();
            }
        });
    }

    protected function parse(): void
    {
        preg_match_all('/public\sconst\s([a-zA-Z_]+)\s=\s\[\'(.+)\'\\]/', $this->content(), $matches);

        for ($i = 0; $i < count($matches[0]); ++$i) {
            $locale = $matches[1][$i];

            $developers = Str::of($matches[2][$i])
                ->explode('\', \'')
                ->map(fn (string $username) => Str::start($username, '@'))
                ->implode(', ');

            $this->items[] = compact('locale', 'developers');
        }
    }

    protected function store(): void
    {
        $content = (string) Table::make()->withHeader()->data($this->items);

        $page = (string) Page::make()->stub(Stub::REFERENTS)->data(compact('content'));

        File::store($this->getTargetReferents(), $page);
    }

    protected function content(): string
    {
        return file_get_contents($this->getSourceReferents());
    }

    protected function exists(): bool
    {
        return File::exists($this->getSourceReferents());
    }

    protected function getSourceReferents(): string
    {
        return $this->getPath(false, 'app/main/Constants/Referents.php');
    }

    protected function getTargetReferents(): string
    {
        return $this->getPath(false, 'docs/referents.md');
    }
}
