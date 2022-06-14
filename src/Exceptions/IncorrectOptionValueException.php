<?php

namespace LaravelLang\StatusGenerator\Exceptions;

use Exception;

class IncorrectOptionValueException extends Exception
{
    public function __construct(string $name)
    {
        parent::__construct("Option \"$name\" is not defined or has an empty value.", 500);
    }
}
