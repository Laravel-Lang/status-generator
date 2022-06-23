<?php

declare(strict_types=1);

namespace LaravelLang\StatusGeneratorTests\Concerns;

use DragonCode\Support\Facades\Helpers\Arr;
use DragonCode\Support\Facades\Helpers\Str;

trait Assert
{
    protected function assertDoesntSee(array $haystack, array|string $needles, string $path): void
    {
        $this->assertSeeOrNot($haystack, $needles, $path, false);
    }

    protected function assertSeeOrNot(array $haystack, array|string $needles, string $path, bool $has_see): void
    {
        if (empty($haystack)) {
            $this->assertTrue(true);

            return;
        }

        $base_path = Str::after($path, rtrim($this->base_path, '\\/') . '/');

        foreach ($haystack as $item) {
            foreach ((array) $needles as $needle) {
                $has_see
                    ? $this->assertTrue(str_contains($item, $needle), "The $base_path file must contain the value: $needle\n$item")
                    : $this->assertFalse(str_contains($item, $needle), "The $base_path file must not contain the value: $needle\n$item");
            }
        }
    }

    protected function assertArray(array $source, array $target, string $key, string $locale): void
    {
        if (! isset($source[$key])) {
            $this->assertTrue(true);

            return;
        }

        $locale = Str::upper($locale);

        $this->assertArrayHasKey($key, $source);
        $this->assertArrayHasKey($key, $target);

        $this->assertSame(
            array_keys($source[$key]),
            array_keys($target[$key]),
            "Detected key mismatch in $locale locale."
        );
    }

    protected function assertExcludes(string $locale, array $source, array $excludes): void
    {
        $source = Arr::flatten($source);

        $actual = array_intersect($excludes, $source);

        $this->assertSame($actual, $excludes, "Detected excludes key mismatch in $locale locale.");
    }
}
