<?php

namespace LaravelLang\StatusGenerator\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Constants\Argument;

/** @mixin \LaravelLang\StatusGenerator\Processors\Processor */
trait Parameters
{
    protected function parameter(string $name): mixed
    {
        return Arr::get($this->parameters, $name);
    }

    protected function getCopyParameter(): array
    {
        return $this->parameter(Argument::COPY());
    }

    protected function getDirectoryParameter(): string
    {
        return $this->parameter(Argument::DIRECTORY());
    }

    protected function getFileParameter(): string
    {
        return $this->parameter(Argument::FILE());
    }

    protected function getLocaleParameter(): string
    {
        return $this->parameter(Argument::LOCALE());
    }

    protected function getProjectParameter(): string
    {
        return Str::slug($this->parameter(Argument::PROJECT()));
    }

    protected function getUrlParameter(): string
    {
        return $this->parameter(Argument::URL());
    }

    protected function getVersionParameter(): string
    {
        return Str::slug($this->parameter(Argument::VERSION()));
    }
}
