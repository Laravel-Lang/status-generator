<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Contracts\Resources\Tables;

use LaravelLang\StatusGenerator\Contracts\Markdown;

interface TableRow extends Markdown
{
    public function push(TableColumn ...$columns): self;
}
