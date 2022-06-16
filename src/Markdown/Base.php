<?php

namespace LaravelLang\StatusGenerator\Markdown;

use DragonCode\Support\Concerns\Makeable;
use LaravelLang\StatusGenerator\Contracts\Markdown;

abstract class Base implements Markdown
{
    use Makeable;

    protected array $data = [];

    public function data(array $data): Markdown
    {
        $this->data = $data;

        return $this;
    }
}
