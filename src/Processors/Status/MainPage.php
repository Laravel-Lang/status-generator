<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Processors\Status;

class MainPage extends Base
{
    protected function store(): void
    {
        dd(
            $this->translations->all()
        );
    }
}
