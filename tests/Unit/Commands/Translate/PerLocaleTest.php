<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Translate;

/**
 * @group Translate
 */
class PerLocaleTest extends Base
{
    protected array $call_options = [
        '--locale' => 'de',
    ];

    public function testJson(): void
    {
        $this->assertJsonFileEqualsJson([
            'Added.'        => 'Hinzugefügt.',
            'Administrator' => 'Administrator',

            'Uploading files... (:current/:total)' => 'Dateien werden hochgeladen... (:current/:total)',
        ], 'locales/de/json.json', __FUNCTION__);

        $this->assertJsonFileEqualsJson([
            'Added.'        => 'Added.',
            'Administrator' => 'Administrator',
            'Foo'           => 'Foo',
            'Bar.'          => 'Bar.',

            'Uploading files... (:current/:total)' =>  'Uploading files... (:current/:total)',
        ], 'locales/fr/json.json', __FUNCTION__);
    }

    public function testPhp(): void
    {
        // German
        $values = $this->filesystem->load($this->tempPath('locales/de/php.json'));

        $this->assertContainsEquals($values[0], ['Numerische Null']);
        $this->assertContainsEquals($values[10], ['Numerische Zehn']);
        $this->assertContainsEquals($values[100], ['Numerisch Hundert']);

        // French
        $values = $this->filesystem->load($this->tempPath('locales/fr/php.json'));

        $this->assertContainsEquals($values[0], ['Numeric Zero']);
        $this->assertContainsEquals($values[10], ['Numeric Ten']);
        $this->assertContainsEquals($values[100], ['Numeric One Hundred']);
    }

    public function testPhpInline(): void
    {
        // German
        $values = $this->filesystem->load($this->tempPath('locales/de/php-inline.json'));

        $this->assertContainsEquals(
            $values['accepted_if'],
            ['Dieses Feld muss akzeptiert werden, wenn :other gleich :value ist.', 'Dieses Feld muss akzeptiert werden, wenn :other :value ist.']
        );

        $this->assertContainsEquals($values['active_url'], ['Dieses Feld ist keine gültige URL.', 'Das ist keine gültige Internet-Adresse.']);

        // French
        $values = $this->filesystem->load($this->tempPath('locales/fr/php-inline.json'));

        $this->assertSame($values['accepted_if'], 'This field must be accepted when :other is :value.');
        $this->assertSame($values['active_url'], 'This field is not a valid URL.');
    }
}
