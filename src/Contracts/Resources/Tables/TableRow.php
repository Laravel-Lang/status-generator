<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Contracts\Resources\Tables;

use LaravelLang\StatusGenerator\Contracts\Markdown;

interface TableRow extends Markdown
{
    public function asHeader(bool $is_header = true): self;

    public function push(TableColumn ...$columns): self;
}
