<?php

namespace LaravelLang\StatusGenerator\Services\Compilers;

use Helldar\Contracts\Support\Stringable;
use Helldar\Support\Concerns\Makeable;
use LaravelLang\StatusGenerator\Concerns\Contains;
use LaravelLang\StatusGenerator\Concerns\Template;
use LaravelLang\StatusGenerator\Contracts\Application;

abstract class Compiler implements Stringable
{
    use Contains;
    use Makeable;
    use Template;

    protected array $items;

    protected array $extend = [];

    public function __construct(
        protected Application $app
    ) {
    }

    public function items(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function extend(array $values): self
    {
        $this->extend = $values;

        return $this;
    }
}
