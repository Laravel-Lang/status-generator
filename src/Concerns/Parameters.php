<?php

namespace LaravelLang\StatusGenerator\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Constants\Option;

/** @mixin \LaravelLang\StatusGenerator\Processors\Processor */
trait Parameters
{
    protected function parameter(string $name): mixed
    {
        return Arr::get($this->parameters, $name);
    }

    protected function getCopyParameter(): array
    {
        return $this->parameter(Option::COPY());
    }

    protected function getDirectoryParameter(): string
    {
        return $this->parameter(Option::DIRECTORY());
    }

    protected function getFileParameter(): string
    {
        return $this->parameter(Option::FILE());
    }

    protected function getLocaleParameter(): string
    {
        return $this->parameter(Option::LOCALE());
    }

    protected function getProjectParameter(): string
    {
        return $this->parameter(Option::PROJECT());
    }

    protected function getUrlParameter(): string
    {
        return $this->parameter(Option::URL());
    }

    protected function getVersionParameter(): string
    {
        return $this->parameter(Option::VERSION());
    }
}
