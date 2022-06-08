<?php

namespace Tests\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;

/** @mixin \Tests\TestCase */
trait Commands
{
    protected function command(string $name, array $options = []): void
    {
        $input = $this->compileOptions($options);

        $bin = realpath(__DIR__ . '/../../bin/lang');

        exec(sprintf('php %s %s %s', $bin, $name, $input));
    }

    protected function compileOptions(array $options): string
    {
        return Arr::of($options)
            ->filter()
            ->map(static fn (string $value, string $key) => sprintf('--%s="%s"', $key, $value))
            ->implode(' ');
    }
}
