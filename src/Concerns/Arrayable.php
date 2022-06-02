<?php

namespace LaravelLang\StatusGenerator\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;

trait Arrayable
{
    protected function ksort(array $array): array
    {
        return Arr::ksort($array);
    }
}
