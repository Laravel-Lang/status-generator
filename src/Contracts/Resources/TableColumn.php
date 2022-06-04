<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Contracts\Resources;

use LaravelLang\StatusGenerator\Contracts\Markdown;

interface TableColumn extends Markdown
{
    public function push(mixed $value): self;
}
