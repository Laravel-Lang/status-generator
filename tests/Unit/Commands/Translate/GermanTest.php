<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Translate;

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
            'accepted'      => 'Die :attribute muss akzeptiert werden.',
            'accepted_if'   => 'Die :attribute muss akzeptiert werden, wenn :other :value ist.',
            'active_url'    => 'Die :attribute ist keine gültige URL.',
            'between.array' => 'The :attribute must have between :min and :max items.',
            'between.file'  => 'The :attribute must be between :min and :max kilobytes.',
        ], 'locales/de/php.json', __FUNCTION__);
    }

    public function testPhpInline(): void
    {
        $this->assertJsonFileEqualsJson([
            'accepted'      => 'Dieses Feld muss akzeptiert werden.',
            'accepted_if'   => 'Dieses Feld muss akzeptiert werden, wenn :other gleich :value ist.',
            'active_url'    => 'Dieses Feld ist keine gültige URL.',
            'between.array' => 'This field must have between :min and :max items.',
            'between.file'  => 'This field must be between :min and :max kilobytes.',
        ], 'locales/de/php-inline.json', __FUNCTION__);
    }

    public function testExcludes(): void
    {
        $this->assertFileExists($this->tempPath('locales/de/_excludes.json'));
    }
}
