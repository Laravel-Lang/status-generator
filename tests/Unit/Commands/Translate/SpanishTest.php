<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Translate;

/**
 * @group Translate
 */
class SpanishTest extends Base
{
    public function testJson(): void
    {
        $values = $this->filesystem->load($this->tempPath('locales/es/json.json'));

        $this->assertContainsEquals($values['Added.'], ['Agregado.']);
        $this->assertContainsEquals($values['Administrator'], ['Administrator']);

        $this->assertContainsEquals($values['Uploading files... (:current/:total)'], ['Subiendo archivos... (:total/:current)', 'Subiendo archivos... (:current/:total)']);
    }

    public function testPhp(): void
    {
        $values = $this->filesystem->load($this->tempPath('locales/es/php.json'));

        $this->assertContainsEquals($values[0], ['Cero numérico', 'cero numérico']);
        $this->assertContainsEquals($values[10], ['Numérico Diez']);
        $this->assertContainsEquals($values[100], ['Cent numérique', 'Numérico Cien']);

        $this->assertSame($values['accepted'], 'The :attribute must be accepted.');

        $this->assertContainsEquals(
            $values['accepted_if'],
            ['El campo :attribute debe ser aceptado cuando :other sea :value.', 'El :attribute debe aceptarse cuando :other es :value.']
        );

        $this->assertContainsEquals($values['active_url'], ['El campo :attribute debe ser una URL válida.', 'El :attribute no es una URL válida.']);

        $this->assertContainsEquals($values['between.array'], ['The :attribute must have between :min and :max items.']);
        $this->assertContainsEquals($values['between.file'], ['The :attribute must be between :min and :max kilobytes.']);
    }

    public function testPhpInline(): void
    {
        $values = $this->filesystem->load($this->tempPath('locales/es/php-inline.json'));

        $this->assertSame($values['accepted'], 'This field must be accepted.');

        $this->assertContainsEquals($values['accepted_if'], ['Este campo debe ser aceptado cuando :other sea :value.', 'Este campo debe aceptarse cuando :other es :value.']);

        $this->assertContainsEquals($values['active_url'], ['Este campo debe ser una URL válida.', 'Este campo no es una URL válida.']);

        $this->assertContainsEquals($values['between.array'], ['This field must have between :min and :max items.']);
        $this->assertContainsEquals($values['between.file'], ['This field must be between :min and :max kilobytes.']);
    }

    public function testExcludes(): void
    {
        $this->assertFileExists($this->tempPath('locales/es/_excludes.json'));
    }
}
