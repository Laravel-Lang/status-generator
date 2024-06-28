<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Translate;

use LaravelLang\StatusGenerator\Constants\Command as CommandName;
use LaravelLang\Translator\Integrations\Google;
use Tests\TestCase;

abstract class Base extends TestCase
{
    protected ?string $fixtures = __DIR__ . '/../../../Fixtures/Resources/Translate';

    protected ?CommandName $call = CommandName::TRANSLATE;

    protected function setUp(): void
    {
        parent::setUp();

        app()->singleton(Google::class, fn () => new Google(
            new Google::$integration()
        ));
    }
}
