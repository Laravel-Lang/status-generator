<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Contracts;

use DragonCode\Contracts\Support\Stringable;

interface Markdown extends Stringable
{
    public function data(array $data): self;
}
