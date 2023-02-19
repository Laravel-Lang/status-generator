<?php

declare(strict_types=1);

namespace Tests\Unit\Commands\Translate;

/**
 * @group Translate
 */
class ArabicTest extends Base
{
    public function testJson(): void
    {
        $this->assertJsonFileEqualsJson([
            'Added.'        => 'مضاف.',
            'Administrator' => 'Administrator',

            'Uploading files... (:current/:total)' => 'جاري تحميل الملفات ... (:current/:total)',
        ], 'locales/ar/json.json', __FUNCTION__);
    }

    public function testPhp(): void
    {
        $values = $this->filesystem->load($this->tempPath('locales/ar/php.json'));

        $this->assertContainsEquals($values[0], ['رقمي صفر']);
        $this->assertContainsEquals($values[10], ['رقم عشرة']);
        $this->assertContainsEquals($values[100], ['مائة رقمية']);

        $this->assertSame($values['accepted'], 'The :attribute must be accepted.');

        $this->assertContainsEquals($values['accepted_if'], ['يجب قبول :attribute عندما تكون :other هي :value.', 'يجب قبول :attribute عندما يكون :other هو :value.']);

        $this->assertContainsEquals($values['active_url'], [':attribute ليس عنوان URL صالحًا.']);

        $this->assertContainsEquals($values['between.array'], ['The :attribute must have between :min and :max items.']);
        $this->assertContainsEquals($values['between.file'], ['The :attribute must be between :min and :max kilobytes.']);
    }

    public function testPhpInline(): void
    {
        $values = $this->filesystem->load($this->tempPath('locales/ar/php-inline.json'));

        $this->assertSame($values['accepted'], 'This field must be accepted.');

        $this->assertContainsEquals($values['accepted_if'], ['يجب قبول هذا الحقل عندما يكون :other هو :value.']);

        $this->assertContainsEquals($values['active_url'], ['هذا الحقل ليس عنوان URL صالحًا.']);

        $this->assertContainsEquals($values['between.array'], ['This field must have between :min and :max items.']);
        $this->assertContainsEquals($values['between.file'], ['This field must be between :min and :max kilobytes.']);
    }

    public function testExcludes(): void
    {
        $this->assertFileExists($this->tempPath('locales/ar/_excludes.json'));
    }
}
