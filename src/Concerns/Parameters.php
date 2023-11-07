<?php

namespace LaravelLang\StatusGenerator\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;
use LaravelLang\StatusGenerator\Constants\Option;

/** @mixin \LaravelLang\StatusGenerator\Processors\Processor */
trait Parameters
{
    protected function parameter(string $name): array|string|null
    {
        return Arr::get($this->parameters, $name);
    }

    protected function getCopyParameter(): ?array
    {
        return $this->parameter(Option::COPY());
    }

    protected function getDirectoryParameter(): ?string
    {
        return $this->parameter(Option::DIRECTORY());
    }

    protected function getFileParameter(): ?string
    {
        return $this->parameter(Option::FILE());
    }

    protected function getLocaleParameter(): ?string
    {
        return Str::replace($this->parameter(Option::LOCALE()), '-', '_');
    }

    protected function getProjectParameter(): ?string
    {
        return $this->parameter(Option::PROJECT());
    }

    protected function getUrlParameter(): ?string
    {
        return $this->parameter(Option::URL());
    }

    protected function getVersionParameter(): ?string
    {
        return $this->parameter(Option::VERSION());
    }

    protected function getColumnsParameter(): int
    {
        $columns = (int) $this->parameter(Option::COLUMNS());

        return max(2, min(abs($columns), 36));
    }

    protected function hasMissingLocales(): bool
    {
        return empty($this->getLocaleParameter());
    }
}
