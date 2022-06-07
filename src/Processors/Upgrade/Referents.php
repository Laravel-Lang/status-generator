<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Upgrade;

use DragonCode\Support\Facades\Filesystem\File;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Constants\Stub;
use LaravelLang\StatusGenerator\Processors\Processor;
use LaravelLang\StatusGenerator\Resources\Tables\TableRow;

class Referents extends Processor
{
    protected ?Stub $table_stub = Stub::REFERENTS;

    public function handle(): void
    {
        if ($this->exists()) {
            $this->setHeaders();
            $this->parse();
            $this->store();
        }
    }

    protected function setHeaders(): void
    {
        $columns = [
            $this->getTableColumn('Locale'),
            $this->getTableColumn('Developers'),
        ];

        $row = new TableRow();

        $row->asHeader()->push(...$columns);

        $this->getTable()->push($row);
    }

    protected function parse(): void
    {
        preg_match_all('/public\sconst\s([a-zA-Z_]+)\s=\s\[\'(.+)\'\\]/', $this->content(), $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {
            $key = $matches[1][$i];

            $value = Str::of($matches[2][$i])
                ->explode('\', \'')
                ->map(fn (string $username) => Str::start($username, '@'))
                ->implode(', ');

            $locale = $this->getTableColumn($key);
            $users  = $this->getTableColumn($value);

            $row = $this->getTableRow($locale, $users);

            $this->getTable()->push($row);
        }
    }

    protected function store(): void
    {
        File::store($this->getTargetReferents(), (string) $this->getTable());
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
