<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Translate;

/**
 * @group Translate
 */
class FrenchTest extends Base
{
    public function testJson(): void
    {
        $this->assertJsonFileEqualsJson([
            'Added.'        => 'Ajoutée.',
            'Administrator' => 'Administrator',

            'Uploading files... (:current/:total)' => 'Téléchargement de fichiers... (:current/:total)',
        ], 'locales/fr/json.json', __FUNCTION__);
    }

    public function testPhp(): void
    {
        $values = $this->filesystem->load($this->tempPath('locales/fr/php.json'));

        $this->assertContainsEquals($values[0], ['Zéro numérique']);
        $this->assertContainsEquals($values[10], ['Dix numériques']);
        $this->assertContainsEquals($values[100], ['Cent numérique']);

        $this->assertSame($values['accepted'], 'The :attribute must be accepted.');

        $this->assertContainsEquals($values['accepted_if'], ['Le :attribute doit être accepté quand :other vaut :value.']);

        $this->assertContainsEquals($values['active_url'], ['Le :attribute n\'est pas une URL valide.']);

        $this->assertContainsEquals($values['between.array'], ['The :attribute must have between :min and :max items.']);
        $this->assertContainsEquals($values['between.file'], ['The :attribute must be between :min and :max kilobytes.']);
    }

    public function testPhpInline(): void
    {
        $values = $this->filesystem->load($this->tempPath('locales/fr/php-inline.json'));

        $this->assertSame($values['accepted'], 'This field must be accepted.');

        $this->assertContainsEquals($values['accepted_if'], ['Ce champ doit être accepté lorsque :other vaut :value.']);

        $this->assertContainsEquals($values['active_url'], ['Ce champ n\'est pas une URL valide.']);

        $this->assertContainsEquals($values['between.array'], ['This field must have between :min and :max items.']);
        $this->assertContainsEquals($values['between.file'], ['This field must be between :min and :max kilobytes.']);
    }

    public function testExcludes(): void
    {
        $this->assertFileExists($this->tempPath('locales/fr/_excludes.json'));
    }
}
