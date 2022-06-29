<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Helpers;

class ArrayMerge
{
    public function merge(array $source, array $target): array
    {
        foreach ($target as $key => $value) {
            $source[$key] = $value;
        }

        return $source;
    }
}
