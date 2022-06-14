<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Concerns\Commands;

use LaravelLang\StatusGenerator\Exceptions\IncorrectOptionValueException;

/** @mixin \LaravelLang\StatusGenerator\Commands\Command */
trait ValidateOptions
{
    protected function validateOptions(): void
    {
        foreach ($this->getDefinition()->getOptions() as $name => $option) {
            $value = $this->input->getOption($name);

            if ($option->isValueRequired() && empty($value)) {
                throw new IncorrectOptionValueException($name);
            }
        }
    }
}
