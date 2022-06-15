<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Status;

class FrenchTest extends Base
{
    public function testHeaders(): void
    {
        $content = file_get_contents($this->tempPath('docs/statuses/fr.md'));

        $this->assertStringNotContainsString('### json', $content);
        $this->assertStringNotContainsString('### json-inline', $content);

        $this->assertStringNotContainsString('### php', $content);
        $this->assertStringNotContainsString('### php-inline', $content);
    }

    public function testJson()
    {
        $content = file_get_contents($this->tempPath('docs/statuses/fr.md'));

        $this->assertStringContainsString('All lines are translated', $content);
    }
}
