<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Exceptions;

use Exception;

class LocaleAlreadyExistException extends Exception
{
    public function __construct(string $locale)
    {
        parent::__construct("The \"$locale\" locale already exist.", 500);
    }
}
