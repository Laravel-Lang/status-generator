<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Contracts\Resources;

use LaravelLang\StatusGenerator\Contracts\Markdown;

interface TableRow extends Markdown
{
    public function push(TableColumn ...$columns): self;
}
