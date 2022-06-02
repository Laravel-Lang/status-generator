<?php

namespace LaravelLang\StatusGenerator\Exceptions;

use RuntimeException;

class IncorrectBasePathException extends RuntimeException
{
    public function __construct(string $path)
    {
        parent::__construct('Localization directories not found in the specified folder: ' . realpath($path));
    }
}
