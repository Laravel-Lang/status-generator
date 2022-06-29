<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Sync;

class GermanTest extends Base
{
    public function testJson(): void
    {
        $this->assertJsonFileEqualsJson([
            'Added.'        => 'Hinzugefügt.',
            'Administrator' => 'Administrator',
        ], 'locales/de/json.json', __FUNCTION__);
    }

    public function testPhp(): void
    {
        $this->assertJsonFileEqualsJson([
            '0'             => 'Numerische Null',
            '10'            => 'Numerische Zehn',
            '100'           => 'Numerisch Hundert',
            'accepted'      => ':Attribute muss akzeptiert werden.',
            'accepted_if'   => ':Attribute muss akzeptiert werden, wenn :other :value ist.',
            'active_url'    => ':Attribute ist keine gültige Internet-Adresse.',
            'between.array' => 'The :attribute must have between :min and :max items.',
            'between.file'  => 'The :attribute must be between :min and :max kilobytes.',
        ], 'locales/de/php.json', __FUNCTION__);
    }

    public function testPhpInline(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'      => 'Dieses Feld muss akzeptiert werden.',
            'accepted_if'   => 'Dieses Feld muss akzeptiert werden, wenn :other :value ist.',
            'active_url'    => 'Das ist keine gültige Internet-Adresse.',
            'between.array' => 'This field must have between :min and :max items.',
            'between.file'  => 'This field must be between :min and :max kilobytes.',
        ], 'locales/de/php-inline.json', __FUNCTION__);
    }

    public function testExcludes(): void
    {
        $this->assertFileExists($this->tempPath('locales/de/_excludes.json'));
    }
}
