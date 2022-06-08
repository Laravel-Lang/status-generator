<?php

namespace Tests\Fixtures\Services;

use DragonCode\Support\Facades\Helpers\Arr;
use Tests\Fixtures\Models\CommandResult;

class Command
{
    public static function call(string $name, array $options = []): CommandResult
    {
        exec(sprintf('php %s %s %s', self::bin(), $name, self::options($options)), $output, $code);

        return CommandResult::make(compact('output', 'code'));
    }

    protected static function bin(): string
    {
        return realpath(__DIR__ . '/../../../bin/lang');
    }

    protected static function options(array $options): string
    {
        return Arr::of($options)
            ->filter()
            ->map(static fn (string $value, string $key) => sprintf('--%s="%s"', $key, $value))
            ->implode(' ');
    }
}
