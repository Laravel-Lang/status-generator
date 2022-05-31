<?php

namespace LaravelLang\StatusGenerator\Contracts;

use LaravelLang\StatusGenerator\Application;

interface Processable
{
    public function run(): void;

    public function application(Application $app): self;
}
