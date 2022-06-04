<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Resources\Tables;

use LaravelLang\StatusGenerator\Contracts\Resources\TableColumn as Contract;

class TableColumn implements Contract
{
    protected mixed $value = null;

    public function push(mixed $value): Contract
    {
        $this->value = $value;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
