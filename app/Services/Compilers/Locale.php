<?php

namespace LaravelLang\StatusGenerator\Services\Compilers;

use LaravelLang\StatusGenerator\Constants\Resource;

class Locale extends Compiler
{
    public function __toString(): string
    {
        return $this->template(Resource::LOCALE, $this->items);
    }
}
