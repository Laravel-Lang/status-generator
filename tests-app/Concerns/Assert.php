<?php

declare(strict_types=1);

namespace LaravelLang\StatusGeneratorTests\Concerns;

use DragonCode\Support\Facades\Helpers\Str;

trait Assert
{
    protected function assertSee(array $haystack, array|string $needles, string $path): void
    {
        $this->assertSeeOrNot($haystack, $needles, $path, true);
    }

    protected function assertDoesntSee(array $haystack, array|string $needles, string $path): void
    {
        $this->assertSeeOrNot($haystack, $needles, $path, false);
    }

    protected function assertSeeOrNot(array $haystack, array|string $needles, string $path, bool $has_see): void
    {
        $base_path = Str::after($path, rtrim($this->base_path, '\\/') . '/');

        foreach ($haystack as $item) {
            foreach ((array) $needles as $needle) {
                $has_see
                    ? $this->assertTrue(str_contains($item, $needle), "The $base_path file must contain the value: $needle\n$item")
                    : $this->assertFalse(str_contains($item, $needle), "The $base_path file must not contain the value: $needle\n$item");
            }
        }
    }
}
