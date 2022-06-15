<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Status;

class GermanTest extends Base
{
    public function testHeaders(): void
    {
        $content = file_get_contents($this->tempPath('docs/statuses/de.md'));

        $this->assertStringNotContainsString('### [json]', $content);
        $this->assertStringNotContainsString('### [json-inline]', $content);

        $this->assertStringContainsString('### [php]', $content);
        $this->assertStringNotContainsString('### [php-inline]', $content);
    }

    public function testJson()
    {
        $content = file_get_contents($this->tempPath('docs/statuses/de.md'));

        $this->assertStringNotContainsString('Added.', $content);
        $this->assertStringNotContainsString('Hinzugefügt.', $content);

        $this->assertStringNotContainsString('Administrator', $content);
    }

    public function testPhp()
    {
        $content = file_get_contents($this->tempPath('docs/statuses/de.md'));

        $this->assertStringNotContainsString('accepted', $content);
        $this->assertStringNotContainsString(':Attribute muss akzeptiert werden.', $content);

        $this->assertStringNotContainsString('accepted_if', $content);
        $this->assertStringNotContainsString(':Attribute muss akzeptiert werden, wenn :other :value ist.', $content);

        $this->assertStringNotContainsString('active_url', $content);
        $this->assertStringNotContainsString(':Attribute ist keine gültige Internet-Adresse.', $content);

        $this->assertStringContainsString('between.array', $content);
        $this->assertStringContainsString('The :attribute must have between :min and :max items.', $content);

        $this->assertStringContainsString('between.file', $content);
        $this->assertStringContainsString('The :attribute must be between :min and :max kilobytes.', $content);
    }

    public function testPhpInline()
    {
        $content = file_get_contents($this->tempPath('docs/statuses/de.md'));

        $this->assertStringNotContainsString('accepted', $content);
        $this->assertStringNotContainsString(':Attribute muss akzeptiert werden.', $content);

        $this->assertStringNotContainsString('accepted_if', $content);
        $this->assertStringNotContainsString(':Attribute muss akzeptiert werden, wenn :other :value ist.', $content);

        $this->assertStringNotContainsString('active_url', $content);
        $this->assertStringNotContainsString(':Attribute ist keine gültige Internet-Adresse.', $content);

        $this->assertStringNotContainsString('between.array', $content);
        $this->assertStringNotContainsString('Dieser Inhalt muss zwischen :min & :max Elemente haben.', $content);

        $this->assertStringNotContainsString('between.file', $content);
        $this->assertStringNotContainsString('Diese Datei muss zwischen :min & :max Kilobytes groß sein.', $content);
    }
}
