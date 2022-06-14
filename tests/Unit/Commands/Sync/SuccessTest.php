<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Sync;

class SuccessTest extends Base
{
    public function testJson(): void
    {
        $this->assertSame([
            "Added."        => "Hinzugefügt.",
            "Administrator" => "Administrator",
        ], $this->filesystem->load($this->tempPath('locales/de/json.json')));

        $this->assertSame([
            "Added."        => "Added.",
            "Administrator" => "Administrator",
        ], $this->filesystem->load($this->tempPath('locales/en/json.json')));
    }

    public function testPhp(): void
    {
        $this->assertSame([
            "accepted"      => ":Attribute muss akzeptiert werden.",
            "accepted_if"   => ":Attribute muss akzeptiert werden, wenn :other :value ist.",
            "active_url"    => ":Attribute ist keine gültige Internet-Adresse.",
            'between.array' => 'The :attribute must have between :min and :max items.',
            'between.file'  => 'The :attribute must be between :min and :max kilobytes.',
        ], $this->filesystem->load($this->tempPath('locales/de/php.json')));

        $this->assertSame([
            "accepted"      => "The :attribute must be accepted.",
            "accepted_if"   => "The :attribute must be accepted when :other is :value.",
            "active_url"    => "The :attribute is not a valid URL.",
            'between.array' => 'The :attribute must have between :min and :max items.',
            'between.file'  => 'The :attribute must be between :min and :max kilobytes.',
        ], $this->filesystem->load($this->tempPath('locales/en/php.json')));
    }

    public function testPhpInline(): void
    {
        $this->assertSame([
            "accepted"      => "Dieses Feld muss akzeptiert werden.",
            "accepted_if"   => "Dieses Feld muss akzeptiert werden, wenn :other :value ist.",
            "active_url"    => "Das ist keine gültige Internet-Adresse.",
            'between.array' => 'This field must have between :min and :max items.',
            'between.file'  => 'This field must be between :min and :max kilobytes.',
        ], $this->filesystem->load($this->tempPath('locales/de/php-inline.json')));

        $this->assertSame([
            "accepted"      => "This field must be accepted.",
            "accepted_if"   => "This field must be accepted when :other is :value.",
            "active_url"    => "This field is not a valid URL.",
            'between.array' => 'This field must have between :min and :max items.',
            'between.file'  => 'This field must be between :min and :max kilobytes.',
        ], $this->filesystem->load($this->tempPath('locales/en/php-inline.json')));
    }
}
