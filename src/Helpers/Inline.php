<?php

declare(strict_types=1);

namespace LaravelLang\StatusGenerator\Helpers;

use DragonCode\Support\Facades\Helpers\Str;

class Inline
{
    protected array $replaces = [
        [
            'The :attribute' => 'This field',
            'The :Attribute' => 'This field',
            'The :ATTRIBUTE' => 'This field',
        ],

        [
            ':attribute' => 'field',
            ':Attribute' => 'field',
            ':ATTRIBUTE' => 'field',
        ],

        [
            'field field' => 'field',
        ],
    ];

    public function resolve(string $string): string
    {
        foreach ($this->replaces as $replaces) {
            $string = $this->replace($string, $replaces);
        }

        return $string;
    }

    protected function replace(string $string, array $replaces): string
    {
        return Str::replace($string, array_keys($replaces), array_values($replaces));
    }
}
