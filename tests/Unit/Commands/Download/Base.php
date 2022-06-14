<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Download;

use Tests\TestCase;

abstract class Base extends TestCase
{
    protected ?string $fixtures = __DIR__ . '/../../../Fixtures/Resources/Download';
}
