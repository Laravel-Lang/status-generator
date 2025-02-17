<?php

declare(strict_types=1);

namespace LaravelLang\StatusGeneratorTests;

use LaravelLang\StatusGeneratorTests\Concerns\Assert;
use LaravelLang\StatusGeneratorTests\Concerns\Locales;
use LaravelLang\StatusGeneratorTests\Concerns\Path;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use Assert;
    use Locales;
    use Path;

    public function testKeys(): void
    {
        foreach ($this->locales() as $locale) {
            $source = $this->source();
            $values = $this->locale($locale);

            $this->assertArray($source, $values, 'php', $locale);
            $this->assertArray($source, $values, 'php-inline', $locale);

            $this->assertArray($source, $values, 'json', $locale);
            $this->assertArray($source, $values, 'json-inline', $locale);
        }
    }

    public function testInline(): void
    {
        foreach ($this->locales() as $locale) {
            $values = $this->locale($locale);

            $this->assertDoesntSee(array_values($values['json-inline'] ?? []), [':attribute', ':Attribute'], "locales/$locale/json-inline.json");
            $this->assertDoesntSee(array_values($values['php-inline'] ?? []), [':attribute', ':Attribute'], "locales/$locale/php-inline.json");
        }
    }

    public function testExcludes(): void
    {
        foreach ($this->locales() as $locale) {
            $source   = $this->source();
            $excludes = $this->excludes($locale);

            ! empty($excludes)
                ? $this->assertExcludes($locale, $source, $excludes)
                : $this->assertTrue(true);
        }
    }
}
