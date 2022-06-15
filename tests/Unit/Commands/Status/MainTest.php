<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Status;

class MainTest extends Base
{
    public function testMain(): void
    {
        $content = file_get_contents($this->tempPath('docs/status.md'));

        $this->assertStringNotContainsString('[en&nbsp;✔](statuses/en.md)', $content);

        $this->assertStringContainsString('[de&nbsp;❗](statuses/de.md)', $content);
        $this->assertStringContainsString('[fr&nbsp;✔](statuses/fr.md)', $content);
    }
}
