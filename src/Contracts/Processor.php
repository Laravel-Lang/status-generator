<?php

namespace LaravelLang\StatusGenerator\Contracts;

use LaravelLang\StatusGenerator\Helpers\Output;

interface Processor
{
    public function __construct(
        Output $output,
        string $base_path,
        array $parameters = []
    );

    public function handle(): void;
}
