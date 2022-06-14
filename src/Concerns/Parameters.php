<?php

namespace LaravelLang\StatusGenerator\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;
use LaravelLang\StatusGenerator\Constants\Option;
use LaravelLang\StatusGenerator\Exceptions\UnknownOptionException;

/** @mixin \LaravelLang\StatusGenerator\Processors\Processor */
trait Parameters
{
    protected function parameter(string $name, bool $allow_empty = false): mixed
    {
        $value = Arr::get($this->parameters, $name);

        if ($allow_empty || ! empty($value)) {
            return $value;
        }

        throw new UnknownOptionException($name);
    }

    protected function getCopyParameter(): array
    {
        return $this->parameter(Option::COPY(), true);
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
