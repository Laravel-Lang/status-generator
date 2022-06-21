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

            $this->assertSame(array_keys($source['php']), array_keys($values['php']));
            $this->assertSame(array_keys($source['php-inline']), array_keys($values['php-inline']));

            $this->assertSame(array_keys($source['json']), array_keys($values['json']));
            $this->assertSame(array_keys($source['json-inline']), array_keys($values['json-inline']));
        }
    }

    public function testInline(): void
    {
        foreach ($this->locales() as $locale) {
            $values = $this->locale($locale);

            $this->assertDoesntSee(array_values($values['json-inline']), [':attribute', ':Attribute'], 'locales/de/json-inline.json');
            $this->assertDoesntSee(array_values($values['php-inline']), [':attribute', ':Attribute'], 'locales/de/php-inline.json');
        }
    }
}
