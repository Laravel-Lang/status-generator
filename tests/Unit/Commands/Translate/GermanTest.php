<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Translate;

/**
 * @group Translate
 */
class GermanTest extends Base
{
    public function testJson(): void
    {
        $this->assertJsonFileEqualsJson([
            'Added.' => 'Hinzugefügt.',
            'Administrator' => 'Administrator',
        ], 'locales/de/json.json', __FUNCTION__);
    }

    public function testPhp(): void
    {
        $values = $this->filesystem->load($this->tempPath('locales/de/php.json'));

        $this->assertContainsEquals($values[0], ['Numerische Null']);
        $this->assertContainsEquals($values[10], ['Numerische Zehn']);
        $this->assertContainsEquals($values[100], ['Numerisch Hundert']);

        $this->assertSame($values['accepted'], 'The :attribute must be accepted.');

        $this->assertContainsEquals(
            $values['accepted_if'],
            ['Die :attribute muss akzeptiert werden, wenn :other :value ist.', ':Attribute muss akzeptiert werden, wenn :other :value ist.']
        );

        $this->assertContainsEquals($values['active_url'], ['Die :attribute ist keine gültige URL.', ':Attribute ist keine gültige Internet-Adresse.']);

        $this->assertContainsEquals($values['between.array'], ['The :attribute must have between :min and :max items.']);
        $this->assertContainsEquals($values['between.file'], ['The :attribute must be between :min and :max kilobytes.']);
    }

    public function testPhpInline(): void
    {
        $values = $this->filesystem->load($this->tempPath('locales/de/php-inline.json'));

        $this->assertSame($values['accepted'], 'This field must be accepted.');

        $this->assertContainsEquals(
            $values['accepted_if'],
            ['Dieses Feld muss akzeptiert werden, wenn :other gleich :value ist.', 'Dieses Feld muss akzeptiert werden, wenn :other :value ist.']
        );

        $this->assertContainsEquals($values['active_url'], ['Dieses Feld ist keine gültige URL.', 'Das ist keine gültige Internet-Adresse.']);

        $this->assertContainsEquals($values['between.array'], ['This field must have between :min and :max items.']);
        $this->assertContainsEquals($values['between.file'], ['This field must be between :min and :max kilobytes.']);
    }

    public function testExcludes(): void
    {
        $this->assertFileExists($this->tempPath('locales/de/_excludes.json'));
    }
}
